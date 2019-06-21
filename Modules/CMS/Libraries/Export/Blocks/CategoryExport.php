<?php namespace Modules\CMS\Libraries\Export\Blocks;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\BlockCategory;

class CategoryExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = BlockCategory::class;

}