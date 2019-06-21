<?php namespace Modules\Admin\Entities;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use phpDocumentor\Reflection\DocBlock;
use Session;
use Dimsav\Translatable\Translatable;

class Language extends Eloquent
{
    use DataPreLoad, Translatable;
    protected $fillable = ['locale_key', 'corbiz_key', 'active', 'delete'];
    public $translatedAttributes = ['language', 'language_country'];

    protected $table = 'glob_languages';

    public static function set($value)
    {
        //dd($value);
        Session::put('language', $value);

        $language = Language::find($value);

        if($language) {
            \Session::put('adminLocale', $language['locale_key']);
            \Session::put('adminLocaleCorbiz', $language['corbiz_key']);
        }
    }

    public static function current()
    {
       if(Route::current()->getPrefix() != null && Route::current()->getPrefix() == "support"){
           $language = Session::get('language');
           self::set($language);
       } else {
           $language = Session::get('portal.main.language_id');
       }

        if (empty($language)) {
            $language = config('cms.frontend.language');
            //self::set($language);
        }
        return $language;
    }

    public static function currentLocale()
    {
        if(Route::current()->getPrefix() != null && Route::current()->getPrefix() == "support"){
            $locale = Session::get('locale');
            //self::set($locale);
        } else {
            $locale = Session::get('portal.main.app_locale');
        }

        if (empty($locale)) {
            $locale = config('cms.frontend.lang_key');
            //self::set($language);
        }
        return $locale;
    }

    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToLanguage', ['id'], 'language');
        return static::_preloadGetArray('idToLanguage');
    }

    public static function selectArrayActive($lang = null)
    {
        $lang = [];
        $langActive = $lang != null ? $lang : self::where('active', '=', 1)->get();
        if(count($langActive) > 0){
            foreach($langActive as $language) {
                $lang[$language->id] = $language->language_country;
            }
        }
        return $lang;
    }

    public static function currentCorbiz()
    {
        $language = Session::get('adminLocaleCorbiz');
        return $language;
    }

    /**
     * @param int $id
     * @return string
     * @createdBy Mario Avila
     */
    public static function getLocaleKeyById(int $id) {
        $lang = self::find($id);
        return $lang->locale_key ?? "";
    }
}
