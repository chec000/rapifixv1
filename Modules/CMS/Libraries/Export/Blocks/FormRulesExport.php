<?php namespace Modules\CMS\Libraries\Export\Blocks;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\BlockFormRule;

class FormRulesExport extends AbstractExport
{

    /**
     * @var string
     */
    protected $_exportModel = BlockFormRule::class;

}