<?php namespace Modules\Admin\Entities;

use Eloquent;
use Modules\CMS\Libraries\Traits\DataPreLoad;

class CountryLanguage extends Eloquent
{

    use DataPreLoad;
 protected $fillable = ['country_id','language_id','active'];
 
    protected $table = 'glob_country_languages';

    public $timestamps = false;

    public function language()
    {
        return $this->belongsTo('Modules\Admin\Entities\Language');
    }

    public static function selectArrayActiveById($countryId = 0)
    {
        $langs = [];
        $langActive = $langs != null ? $langs : self::where('country_id', '=', $countryId)->where('active', '=', 1)->get();
        if(count($langActive) > 0){
            foreach($langActive as $language) {
                $langs[$language->language->id] = $language->language->language_country;
            }
        }
        return $langs;
    }
}