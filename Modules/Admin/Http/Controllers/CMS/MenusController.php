<?php namespace Modules\Admin\Http\Controllers\CMS;

use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\CMS\Entities\MenuItemTranslation;
use Modules\CMS\Helpers\Page\PageCache;
use Modules\CMS\Helpers\Page\Path;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Menu;
use Modules\CMS\Entities\MenuItem;
use Modules\CMS\Entities\Page;
use Request;
use Response;
use View;

class MenusController extends Controller
{
    public function getIndex()
    {
        $menus = '';
        foreach (Menu::all() as $menu) {
            $menus .= $menu->getTreeView();
        }

        if(empty(Request::all())){
            $brand_id = 0;
            $country_id = 0;
            $language_id = 0;
        } else {

            $brand_id = Request::get('brand_id');
            $country_id = Request::get('country_id');
            $language_id = Request::get('language_id');
        }
        $brands = Brand::selectArrayBrandUseractive();
        $countries = BrandCountry::selectCountryBrandUser($brand_id);
        $languages = Country::selectArrayCountryLanguages($country_id);

        $dataStatsMenus = $this->getDataStatsMenus();

        $this->layoutData['content'] = View::make('admin::cms.pages.menus', ['menus' => $menus, 'languages' => $languages, 'countries' => $countries, 'brands' => $brands]);
        $this->layoutData['modals'] = View::make('admin::cms.modals.menus.add_item', ['options' => Page::get_page_list_for_menus()])->render() .
            View::make('admin::modals.general.delete_item')->render() .
            View::make('admin::cms.modals.menus.sub_level_item')->render() .
            View::make('admin::cms.modals.menus.rename_item')->render() .
            View::make('admin::cms.modals.menus.dataStats', ['dataStatsMenus' => $dataStatsMenus])->render();
    }

    public function postAdd()
    {
        $menu_id = Request::input('menu');
        $page_id = Request::input('id');

        $last_item = MenuItem::where('menu_id', '=', $menu_id)->orderBy('order', 'desc')->first();
        if (!empty($last_item)) {
            $order = $last_item->order + 1;
        } else {
            $order = 1;
        }
        $new_item = new MenuItem;
        $new_item->menu_id = $menu_id;
        $new_item->page_id = $page_id;
        $new_item->order = $order;
        $new_item->sub_levels = 0;
        $new_item->save();
        $item_name = Path::getFullName($page_id);
        AdminLog::log('Menu Item \'' . $item_name . '\' added to \'' . Menu::name($menu_id) . '\'');
        PageCache::clear();
        return $new_item->id;
    }

    public function postDelete($itemId)
    {
        if ($menu_item = MenuItem::find($itemId)) {
            $menu_item->delete();
            PageCache::clear();
            return $menu_item->getJSONLogIds();
        }
        return Response::make('Menu item with ID '.$itemId.' not found', 500);
    }

    public function postSort()
    {
        $items = Request::input('list');
        $menuItems = [];
        $pages = [];
        foreach ($items as $itemId => $parentItemId) {
            if (strpos($itemId, 'p') === 0) {
                $itemId = trim($itemId, 'p');
                if (strpos($parentItemId, 'p') === 0) {
                    $pages[$itemId] = trim($parentItemId, 'p');
                } elseif ($itemPageId = MenuItem::preload($parentItemId)->page_id) {
                    $pages[$itemId] = $itemPageId;
                }
            } else {
                $menuItems[$itemId] = null;
            }
        }
        $order = 1;
        $menuId = 0;
        foreach ($menuItems as $itemId => $parentItemId) {
            $current_item = MenuItem::preload($itemId);
            $current_item->order = $order++;
            $current_item->save();
            $menuId = $current_item->menu_id;
        }
        Page::sortPages($pages);
//        AdminLog::log('Items re-ordered in menu \'' . Menu::name($menuId) . '\'');
        PageCache::clear();
        return 1;
    }

    public function postGetLevels()
    {
        $itemId = Request::input('id');
        $item = MenuItem::find($itemId);
        if (!empty($item)) {
            $menu = Menu::find($item->menu_id);
            return json_encode(['sub_levels' => $item->sub_levels, 'max_levels' => $item->getMaxLevels(), 'menu_max_levels' => $menu->max_sublevel]);
        }
        return abort(500, 'Item not found');
    }

    public function postHidePage()
    {
        $itemId = Request::input('itemId');
        $item = MenuItem::find($itemId);
        if (!empty($item)) {
            $item->setHiddenPage(Request::input('pageId'), Request::input('hide'));
            $item->save();
            PageCache::clear();
            return 1;
        }
        return abort(500, trans('admin::menusCMS.item_not_found'));
    }

