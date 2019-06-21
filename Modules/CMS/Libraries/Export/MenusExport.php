<?php namespace Modules\CMS\Libraries\Export;

use Modules\CMS\Libraries\Export\Menus\MenuItemsExport;
use Modules\CMS\Entities\Menu;

class MenusExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = Menu::class;

    /**
     *
     */
    public function run()
    {
        parent::run();
        $itemsExport = new MenuItemsExport($this->_exportPath);
        $itemsExport->run();
    }

}