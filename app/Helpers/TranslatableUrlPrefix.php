<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 19/06/18
 * Time: 10:54
 */

namespace App\Helpers;



use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Modules\CMS\Entities\Page;

class TranslatableUrlPrefix {

    public static function getTranslatablePrefixes() {
        return Config::get('routes_prefixes');
    }

    public static function getTranslatablePrefixesByIndex($index) {
        return Config::get('routes_prefixes')[$index];
    }

    public static function getTranslatablePrefixByIndexAndLang($index, $lang) {
        return Config::get('routes_prefixes')[$index][$lang];
    }

    public static function getRouteName($lang, $indexes) {
        $routeIndexes = [];

        foreach ($indexes as $index) {
            $prefixTranslated = isset(Config::get('routes_prefixes')[$index][$lang]) ? Config::get('routes_prefixes')[$index][$lang] : $index;
            $routeIndexes[]   = $prefixTranslated;
        }

        return implode('.', $routeIndexes);
    }

    public static function isValidPrefix($prefix, $lang, $index) {
        $prefixTranslated = self::getTranslatablePrefixByIndexAndLang($index, $lang);
        return $prefixTranslated == $prefix;
    }

    public static function isFromIndex($prefix, $index) {
        $itIs = false;

        $prefixes = self::getTranslatablePrefixesByIndex($index);
        foreach ($prefixes as $p) {
            if ($p == $prefix) {
                $itIs = true;
            }
        }

        return $itIs;
    }

    public static function getUrlPagesByCode($code) {
        $brand_id = Session::get('portal.main.brand.id');
        $country_id = Session::get('portal.main.country_id');
        $language_id = Session::get('portal.main.language_id');
        $url_page_code = Page::getUrlPagesByCode($brand_id, $country_id, $language_id, $code);
        if($url_page_code != null){
            return $url_page_code->url;
        } else {
            return 'contact';
        }
    }
}
