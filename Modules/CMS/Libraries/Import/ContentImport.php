<?php namespace Modules\CMS\Libraries\Import;

use Modules\CMS\Entities\Block;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\PageBlockDefault;
use Modules\CMS\Entities\PageBlockRepeaterData;
use Modules\CMS\Entities\PageBlockRepeaterRows;
use Illuminate\Support\Facades\DB;

class ContentImport extends AbstractImport
{

    /**
     * ContentImport constructor.
     * @param string $importPath
     * @param bool $requiredFile
     */
    public function __construct($importPath = '', $requiredFile = false)
    {
        parent::__construct($importPath, $requiredFile);
        $childClasses = [
            Content\PageBlocksImport::class,
            Content\RepeaterBlocksImport::class
        ];
        $this->setChildren($childClasses);
    }

    /**
     *
     */
    protected function _beforeRun()
    {
        // wipe data
        DB::table((new PageBlockDefault)->getTable())->truncate();
        DB::table((new PageBlock)->getTable())->truncate();
        DB::table((new PageBlockRepeaterData)->getTable())->truncate();
        DB::table((new PageBlockRepeaterRows)->getTable())->truncate();

        Block::preload('', true); // fix block_id issue on install import
    }

}