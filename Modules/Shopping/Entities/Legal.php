<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;

class Legal extends Eloquent
{
    use Translatable, DataPreLoad;
    const KIOSCO_PURPOSE = 4;

    protected $table = 'shop_legals';
    protected $fillable = ['country_id', 'active_contract', 'active_disclaimer', 'active_policies','active_datausage', 'active', 'delete',
        'last_modifier_id', 'purpose_id'];

    public $translatedAttributes = ['contract_pdf', 'disclaimer_html', 'contract_html', 'policies_pdf','datausage_pdf'];

    public function legalTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\LegalTranslation');
    }


    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }


    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }

    /**
     * @param $countryId
     * @param $request
     * @return bool
     * @createdBy Mario Avila
     */
    public static function saveKioscoLegalsCountry($countryId, $request) : bool{
        $success = false;
        $legal = Legal::updateOrCreate(
            ['country_id' => $countryId],
            ['country_id' => $countryId,'active_contract' => 0,'active_disclaimer' => 0,
                'active_policies' => 0,'delete' => 0,'active' => $request->active, 'purpose_id' => self::KIOSCO_PURPOSE]
        );
        if ($legal->id > 0) {
            $success = self::saveKioscoTranslationLegals($countryId, $legal->id, $request, $request->active );
        }
        return $success;
    }

    /**
     * @param $idCountry
     * @param $idLeg
     * @param $request
     * @param $active
     * @return bool
     * @createdBy Mario Avila
     */
    private static function saveKioscoTranslationLegals($idCountry , $idLeg, $request, $active) {
        $is_saved = false;
        $legalsconf = Legal::find($idLeg);
        foreach (\Auth::user()->getCountryLang($idCountry) as $langCountry) {
            $contract_html  = 'contract_'.$idCountry.'_'.$langCountry->id;
            if (!empty($request->$contract_html)) {
                $legalsconf->translateOrNew($langCountry->locale_key)->active           = $active;
                $legalsconf->translateOrNew($langCountry->locale_key)->contract_html    = $request->$contract_html;
                $legalsconf->translateOrNew($langCountry->locale_key)->last_modifier_id = \Auth::user()->id;
            }
            $is_saved = $legalsconf->save();
        }
        return $is_saved;
    }
}