<?php namespace Modules\Admin\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\Admin\Entities\ACL\User;
use Modules\CMS\Libraries\Traits\DataPreLoad;
class Country extends Eloquent
{

    use DataPreLoad, Translatable;

    public $translatedAttributes = ['name'];
    protected $table = 'glob_countries';
    protected $fillable = [
        'country_key',
        'default_locale',
        'number_format',
        'currency_key',
        'currency_symbol',
        'timezone',
        'webservice',
        'shopping_active',
        'inscription_active',
        'customer_active',
        'corbiz_key',
        'flag',
        'active',
        'delete',
    ];

    public function language()
    {
        return $this->hasOne('Modules\Admin\Entities\Language', 'locale_key', 'default_locale');
    }

    public function languages()
    {
        return $this->hasMany('Modules\Admin\Entities\CountryLanguage');
    }
    public function traslations()
    {
        return $this->hasMany('Modules\Admin\Entities\CountryTranslation');
    }
      public  function brandCountry()
    {
        return $this->hasMany('Modules\Admin\Entities\BrandCountry');
    }

    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToCountry', ['id'], 'name');
        return static::_preloadGetArray('idToCountry');
    }

    public static function selectArrayActive($country = null)
    {
        $countries = [];
        $countryActive = $country != null ? $country : self::where('active', '=', 1)->get();
        if(!empty($countryActive)){
            foreach($countryActive as $country) {
                $countries[$country->id] = $country->name;
            }
        }
        return $countries;
    }

    public static function selectArrayCountryLanguages($countryId = null)
    {
        $languages = [];
        $CountryLanguages = $countryId != null ? self::find($countryId) : [];
        if (!empty($CountryLanguages)) {
            foreach($CountryLanguages->languages as $brandCountry) {
                $languages[$brandCountry->language->id] = $brandCountry->language->language;
            }
        }
        return $languages;
    }

    public static function selectArrayCountriesUser()
    {
        $countriesIdUser = User::userCountriesPermission();
        $countries = [];
        $countriesActive = self::whereIn('id', $countriesIdUser)->where('active', '=', 1)->get();
        if (!empty($countriesActive)) {
            foreach($countriesActive as $country) {
                $countries[$country->id] = $country->name;
            }
        }
        return $countries;
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }

    public function languagesRelated()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Language', 'glob_country_languages', 'country_id', 'language_id');
    }

    public function registrationParameter()
    {
        return $this->hasOne('Modules\Shopping\Entities\CountryRegistrationParameter', 'country_id', 'id');
    }
}
