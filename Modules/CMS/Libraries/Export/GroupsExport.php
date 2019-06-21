<?php namespace Modules\CMS\Libraries\Export;

use Modules\CMS\Libraries\Export\Groups\GroupAttributesExport;
use Modules\CMS\Entities\PageGroup;

class GroupsExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = PageGroup::class;

    /**
     *
     */
    public function run()
    {
        parent::run();
        $itemsExport = new GroupAttributesExport($this->_exportPath);
        $itemsExport->run();
    }

}