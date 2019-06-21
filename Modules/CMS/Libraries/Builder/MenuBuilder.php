<?php namespace Modules\CMS\Libraries\Builder;

use Illuminate\Support\Facades\Session;
use Modules\CMS\Helpers\Page\Path;
use Modules\CMS\Libraries\Builder\ViewClasses\MenuItemDetails;
use Modules\CMS\Entities\Menu;
use Modules\CMS\Entities\MenuItem;
use Modules\CMS\Entities\Page;
use Illuminate\Support\Collection;
use View;

class MenuBuilder
{

    /**
     * @var int
     */
    public $rootPageId;

    /**
     * @var MenuItem[]
     */
    public $rootItems;

    /**
     * @var int
     */
    public $subLevels;

    /**
     * @var int
     */
    public $startLevel;

    /**
     * @var array
     */
    public $options;

    /**
     * @var array
     */
    public $activePageId;

    /**
     * @var
     */
    public $activeParentIds;

    /**
     * @param string $menuName
     * @param array $options
     * @return string
     */
    public static function menu($menuName, $options = [])
    {
        if ($menu = Menu::preload($menuName)) {
            //dd($menu->items()->get());
            return (new static($menu->items()->get(), 0, 0, 1, ['menu' => $menu] + $options))->render();
        } else {
            return '';
        }
    }

    /**
     * @param int $parentPageId
     * @param int $startLevel
     * @param int $subLevels
     * @param array $options
     * @return string
     */
    public static function pageMenu($parentPageId, $startLevel = 1, $subLevels = 0, $options = [])
    {
        if ($subPages = Page::getChildPages($parentPageId)) {
            return (new static($subPages, $parentPageId, $startLevel, $subLevels, $options))->render();
        } else {
            return '';
        }
    }

    /**
     * @param Page[]|MenuItem[]|Collection $items
     * @param int $parentPageId
     * @param int $startLevel
     * @param int $subLevels
     * @param array $options
     * @return string
     */
    public static function customMenu($items, $parentPageId = 0, $startLevel = 1, $subLevels = 0, $options = [])
    {
        return (new static($items, $parentPageId, $startLevel, $subLevels, $options))->render();
    }

    /**
     * MenuBuilder constructor.
     * @param Page[]|MenuItem[]|Collection $menuItems
     * @param int $rootPageId
     * @param int $subLevels
     * @param int $startLevel
     * @param array $options
     */
    public function __construct($menuItems, $rootPageId = 0, $subLevels = 0, $startLevel = 1, $options = [])
    {
        if (is_a($menuItems, Collection::class)) {
            $menuItems = $menuItems->all();
        }

        $this->rootPageId = $rootPageId;
        $this->rootItems = $this->_convertPagesToItems($menuItems);
        $this->subLevels = $subLevels;
        $this->startLevel = $startLevel;

        $this->options = array_merge([
            'view' => 'default',
            'canonicals' => config('cms.frontend.canonicals')
        ], $options);
    }

    /**
     * @return string
     */
    public function render()
    {
        $menuItems = $this->_buildMenuItems($this->rootItems, $this->rootPageId, $this->startLevel, $this->subLevels);
        //dd($menuItems);
        return $this->_getRenderedView('menu', ['items' => $menuItems]);
    }

    /**
     * @param Page[]|MenuItem[] $items
     * @param MenuItem|null $baseItem
     * @return MenuItem[]
     */
    protected function _convertPagesToItems($items, $baseItem = null)
    {
        $baseItem = $baseItem ?: new MenuItem;
        foreach ($items as $k => $item) {
            if (is_a($item, Page::class)) {
                $spoofMenuItem = clone $baseItem;
                $spoofMenuItem->page_id = $item->id;
                $spoofMenuItem->sub_levels = null;
                $spoofMenuItem->custom_name = $spoofMenuItem->getCustomName($spoofMenuItem->page_id);
                $items[$k] = $spoofMenuItem;
            }
        }
        return $items;
    }

    /**
     * @param MenuItem[] $items
     * @param int $parentPageId
     * @param int $level
     * @param int $subLevels
     * @return string
     */
    protected function _buildMenuItems($items, $parentPageId, $level = 1, $subLevels = 0)
    {
        // remove deleted pages and hidden ones from array
        $items = $this->_returnExistingLiveItems($items);

        $total = count($items);
        $renderedMenuItems = '';

        foreach ($items as $count => $item) {
            $isFirst = ($count == 0);
            $isLast = ($count == $total - 1);

            $pageId = Path::unParsePageId($item->page_id);
            $active = $this->_isActivePage($pageId); // or active parent page
            $itemData = new MenuItemDetails($item, $active, $parentPageId, $this->options['canonicals']);

            $renderedSubMenu = '';
            if ($subLevelsToRender = is_null($item->sub_levels) ? $subLevels : $item->sub_levels) {
                if ($subPages = Page::category_pages($pageId)) {
                    $subPages = $this->_convertPagesToItems($subPages, $item);
                    $renderedSubMenu = $this->_buildMenuItems($subPages, $pageId, $level + 1, $subLevelsToRender - 1);
                }
            }

            $view = $renderedSubMenu ? 'submenu_' . $level : 'item';
            $renderedMenuItems .= $this->_getRenderedView($view, [
                'item' => $itemData,
                'items' => $renderedSubMenu,
                'is_first' => $isFirst,
                'is_last' => $isLast,
                'count' => $count + 1,
                'total' => $total,
                'level' => $level,
                'further_levels' => $subLevelsToRender
            ]);
        }

        return $renderedMenuItems;
    }

    /**
     * @param string $viewPath
     * @param array $data
     * @return string
     */
    protected function _getRenderedView($viewPath, $data = [])
    {
        $viewPath = 'themes.' . PageBuilderFacade::getData('theme') . '.menus.' . $this->options['view'] . '.' . $viewPath;
        if (View::exists($viewPath)) {
            return View::make($viewPath, array_merge($this->options, $data))->render();
        } else {
            return 'View not found (' . $viewPath . ')';
        }
    }

    /**
     * @param MenuItem[] $items
     * @return MenuItem[]
     */
    protected function _returnExistingLiveItems($items)
    {
        foreach ($items as $k => $item) {

            $pageId = Path::unParsePageId($item->page_id);
            if ($item->isHiddenPage($pageId)) {
                unset($items[$k]);
                continue;
            }
            $page = Page::preload($pageId);
            if (!$page->exists || !$page->is_live()) {
                unset($items[$k]);
                continue;
            }
            /* Modificacion para filtrar resultados de menus por Marca, Pais y lenguaje */
            if($item->page->brand_id != Session::get('portal.main.brand.id')
                || $item->page->country_id != Session::get('portal.main.country_id')
                || !$page->pageFrontLang){
                unset($items[$k]);
            }
        }
        //dd($items);
        return array_values($items);
    }

    /**
     * @param $pageId
     * @return bool
     */
    protected function _isActivePage($pageId)
    {
        $this->_loadActivePages();
        return ($pageId == $this->activePageId || in_array($pageId, $this->activeParentIds));
    }

    /**
     * @param bool $force
     */
    protected function _loadActivePages($force = false)
    {
        if ($force || !isset($this->activePageId)) {
            $this->activeParentIds = [];
            $pageLevels = PageBuilderFacade::getData('pageLevels') ?: [];
            foreach ($pageLevels as $k => $parentPage) {
                if ($k > 0) { // ignore home page
                    $this->activeParentIds[] = $parentPage->page_id;
                }
            }
            $page = PageBuilderFacade::getData('page') ?: new Page;
            $this->activePageId = (int) $page->id;
        }
    }

}