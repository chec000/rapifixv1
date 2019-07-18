<?php

namespace Modules\Shopping\Entities;

use App\Helpers\SessionHdl;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\ACL\User;
use Session;

class GroupCountry extends Model
{
    use Translatable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_country_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id', 'group_id', 'code', 'color', 'global_name', 'link_banner', 'link_banner_two', 'product_id_featured','parent',
        'price', 'points', 'order', 'active', 'last_modifier_id', 'created_at', 'updated_at'];

    public $translationModel      = 'Modules\Shopping\Entities\GroupTranslations';

    public $translationForeignKey = 'country_group_id';

    public $translatedAttributes  = ['name','title','benefit','description','image_banner','slug','image'];

    /**
     * @param $code
     * @return mixed
     */
    static function getCountryGroup($code){
        return GroupCountry::select('shop_country_groups.id as categoryId', 'shop_country_groups.country_id as id',
            'glob_country_translations.name')
            ->join('glob_country_translations', 'shop_country_groups.country_id', 'glob_country_translations.country_id')
            ->whereIn('shop_country_groups.country_id', User::userCountriesPermission())
            ->where('shop_country_groups.code', $code)
            ->where('locale',Session::get('adminLocale'))
            ->get();
    }

    /**
     * @param $code
     * @return mixed
     */
    static function getTranslationCountryGroup($code){
        return GroupCountry::select('*', 'shop_country_groups.active as status','glob_languages.id as language_id',
            'shop_group_translations.id as landId', 'shop_group_translations.active as langAct')
            ->join('shop_group_translations','shop_country_groups.id','shop_group_translations.country_group_id')
            ->join('shop_brand_group','shop_country_groups.id','shop_brand_group.country_group_id')
            ->join('glob_languages','shop_group_translations.locale','glob_languages.locale_key')
            ->where('shop_country_groups.code',$code)->where('shop_group_translations.active','!=',-1)->get();
    }

    public static function getActiveByCountryAndBrand($countryId, $brandId) {
        $categories = GroupCountry::select('shop_country_groups.*', 'shop_brand_group.brand_id')
            ->join('shop_brand_group', 'shop_brand_group.country_group_id', 'shop_country_groups.id')
            ->where('shop_brand_group.brand_id', $brandId)
            ->where('shop_country_groups.country_id', $countryId)
            ->where('shop_country_groups.active', 1)
            ->where('shop_country_groups.group_id', 1)
            ->get();

        return $categories;
    }

    public static function getByCountriesAndBrands($countries, $brands, $group) {
        $categories = GroupCountry::select('shop_country_groups.*', 'shop_brand_group.brand_id')
            ->join('shop_brand_group', 'shop_brand_group.country_group_id', 'shop_country_groups.id')
            ->whereIn('shop_brand_group.brand_id', $brands)
            ->whereIn('shop_country_groups.country_id', $countries)
            ->where('shop_country_groups.group_id', $group)
            ->where('shop_country_groups.active', '!=', -1)
            ->groupBy('code')
            ->get();

        return $categories;
    }

    public static function getByCountryAndBrand($countryId, $brandId, $type, $order = false) {
        $categories = GroupCountry::select('shop_country_groups.*', 'shop_brand_group.brand_id')
            ->join('shop_brand_group', 'shop_brand_group.country_group_id', 'shop_country_groups.id')
            ->where('shop_brand_group.brand_id', $brandId)
            ->where('shop_country_groups.country_id', $countryId)
            ->where('shop_brand_group.brand_id', $brandId)
            ->where('shop_country_groups.parent', 0)
            ->where('shop_country_groups.active', 1)
            ->where('shop_country_groups.group_id', $type);

        if ($order) {
            $categories->orderBy('shop_country_groups.order', 'ASC')->orderBy('shop_country_groups.global_name', 'ASC');
        }

        return $categories->get();
    }

    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public function group() {
        return $this->belongsTo('Modules\Shopping\Entities\Group');
    }

    public function brandGroup() {
        return $this->belongsTo('Modules\Shopping\Entities\BrandGroup', 'id', 'country_group_id');
    }

    public function groupProducts() {
        return $this->hasMany('Modules\Shopping\Entities\GroupProduct', 'country_group_id', 'id');
    }

    public function categoryFilter() {
        return $this->hasOne('Modules\Shopping\Entities\CategoryFilter', 'filter_country_id', 'id');
    }


    public function getCountriesAttribute() {
        $groups = GroupCountry::select('shop_country_groups.*', 'shop_brand_group.brand_id')
            ->join('shop_brand_group', 'shop_brand_group.country_group_id', 'shop_country_groups.id')
            ->where('shop_country_groups.group_id', $this->group_id)
            ->where('shop_country_groups.code', $this->code)
            ->get();


        $countries = [];
        foreach ($groups as $group) {
            $countries[] = $group->country;
        }



        return collect($countries);
    }

    public function getActivesAttribute() {
        $active = 0;

        $groups = GroupCountry::select('shop_country_groups.*', 'shop_brand_group.brand_id')
            ->join('shop_brand_group', 'shop_brand_group.country_group_id', 'shop_country_groups.id')
            ->where('shop_country_groups.group_id', $this->group_id)
            ->where('shop_country_groups.code', $this->code)
            ->get();

        foreach ($groups as $group) {
            if ($group->active == 1) {
                $active = 1;
            }
        }

        return $active;
    }

    public function getLocaleNameAttribute() {
        $localeName = '';

        $groups = GroupCountry::where('code', $this->code)->get();

        foreach ($groups as $group) {
            if ($group->hasTranslation(Auth::user()->language->locale_key)) {
                return $group->translate(Auth::user()->language->locale_key)->name;
            }
        }

        return $localeName;
    }

    public function getSystemPriceAttribute() {
        $price = false;
        $warehouse = SessionHdl::getWarehouse();

        if ($this->group_id == 2) {
            $price = 0.0;

            foreach ($this->groupProducts->where('active', 1) as $groupProduct) {
                if (showCountryProduct($groupProduct->countryProduct, $warehouse) || showCountryProductByIP($groupProduct->countryProduct, $warehouse)) {
                    $price += $groupProduct->countryProduct->price;
                }
            }
        }

        return $price;
    }

    public function getHasProductsAttribute() {
        $products  = 0;
        $warehouse = SessionHdl::getWarehouse();

        foreach ($this->groupProducts->where('active', 1) as $groupProduct) {
            if (showCountryProduct($groupProduct->countryProduct, $warehouse) || showCountryProductByIP($groupProduct->countryProduct, $warehouse)) {
                $products++;
            }
        }

        return $products > 0;
    }

    public function areAllProductsActive    ($state = false) {
        $warehouse = SessionHdl::getWarehouse();
        $active    = true;

        if (!areShoppingAndWsActive() && !allow_by_ip()) {
            foreach ($this->groupProducts as $groupProduct) {
                if (($groupProduct->active == 0
                        || $groupProduct->countryProduct->active == 0
                        || $groupProduct->countryProduct->delete == 1
                        || $groupProduct->countryProduct->product->active == 0
                        || $groupProduct->countryProduct->product->delete == 1
                        || $groupProduct->countryProduct->isItRestrictedIn($state))) {

                    $active = false;
                }
            }
        } else {
            foreach ($this->groupProducts as $groupProduct) {

                if (($groupProduct->active == 0
                        || $groupProduct->countryProduct->active == 0
                        || $groupProduct->countryProduct->delete == 1
                        || $groupProduct->countryProduct->product->active == 0
                        || $groupProduct->countryProduct->product->delete == 1)
                        || !$groupProduct->countryProduct->belongsToWarehouse($warehouse)
                        || $groupProduct->countryProduct->isItRestrictedIn($state)) {

                    $active = false;
                }
            }
        }

        return $active;
    }

    public function getCountHomeProductsAttribute() {
        return GroupProduct::where('country_group_id', $this->id)
            ->whereHas('countryProduct', function ($q) {
                $q->where('active', 1);
                $q->where('delete', 0);
            })->where('active', 1)->where('product_home', 1)->count();
    }


    /*public function getGroup() {
        return Group::where('id', $this->group_id)->first();
    }

    public function getActiveGroupProducts() {
        return GroupProduct::where('country_group_id', $this->id)->where('active', 1)->get();
    }

    public function getActiveGroupProductsForCategory() {
        return GroupProduct::where('country_group_id', $this->id)->where('active', 1)->where('product_category', 1)->get();
    }

    public function getTranslations($locale) {
        return GroupTranslations::where('country_group_id', $this->id)->where('locale', $locale)->first();
    }*/
}
