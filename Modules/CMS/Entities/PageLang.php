<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Request;

class PageLang extends Eloquent
{
    use DataPreLoad {DataPreLoad::preload as traitPreload;}

    /**
     * @var string
     */
    protected $table = 'cms_page_lang';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page()
    {
        return $this->hasOne('Modules\CMS\Entities\Page', 'id');
    }

    /**
     * @param string|int $key
     * @param bool $force
     * @return static
     */
    public static function preload($key, $force = false)
    {       
        if (!static::_preloadIsset() || $force) {
            $languages = [\Modules\Admin\Entities\Language::current()];         
            if (config('cms.frontend.language_fallback') == 1 &&  !in_array(config('cms.frontend.language'), $languages)) {
                $languages[] = config('cms.frontend.language');
            }
            foreach ($languages as $language) {
                $data = self::where('language_id', '=', $language)->get();
                static::_preload($data);
            }
        }                                    
        return static::traitPreload($key);
    }
    
    public static function preloadByLanguage($key, $force = false)
    {
        if (!static::_preloadIsset() || $force) {
        
              $data = self::where('language_id', '=', !empty(Request::get('language_id')) ? Request::get('language_id') : 0)->get();
                static::_preload($data);
           
        }
        return static::traitPreload($key);
    }
    /**
     * @return array
     */
    protected static function _preloadByColumn()
    {
        return ['page_id'];
    }

    /**
     * @param $pageId
     * @return string
     */
    public static function getUrl($pageId)
    {
        return static::preload($pageId)->url;
    }

    /**
     * @param $pageId
     * @return string
     */
    public static function getName($pageId)
    {
        return static::preload($pageId)->name;
    }

}