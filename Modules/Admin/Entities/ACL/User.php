<?php namespace Modules\Admin\Entities\ACL;

use Carbon\Carbon;
use Modules\Admin\Entities\BrandTranslation;
use Modules\Admin\Entities\CountryLanguage;
use Modules\Admin\Entities\CountryTranslation;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Notifications\NewAccount;
use Modules\Admin\Notifications\PasswordReset;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Auth;
use Eloquent;
use Hash;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\ProductTranslation;
use Modules\Shopping\Entities\GroupProduct;
use Request;
use Validator;
use Session;

class User extends Eloquent implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, Notifiable;

    protected $table = 'glob_users';
    protected $hidden = ['password', 'remember_token'];
    protected static $_aliases;

    public function language()
    {
        return $this->belongsTo('Modules\Admin\Entities\Language');
    }

    public function userBrands(){
        return $this->hasMany('Modules\Admin\Entities\ACL\UserBrands');
    }

    public function brands()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Brand', 'glob_user_brands', 'user_id', 'brand_id');
    }

    public function userCountries(){
        return $this->hasMany('Modules\Admin\Entities\ACL\UserCountries');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'glob_user_countries', 'user_id', 'country_id');
    }

    public function role()
    {
        return $this->belongsTo('Modules\Admin\Entities\ACL\UserRole');
    }

    public function change_password($tmp_code = null)
    {
        $tmp_check = false;
        if (!Auth::check()) {
            $code_created = new Carbon($this->tmp_code_created);
            $tmp_check = !empty($this->tmp_code) && $this->tmp_code == $tmp_code && $code_created->diff(new Carbon)->days <= 7;
            if (!$tmp_check) {
                FormMessage::add('tmp_code', 'The code was incorrect');
                return false;
            }
        }

        $details = Request::all();
        $rules = array('new_password' => 'required|confirmed|min:4');
        if (!($tmp_check || (Auth::check() && Auth::action('user.edit') && Auth::user()->id != $this->id))) {
            $rules['current_password'] = 'required';
        }

        $v = Validator::make($details, $rules);
        if ($v->passes()) {
            // check password
            if (!empty($rules['current_password']) && !Hash::check($details['current_password'], $this->password)) {
                FormMessage::add('current_password', 'The current password was incorrect');
                return false;
            }
            try {
                $this->updatePassword($details['new_password']);
                return true;
            } catch (\Exception $e) {
                FormMessage::add('new_password', $e->getMessage());
            }
        } else {
            FormMessage::set($v->messages());
        }
        return false;
    }

    public function getPageStates()
    {
        if (!empty($this->page_states)) {
            return unserialize($this->page_states);
        }
        return [];
    }

    public function savePageStates($pageStates)
    {
        $this->page_states = serialize($pageStates);
        $this->save();
    }

    public function getName()
    {
        return $this->name ?: $this->email;
    }

    public static function userAliases()
    {
        if (!isset(self::$_aliases)) {
            self::$_aliases = [];
            foreach (User::all() as $user) {
                self::$_aliases[$user->id] = $user->name ?: $user->email;
            }
        }
        return self::$_aliases;
    }

    public function delete()
    {
        $log_id = AdminLog::new_log('User \'' . $this->email . '\' deleted');
        Backup::new_backup($log_id, '\Modules\Admin\Entities\ACL\User', $this);

        // delete data
        parent::delete();

        return $log_id;
    }

    /**
     * @param string $tmpCode
     * @return $this
     * @throws \Exception
     */
    public static function findFromTmpCode($tmpCode)
    {
        if ($tmpCode && $user = User::where('tmp_code', '=', $tmpCode)->first()) {
            $code_created = new Carbon($user->tmp_code_created);
            $di = $code_created->diff(new Carbon('now'));
            if ($di->days > 7) {
                throw new \Exception('This code has expired!');
            }
            return $user;
        }
        throw new \Exception('Invalid Code!');
    }

    /**
     * @param string $routeName
     */
    public function sendPasswordResetNotification($routeName = 'admin.login.password.change')
    {
        $this->tmp_code = urlencode(str_random(32) . microtime());
        $this->tmp_code_created = new Carbon();
        $this->save();
        $this->notify(new PasswordReset($this, $routeName));
    }

    /**
     * @param string $password
     * @param bool $ignoreChecks
     * @throws \Exception
     */
    public function updatePassword($password, $ignoreChecks = false)
    {
        // update only if users account has update password action or logged in user has admin user edit permissions
        if ($ignoreChecks || Auth::action('account.password', ['user_id' => $this->id]) || (Auth::check() && Auth::action('user.edit'))) {
            $this->password = Hash::make($password);
            $this->tmp_code = '';
            $this->save();
        } else {
            throw new \Exception('Can\'t update account password');
        }
    }

    /**
     * @param string $password
     * @param string $routeName
     */
    public function sendNewAccountNotification($password, $routeName = 'admin.login')
    {
        $this->notify(new NewAccount($this, $password, $routeName));
    }

    /**
     * @return array $userCountriesPermission
     */
    static function userCountriesPermission()
    {
        $userCountriesPermission = [];

        foreach (Auth::user()->userCountries as $uC)
        {
            array_push($userCountriesPermission, $uC->country_id );
        }

        return $userCountriesPermission;
    }

    /**
     * @return array $userCountriesPermission
     */
    static function userBrandId()
    {
        $userBrandPer = [];
        foreach (Auth::user()->userBrands as $uB)
        {
            array_push($userBrandPer, $uB->brand_id );
        }
        return $userBrandPer;
    }

    /**
     * @param $id
     * @return mixed
     */
    static function productCountry($id)
    {
        $productQuery = CountryProduct::select('shop_country_products.id','shop_products.sku', 'shop_products.id as pid', 'shop_products.global_name')
            ->join('shop_products', 'shop_country_products.product_id', '=', 'shop_products.id')
            ->where('shop_country_products.country_id',$id)
            ->get();
        foreach ($productQuery as $pQ){
            $nameProduct = ProductTranslation::where('country_product_id',$pQ->id)->where('locale',Session::get('adminLocale'))->first();
            if(isset($nameProduct)){
                $pQ->name = $nameProduct->name;
            }else{
                $pQ->name = "";
            }
        }
        return $productQuery;
    }

    static function activeProductsByCountry($id)
    {
        $productQuery = CountryProduct::select('shop_country_products.id','shop_products.sku', 'shop_products.id as pid', 'shop_products.global_name')
            ->join('shop_products', 'shop_country_products.product_id', '=', 'shop_products.id')
            ->where('shop_country_products.country_id',$id)
            ->where('shop_country_products.active', 1)
            ->where('shop_country_products.delete', 0)
            ->where('shop_products.active', 1)
            ->where('shop_products.delete', 0)
            ->where('shop_products.is_kit', 0)
            ->get();
        foreach ($productQuery as $pQ){
            $nameProduct = ProductTranslation::where('country_product_id',$pQ->id)->where('locale',Session::get('adminLocale'))->first();
            if(isset($nameProduct)){
                $pQ->name = $nameProduct->name;
            }else{
                $pQ->name = "";
            }
        }
        return $productQuery;
    }

    static function productCategoryCountry($idCategory)
    {
        $product = GroupProduct::select('shop_products.id','shop_products.sku','shop_group_products.product_id')
            ->join('shop_products','shop_group_products.product_id','shop_products.id')
            ->where('shop_group_products.country_group_id', $idCategory)
            ->where('shop_group_products.active', 1)
            ->get();
        foreach ($product as $p){
            $nameProduct = ProductTranslation::where('country_product_id',$p->id)->where('locale',Session::get('adminLocale'))->first();
            $p->name = "";
            if(isset($nameProduct)){ $p->name = $nameProduct->name; }
        }
        return $product;
    }

    static function productsByCountryAndBrand($countryId, $brandId) {
        $productQuery = CountryProduct::select('shop_products.id','shop_products.sku')
            ->join('shop_products', 'shop_country_products.product_id', '=', 'shop_products.id')
            ->join('shop_brand_products', 'shop_brand_products.product_id', '=', 'shop_products.id')
            ->where('shop_country_products.country_id', $countryId)
            ->where('shop_brand_products.brand_id', $brandId)
            ->get();

        foreach ($productQuery as $pQ) {
            $nameProduct = ProductTranslation::where('country_product_id', $pQ->id)->where('locale', Session::get('adminLocale'))->first();
            if (isset($nameProduct)) {
                $pQ->name = $nameProduct->name;
            } else {
                $pQ->name = "";
            }
        }

        return $productQuery;
    }

    static function productsByCountryAndBrand2($countryId, $brandId) {
        $productQuery = CountryProduct::select('shop_country_products.*', 'shop_products.sku', 'shop_products.global_name')
            ->join('shop_products', 'shop_country_products.product_id', '=', 'shop_products.id')
            ->join('shop_brand_products', 'shop_brand_products.product_id', '=', 'shop_products.id')
            ->where('shop_country_products.country_id', $countryId)
            ->where('shop_brand_products.brand_id', $brandId)
            ->get();

        return $productQuery;
    }

    static function activeProductsByCountryAndBrand($countryId, $brandId) {
        $productQuery = CountryProduct::select('shop_country_products.*', 'shop_products.sku', 'shop_products.global_name')
            ->join('shop_products', 'shop_country_products.product_id', '=', 'shop_products.id')
            ->join('shop_brand_products', 'shop_brand_products.product_id', '=', 'shop_products.id')
            ->where('shop_country_products.country_id', $countryId)
            ->where('shop_brand_products.brand_id', $brandId)
            ->where('shop_products.active', 1)
            ->where('shop_products.delete', 0)
            ->where('shop_country_products.active', 1)
            ->where('shop_country_products.delete', 0)
            ->where('shop_products.is_kit', 0)
            ->get();

        return $productQuery;
    }

    static function productsByCountryGroup($idCategory)
    {
        $products = GroupProduct::select('shop_group_products.*', 'shop_products.sku')
            ->join('shop_country_products','shop_country_products.id','shop_group_products.product_id')
            ->join('shop_products','shop_country_products.product_id','shop_products.id')
            ->where('shop_group_products.country_group_id', $idCategory)
            ->where('shop_group_products.active', 1)
            ->get();

        return $products;
    }

    /**
     * @param $id
     * @return mixed
     */
    static function getCountryLang($id)
    {
        return CountryLanguage::select('glob_languages.id','glob_languages.locale_key', 'glob_language_translations.language')
            ->join('glob_languages', 'glob_country_languages.language_id', 'glob_languages.id')
            ->join('glob_language_translations', 'glob_languages.id', 'glob_language_translations.language_id')
            ->where('glob_country_languages.country_id', $id)
            ->where('glob_language_translations.locale', Session::get('adminLocale'))
            ->get();
    }

    /**
     * @param $id
     * @param $locale
     * @return mixed
     */
    static function getNameCountry($id, $locale)
    {
        return CountryTranslation::select('name')->where('country_id', $id)
            ->where('locale', $locale)
            ->first();
    }

    /**
     * @param $id
     * @param $locale
     * @return mixed
     */
    static function getNameBrand($id, $locale)
    {
        $nameBrand =  BrandTranslation::select('name')->where('brand_id', $id)
            ->where('locale', $locale)
            ->first();
        if(isset($nameBrand->name)){$name = $nameBrand->name;}else{$name = "";}
        return $name;
    }

    /**
     * @return array $userBrandsPermission
     */
    static function userBrandsPermission()
    {
        $userBrandsPermission = [];
        $brands = UserBrands::select('glob_user_brands.user_id','glob_user_brands.brand_id','glob_brands.id')
            ->join('glob_brands', 'glob_user_brands.brand_id', '=', 'glob_brands.id')
            ->where('glob_user_brands.user_id', Auth::user()->id)
            ->where('glob_brands.parent_brand_id', 0)
            ->get();
        foreach ($brands as $uB)
        {
            $nameBrand = BrandTranslation::select('name')->where('brand_id',$uB->brand_id)->where('locale', Session::get('adminLocale'))->first();
            if ($nameBrand == null)
                $nameBrand = BrandTranslation::select('name')->where('brand_id',$uB->brand_id)->first();
            array_push($userBrandsPermission, ['id'=>$uB->brand_id, 'name'=>  $nameBrand->name]);
        }
        return $userBrandsPermission;
    }
}
