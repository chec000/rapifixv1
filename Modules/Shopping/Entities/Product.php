<?php

namespace Modules\Shopping\Entities;

use Auth;
use Modules\Admin\Entities\CountryLanguage;
use Session;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\CountryTranslation;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sku','global_name','is_kit','active','last_modifier_id','created_at','updated_at','delete'];


    /**
     * Crea o edita la information del product
     * @param  int $id
     * @param  int $sku
     * @param  boolean $is_kit
     * @param  boolean $active
     * @return int $product
     */
    static function saveInfo($id, $sku, $is_kit, $globalName, $active)
    {
        if ($id == null)
        {
            $product = Product::updateOrCreate(
                ['sku' => $sku],
                ['is_kit' => $is_kit, 'active' => $active, 'global_name' => $globalName, 'last_modifier_id' => Auth::user()->id]
            );
        }
        else
        {
            $product = Product::updateOrCreate(
                ['id' => $id],
                ['sku' => $sku, 'is_kit' => $is_kit, 'active' => $active, 'last_modifier_id' => Auth::user()->id]
            );
        }
        return $product->id;
    }


    /**
     * Regresa los datos del product para realizar su edition
     * @param  int $id
     * @return array $info
     */
    static function returnInfo($id)
    {
        //Se optiene la informacion del producto
        $product = Product::where('id', $id)->where('delete', 0)->first();
        //Se optiene la informaicon de la marca del producto
        $brandProduct = BrandProduct::join('glob_brand_translations', 'shop_brand_products.brand_id', '=', 'glob_brand_translations.brand_id')
            ->where('product_id',$id)->where('glob_brand_translations.locale',Session::get('adminLocale'))->first();
        //Se optiene el detalle del producto por pais y por idioma.
        $countryProduct = CountryProduct::infoProductTranslation($id);

        $info = [
            'id'         => $product->id,
            'sku'        => $product->sku,
            'globalName' => $product->global_name,
            'isKit'      => $product->is_kit,
            'brandId'    => $brandProduct->brand_id,
            'brandName'  => $brandProduct->name,
            'active'     => $product->active,
            'countries'  => $countryProduct,
        ];
        return $info;
    }

    /**
     * Regresa los datos del product para realizar su edition
     * @param  int $id
     * @return array $info
     */
    static function userPermissionCountryLanguage()
    {
        $userCountryPermission = [];
        $userCountry = CountryTranslation::whereIn('country_id', User::userCountriesPermission())
            ->where('locale',Session::get('adminLocale'))
            ->get();
        if($userCountry != null)
        {
            foreach ($userCountry as $c)
            {
                /*$countryCategoriesLang = Group::select('shop_country_groups.id','shop_group_translations.name')
                    ->join('shop_country_groups', 'shop_country_groups.group_id', '=', 'shop_groups.id')
                    ->join('shop_group_translations', 'shop_group_translations.country_group_id', '=', 'shop_country_groups.id')
                    ->where('shop_groups.type','Categories')
                    ->where('shop_country_groups.country_id', $c->country_id)
                    ->where('shop_country_groups.active',1)
                    ->where('shop_group_translations.locale', Session::get('adminLocale'))
                    ->get();*/
                $countryCategoriesLang = GroupCountry::where('group_id', 1)->where('country_id', $c->country_id)->get();
                $countriesLang = CountryLanguage::select('glob_languages.id','glob_language_translations.language as name','glob_languages.locale_key as localeKey')
                    ->join('glob_languages', 'glob_country_languages.language_id', '=', 'glob_languages.id')
                    ->join('glob_language_translations', 'glob_languages.id', '=', 'glob_language_translations.language_id')
                    ->where('glob_country_languages.country_id', $c->country_id)
                    ->where('glob_language_translations.locale', Session::get('adminLocale'))
                    ->get();
                array_push($userCountryPermission, ['id' => $c->country_id, 'name' => $c->name, 'languages'=> $countriesLang, 'categories'=>$countryCategoriesLang]);
            }
        }
        return $userCountryPermission;
    }

    static function userPermissionBrandsLanguage()
    {
         return User::userBrandsPermission();
    }

    public function getCountryProducts() {
        return CountryProduct::where('product_id', $this->id)->get();
    }

    public function getCountryProduct($countryId) {
    return CountryProduct::where('product_id', $this->id)->where('country_id', $countryId)->first();
    }

    public function countryProducts() {
        return $this->hasMany('Modules\Shopping\Entities\CountryProduct', 'product_id', 'id');
    }

    public function countryProduct() {
        return $this->hasMany('Modules\Shopping\Entities\CountryProduct')->where('country_id',$this->groupProduct->countryGroup->country_id);
    }

    public function groupProduct() {
        return $this->belongsTo('Modules\Shopping\Entities\GroupProduct', 'id', 'product_id');
    }

    public function brandProduct() {
        return $this->belongsTo('Modules\Shopping\Entities\BrandProduct', 'id', 'product_id');
    }

    public function complementaryProducts() {
        return $this->hasMany('Modules\Shopping\Entities\ComplementaryProducts', 'product_id', 'id');
        # return $this->belongsToMany('Modules\Shopping\Entities\Product', 'shop_complementary_products', 'product_id', 'product_related_id');
    }

    public function getCountriesAttribute() {
        $countries = [];
        $products  = CountryProduct::where('product_id', $this->id)->get();

        foreach ($products as $product) {
            $countries[] = [
                'country_id' => $product->country_id,
                'active' => $product->active,
                'name' => $product->country->name
            ];
        }

        return $countries;
    }
}