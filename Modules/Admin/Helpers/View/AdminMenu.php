<?php namespace Modules\Admin\Helpers\View;

use Auth;
use Illuminate\Support\Facades\Log;
use Modules\Admin\Entities\ACL\AdminAction;
use Modules\Admin\Entities\ACL\AdminController;
use Modules\Admin\Entities\Language;
use Request;
use URL;
use View;

class AdminMenu
{

    protected static $_setActive;

    public static function getSystemMenu()
    {

        $systemMenuItems = [
            trans("admin::navbar.open_frontend") => [
                'link' => URL::to('/') . '" target="_blank',
                'icon' => 'fa fa-tv'
            ],
            /*'Help' => [
                'link' => config('admin.config.help_link') . '" target="_blank',
                'icon' => 'fa fa-life-ring'
            ]*/
        ];


        if (Auth::admin()) {

            if (Language::count() > 1) {
                $page_lang = Language::find(\Modules\Admin\Entities\Language::current());
                $systemMenuItems[trans('admin::navbar.language').':' . $page_lang->language] = [
                    'link' => route('admin.account.language'),
                    'icon' => 'fa fa-language'
                ];
            }
            if (Auth::action('account')) {
                $systemMenuItems[trans('admin::navbar.my_account')] = [
                    'link' => route('admin.account.index'),
                    'icon' => 'fa fa-lock'
                ];
            }
            /*if (Auth::action('system')) {
                $systemMenuItems['System Settings'] = [
                    'link' =>  route('admin.system.index'),
                    'icon' => 'fa fa-cog'
                ];
            }*/
            $systemMenuItems[trans('admin::navbar.logout')] = [
                'link' => route('admin.logout'),
                'icon' => 'fa fa-sign-out'
            ];

        } else {

            /*$systemMenuItems['Login'] = [
                'link' => route('admin.login'),
                'icon' => 'fa fa-lock'
            ];*/

        }

        $systemMenu = '';
        foreach ($systemMenuItems as $systemMenuItem => $details) {
            $details = ['item' => $systemMenuItem] + $details;
            $systemMenu .= View::make('admin::cms.menus.system.item', $details)->render();
        }

       return $systemMenu;

    }

    public static function getSectionsMenu()
    {
        // load menu items
        $menuItems = \Modules\Admin\Entities\ACL\AdminMenu::where('active','=',1)->orderBy('order', 'asc')->get();
        $menu = [];
        foreach ($menuItems as $menuItem) {
            if (!isset($menu[$menuItem->parent])) {
                $menu[$menuItem->parent] = [];
            }
            array_push($menu[$menuItem->parent], $menuItem);
        }

        // admin menu generation
        $adminMenu = '';
        if(count($menu) > 0){
            foreach ($menu[0] as $topLevelItem) {

                if (Auth::action($topLevelItem->action_id) || $topLevelItem->parent == 0  ) {

                    self::$_setActive = false;

                    // check if top level item has sub menu
                    $subMenuItems = '';
                    if (!empty($menu[$topLevelItem->id])) {
                        $items = '';
                        foreach ($menu[$topLevelItem->id] as $key => $subMenuItem) {
                            if (Auth::action($subMenuItem->action_id)) {
                                $items .= View::make('admin::cms.menus.sections.subitem', ['item' => $subMenuItem, 'url' => self::_itemUrl($subMenuItem->action_id)])->render();
                            }
                        }
                        if ($items) {
                            $subMenuItems = View::make('admin::cms.menus.sections.submenu', ['items' => $items])->render();
                        }
                    }
                    
                    if (($topLevelItem->action_id == 0 && !empty($items)) || $topLevelItem->action_id != 0 ){
                        // get top level item view
                        $url = self::_itemUrl($topLevelItem->action_id);
                        $adminMenu .= View::make('admin::cms.menus.sections.item', ['sub_menu' => $subMenuItems, 'item' => $topLevelItem, 'active' => self::$_setActive, 'url' => $url])->render();
                        $items = '';
                    }
                }
            }
        }

        return $adminMenu;
    }

    public static function  getMenuDashboard(){
          $menuItems = \Modules\Admin\Entities\ACL\AdminMenu::where('active','=',1)->orderBy('order', 'asc')->get();
        $menu = [];
        foreach ($menuItems as $menuItem) {
            if (!isset($menu[$menuItem->parent])) {
                $menu[$menuItem->parent] = [];
            }
            array_push($menu[$menuItem->parent], $menuItem);
        }

        // admin menu generation
        $adminMenu = '';
        if(count($menu) > 0){
            foreach ($menu[0] as $topLevelItem) {

                if (Auth::action($topLevelItem->action_id) || $topLevelItem->parent == 0  ) {

                    self::$_setActive = false;

                    // check if top level item has sub menu            
                    
                    if (($topLevelItem->action_id == 0 && !empty($items)) || $topLevelItem->action_id != 0 ){
                        // get top level item view
                        $url = self::_itemUrl($topLevelItem->action_id);
                        $adminMenu .= View::make('admin::cms.menus.sections.item_dashboard', [ 'item' => $topLevelItem, 'active' => self::$_setActive, 'url' => $url])->render();
                        $items = '';
                    }
                }
            }
        }

        return $adminMenu;
    }


    /**
     * @param $actionId
     * @return string
     */
    private static function _itemUrl($actionId)
    {
        if ($actionId > 0) {

            /** @var AdminAction $adminAction */
            $adminAction = AdminAction::preload($actionId);

            if (!empty($adminAction)) {

                /** @var AdminController $adminController */
                $adminController = AdminController::preload($adminAction->controller_id);

                $routeName = 'admin.' . $adminController->controller . '.' . $adminAction->action;

                if (strpos(Request::route()->getName(), $routeName) === 0) {
                    //self::$_setActive = true;
                }

                return route($routeName);

            }

        }

        return '#';
    }

}
