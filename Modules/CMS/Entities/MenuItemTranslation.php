<?php namespace Modules\CMS\Entities;

use Eloquent;


class MenuItemTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['custom_name', 'locale'];

    protected $table = 'cms_menu_item_translations';

    public static function updateItemTranslation($menuItemId = 0, $locale = '', $customName = '' ){
        $menuItemTrans = self::where('menu_item_id', '=', $menuItemId)->where('locale', '=', $locale)->first();
        if($menuItemTrans){
            $menuItemTrans->custom_name = $customName;
            $menuItemTrans->save();
        } else {
            $newMenuItemTrans = new MenuItemTranslation();
            $newMenuItemTrans->menu_item_id = $menuItemId;
            $newMenuItemTrans->custom_name = $customName;
            $newMenuItemTrans->locale = $locale;
            $newMenuItemTrans->save();
        }
    }
    public static function getMenuItemTranslation($menuItemId = 0, $locale = ''){
        return self::where('menu_item_id', '=', $menuItemId)->where('locale', '=', $locale)->first();
    }
}