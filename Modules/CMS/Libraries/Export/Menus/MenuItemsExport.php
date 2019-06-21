<?php namespace Modules\CMS\Libraries\Export\Menus;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\Menu;
use Modules\CMS\Entities\MenuItem;

class MenuItemsExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = MenuItem::class;

    /**
     * @param string $data
     * @return string
     */
    protected function _convertToMenuId($data)
    {
        return Menu::preload($data)->name;
    }

}