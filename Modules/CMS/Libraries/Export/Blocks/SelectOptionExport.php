<?php namespace Modules\CMS\Libraries\Export\Blocks;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\BlockSelectOption;

class SelectOptionExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = BlockSelectOption::class;

}