    public function postSaveLevels()
    {
        $itemId = Request::input('id');
        $item = MenuItem::find($itemId);
        if (!empty($item)) {
            $menu = Menu::find($item->menu_id);
            $item->sub_levels = Request::input('sub_level') > $menu->max_sublevel ? $menu->max_sublevel : Request::input('sub_level');
            $item->save();
            // log action
            AdminLog::log('Change sub levels for menu item \'' . Path::getFullName($item->page_id) . '\' in \'' . Menu::name($item->menu_id) . '\' to ' . $item->sub_levels);
            PageCache::clear();
            return json_encode(['children' => $item->getRenderedChildItems()]);
        }
        return abort('500');
    }

    public function postRename()
    {
        $itemId = Request::input('id');
        $item = MenuItem::find($itemId);
        //dd( $item);
        if (!empty($item)) {
            $item->setCustomName(Request::input('customName'), Request::input('pageId'));
            $item->save();
            // log action
            $item_name = Path::getFullName($item->page_id);
            if ($item->custom_name) {
                AdminLog::log('Renamed menu item \'' . $item_name . '\' in \'' . Menu::name($item->menu_id) . '\' to ' . $item->custom_name);
            } else {
                AdminLog::log('Removed custom name for menu item \'' . $item_name . '\' in \'' . Menu::name($item->menu_id) . '\'');
            }
            PageCache::clear();
            return 1;
        }
        return abort('500');
    }

    public function postRenameV2()
    {
        $langId = Request::input('langId');
        $language = Language::find($langId);

        $itemId = Request::input('id');
        $item = MenuItem::find($itemId);
        //dd( $item);
        if (!empty($item)) {
            MenuItemTranslation::updateItemTranslation(Request::input('id'), $language->locale_key, Request::input('customName'));
            // log action
            $item_name = Path::getFullName($item->page_id);
            if ($item->custom_name) {
                AdminLog::log('Renamed menu item \'' . $item_name . '\' in \'' . Menu::name($item->menu_id) . '\' to ' . $item->custom_name);
            } else {
                AdminLog::log('Removed custom name for menu item \'' . $item_name . '\' in \'' . Menu::name($item->menu_id) . '\'');
            }
            PageCache::clear();
            return 1;
        }
        return abort('500');
    }

    public function getDataStatsMenus(){

        $dataTableStatsMenus = null;
        $brands = Brand::selectArrayBrandUseractive();
        $countries = Country::selectArrayCountriesUser();
        $languages = Language::selectArray();
        //$menus = Menu::preloadArray();

        $queryStatsMenus = DB::table('cms_menu_items as cmi')
            ->select('cmp.brand_id', 'cmp.country_id', 'cpl.language_id', 'cmi.menu_id' ,DB::raw('count(*) as total'))
            ->leftjoin('cms_pages as cmp', 'cmi.page_id', '=', 'cmp.id')
            ->leftjoin('cms_page_lang as cpl', 'cmp.id', '=', 'cpl.page_id')
            ->groupBy('cmp.brand_id', 'cmp.country_id', 'cpl.language_id', 'cmi.menu_id')
            ->get();

        //dd($countries, $queryStatsMenus);
        if(!empty($queryStatsMenus)){
            foreach($queryStatsMenus as $qsm){

                if(isset($qsm->brand_id) && $qsm->brand_id != 0
                    && isset($qsm->country_id) && $qsm->country_id != 0
                    && isset($qsm->language_id) && $qsm->language_id != 0){


                    if(isset($dataTableStatsMenus[$qsm->brand_id.$qsm->country_id.$qsm->language_id]))
                    {
                        switch ($qsm->menu_id){
                            case 1:
                                $dataTableStatsMenus[$qsm->brand_id.$qsm->country_id.$qsm->language_id]->main_menu->total += $qsm->total;
                                break;
                            case 2:
                                $dataTableStatsMenus[$qsm->brand_id.$qsm->country_id.$qsm->language_id]->footer->total += $qsm->total;
                                break;
                        }
                    } else {
                        $qsm->brand = isset($brands[$qsm->brand_id]) ? $brands[$qsm->brand_id] : 0;
                        $qsm->country = isset($countries[$qsm->country_id]) ? $countries[$qsm->country_id] : 0;
                        $qsm->language = isset($languages[$qsm->language_id]) ? $languages[$qsm->language_id] : 0;
                        //$qsm->menu = $menus[$qsm->menu_id]->label;
                        switch ($qsm->menu_id){
                            case 1:
                                $qsm->main_menu = new \stdClass();
                                $qsm->footer = new \stdClass();
                                $qsm->footer->total = 0;
                                $qsm->main_menu->total = $qsm->total;
                                break;
                            case 2:
                                $qsm->main_menu = new \stdClass();
                                $qsm->main_menu->total = 0;
                                $qsm->footer = new \stdClass();
                                $qsm->footer->total = $qsm->total;
                                break;
                        }
                        unset($qsm->total);
                        if(isset($brands[$qsm->brand_id]) && isset($countries[$qsm->country_id]) && isset($languages[$qsm->language_id])){
                            $dataTableStatsMenus[$qsm->brand_id.$qsm->country_id.$qsm->language_id] = $qsm;
                        }
                    }
                }

            }
        }
        unset($queryStatsMenus);
        return $dataTableStatsMenus;
    }

}