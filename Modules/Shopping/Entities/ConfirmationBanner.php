<?php namespace Modules\Shopping\Entities;

use App\Exceptions\Kiosco\KioscoBannerException;
use Eloquent;
use Dimsav\Translatable\Translatable;
use http\Env\Request;
use Modules\CMS\Libraries\Traits\DataPreLoad;


class ConfirmationBanner extends Eloquent
{
    use Translatable, DataPreLoad;

    protected $fillable = ['global_name', 'country_id','brand_id','purpose_id','type_id','link','active','delete','last_modifier_id'];
    public $translatedAttributes = ['image'];
    protected $table = 'shop_confirmation_banner';

    public function bannerTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\ConfirmationBannerTransalation');
    }

    public function types()
    {
        return $this->hasMany('Modules\Shopping\Entities\ConfirmationType','id','type_id');
    }

    public function purposes()
    {
        return $this->hasMany('Modules\Shopping\Entities\ConfirmationPurpose','id','purpose_id');
    }

    public function type() {
        return $this->belongsTo('Modules\Shopping\Entities\ConfirmationType');
    }

    public function purpose() {
        return $this->belongsTo('Modules\Shopping\Entities\ConfirmationPurpose');
    }

    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public function brand() {
        return $this->belongsTo('Modules\Admin\Entities\Brand');
    }

    public function getCountriesAttribute() {
        $confirmation = ConfirmationBanner::select('shop_confirmation_banner.*')
            ->where('shop_confirmation_banner.global_name', $this->global_name)
            ->get();

        $countries = [];
        foreach ($confirmation as $conf) {
            $countries[] = $conf->country;
        }

        return collect($countries);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }

    /**
     * @param int $countryId
     * @param int $type
     * @param int $purpose
     * @param $request
     * @return bool
     * @throws KioscoBannerException
     * @createdBy Mario Avila
     * @version 07/08/2018
     */
    public static function saveKioscoBanner(int $countryId, int $type, int $purpose, $request) : bool  {
        $link     = "link_$countryId";
        $active   = "active_$countryId";
        $done     = false;

        $data = ConfirmationBanner::create(
                ['country_id' => $countryId,'purpose_id' => $purpose,'type_id' => $type,'link' => $request->$link, 'active' => $request->$active]
            );
        if ($data->id > 0) {
            $done = self::saveTranslationKioscoBanners($countryId, $data, $request, 1);
            if (!$done) {
                throw new KioscoBannerException('Algo ha ido mal guardando los banners. Vuelva a intentarlo');
            }
        }
        return $done;
    }

    /**
     * @param int $idCountry
     * @param ConfirmationBanner $banner
     * @param $request
     * @param int $as_active
     * @return int
     * @createdBy Mario Avila
     * @version 07/08/2018
     */
    private static function saveTranslationKioscoBanners(int $idCountry , ConfirmationBanner $banner,  $request, int $as_active) : int {
        $response = false;
        foreach(\Auth::user()->getCountryLang($idCountry) as $langCountry) {
            $image = "image_{$idCountry}_".$langCountry->id;
            if (!is_null($request->$image)) {
                $banner->translateOrNew($langCountry->locale_key)->image  = $request->$image;
                $banner->translateOrNew($langCountry->locale_key)->active = $as_active;
                $response = $banner->save();
            }
        }
        return $response;
    }

    public static function getBannersByPurpose(int $purpose_id) {
        return self::where('purpose_id', $purpose_id)->get();
    }
}
