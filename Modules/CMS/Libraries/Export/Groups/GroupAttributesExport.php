<?php namespace Modules\CMS\Libraries\Export\Groups;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\PageGroupAttribute;

class GroupAttributesExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = PageGroupAttribute::class;

}