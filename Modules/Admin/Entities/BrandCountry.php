<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Entities;
use Eloquent;
use Modules\Admin\Entities\ACL\User;

/**
 * Description of GlobalBrandTraslation
 *
 * @author sergio
 */
class BrandCountry extends Eloquent{
    //put your code here
    //  use Translatable;
    public $timestamps = false;
    protected $fillable = ['brand_id','country_id'];

    protected $table = 'glob_brand_countries';

    protected $primaryKey = 'id';
    
      public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }
    public function brands()
    {
        return $this->belongsTo('Modules\Admin\Entities\brand');
    }

    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToBrand', ['id'], 'name');
        return static::_preloadGetArray('idToBrand');
    }

    public static function selectCountryBrandUser($brandId){
          $countries = [];
        $countriesUser = User::userCountriesPermission();
        $brandCountries = $brandId != null ? self::where('brand_id', $brandId)->whereIn('country_id', $countriesUser)->where('active', '=', 1)->get() :[];

        if(!empty($brandCountries)){
            foreach ($brandCountries as $bc){
                $countries[$bc->country->id] = $bc->country->name;
            }
        }
        return $countries;
    }
}
