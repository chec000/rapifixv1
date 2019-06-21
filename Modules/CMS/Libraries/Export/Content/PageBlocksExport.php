<?php namespace Modules\CMS\Libraries\Export\Content;

use Modules\CMS\Libraries\Export\AbstractExport;
use Modules\CMS\Entities\Block;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\PageBlockDefault;

class PageBlocksExport extends AbstractExport
{

    /**
     * @return object[]
     */
    protected function _loadModelData()
    {
        $pageBlocks = collect(array_merge(Block::getDataForVersion(new PageBlock, 0)->all(), Block::getDataForVersion(new PageBlockDefault, 0)->all()));

        foreach ($pageBlocks as $k => $pageBlock) {
            $block = Block::preload($pageBlock->block_id);
            if ($block->exists) {
                $this->_exportUploads = array_merge($block->getTypeObject()->exportFiles($pageBlock->content), $this->_exportUploads);
            } else {
                $pageBlocks->forget($k);
            }
        }

        return $pageBlocks;
    }

    /**
     * @param array $a
     * @param array $b
     * @return int
     */
    protected function _orderData($a, $b)
    {
        if ($a[0] == $b[0]) {
            return strcmp($a[1], $b[1]);
        }
        return $a[0] < $b[0] ? -1 : 1;
    }

}