<?php namespace Modules\Admin\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\Admin\Entities\ACL\User;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Modules\Admin\Entities\BrandTranslation;

class Brand extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['active','favicon','parent_brand_id','domain', 'is_dependent'];

    public $translatedAttributes = ['name', 'alias', 'logo'];
    protected $table = 'glob_brands';

 public function brandTraslations()
    {
        return $this->hasMany('Modules\Admin\Entities\BrandTranslation');
    }

    public  function brandCountry()
    {
        return $this->hasMany('Modules\Admin\Entities\BrandCountry');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'glob_brand_countries', 'brand_id', 'country_id')->wherePivot('active', 1);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }

    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToBrand', ['id'], 'name');
        return static::_preloadGetArray('idToBrand');
    }

    public static function selectArrayActive($brand = null)
    {
        $brands = [];
        $brandsActive = $brand != null ? $brand : self::where('active', '=', 1)->get();
        if(!empty($brandsActive)){
            foreach($brandsActive as $brand) {
                $brands[$brand->id] = $brand->name;
            }
        }
        return $brands;
    }

    public static function selectArrayBrandUseractive(){
        $brandsIdUser = User::userBrandId();
        $brands = [];
        $brandsActive = self::whereIn('id', $brandsIdUser)->where('active', '=', 1)->get();
        if(!empty($brandsActive)){
            foreach($brandsActive as $brand) {
                $brands[$brand->id] = $brand->name;
            }
        }
        return $brands;
    }

    public static function selectArrayBrandCountries($brandId = null)
    {
        $countries = [];
        $brandCountries = $brandId != null ? self::find($brandId) : [];
        if (!empty($brandCountries)) {
            foreach($brandCountries->brandCountry as $brandCountry) {
                $countries[$brandCountry->country->id] = $brandCountry->country->name;
            }
        }
        return $countries;
    }

    public function  getCountriesByIdBrand($band_id){
          $countries = [];
              $brandCountries = self::find($band_id) ;
                if (!empty($brandCountries)) {
            foreach($brandCountries->brandCountry as $brandCountry) {
                      array_push($countries, $brandCountry->country);
            }
        }
        return $countries;
    }

    public function getParents()
    {
        $brandIds = explode(',', $this->parent_brand_id);
        return Brand::whereIn('id', $brandIds)->get();
    }

    public function belongsToCountry($countryID) {
        return $this->brandCountry->where('country_id', $countryID)->count() > 0;
    }
}
