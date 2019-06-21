<?php namespace Modules\CMS\Entities;

use Auth;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use View;
use Dimsav\Translatable\Translatable;

class Menu extends Eloquent
{
    use DataPreLoad, Translatable;
    public $translatedAttributes = ['label'];
    protected $table = 'cms_menus';

    protected $_pageNames;

    /**
     * preload by both id and name
     * @return array
     */
    protected static function _preloadByColumn()
    {
        return ['id', 'name'];
    }

    public function items()
    {
        return $this->hasMany('Modules\CMS\Entities\MenuItem')->orderBy('order', 'asc');
    }

    public static function name($menu_id)
    {
        $menu = self::find($menu_id);
        return !empty($menu) ? $menu->label : null;
    }

    public function getTreeView()
    {
        $renderedMenuItems = '';
        $this->_pageNames = Page::get_page_list_for_menus();
        $menuItems = $this->items()->get();

        $permissions = [
            'can_add_item' => Auth::action('menus.add'),
            'delete' => Auth::action('menus.delete'),
            'subpage' => Auth::action('menus.save_levels'),
            'rename' => Auth::action('menus.rename')
        ];
        foreach ($menuItems as $menuItem) {
            if (isset($this->_pageNames[$menuItem->page_id])) {
                $leaf = $menuItem->getRenderedChildItems();
                $fullName = $this->_pageNames[$menuItem->page_id];
                $renderedMenuItems .= View::make('admin::cms.partials.menus.li', ['item' => $menuItem, 'menu' => $this, 'name' => $fullName, 'leaf' => $leaf, 'permissions' => $permissions])->render();
            }
        }
        return View::make('admin::cms.partials.menus.ol', ['renderedItems' => $renderedMenuItems, 'menu' => $this, 'permissions' => $permissions])->render();
    }

}