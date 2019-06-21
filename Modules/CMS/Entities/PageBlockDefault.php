<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;

use Request;

class PageBlockDefault extends Eloquent
{
    use DataPreLoad;

    protected $table = 'cms_page_blocks_default';

    public static function updateBlockData($content, $blockId, $versionId) {
        
        if (Request::has('duplicate_language') && Request::input('duplicate_language') !=0) {
            $block = new static;
            if (Request::input('brand_id') && Request::input('country_id') && Request::input('language_id')) {
                $block->brand_id = Request::input('brand_id');
                $block->country_id = Request::input('country_id');
                $block->language_id = Request::input('language_id');
            } else {
                $block->language_id = \Modules\Admin\Entities\Language::current();
            }

            $block->block_id = $blockId;
            $block->content = $content;
            $block->version = $versionId;
            $block->save();
        } else {
            if (Request::input('brand_id') && Request::input('country_id') && Request::input('language_id')) {
                $previousData = static::where('block_id', '=', $blockId)
                                ->where('brand_id', '=', Request::input('brand_id'))
                                ->where('country_id', '=', Request::input('country_id'))
                                ->where('language_id', '=', Request::input('language_id'))
                                ->orderBy('version', 'desc')->first();
            } else {
                $previousData = static::where('block_id', '=', $blockId)->where('language_id', '=', \Modules\Admin\Entities\Language::current())->orderBy('version', 'desc')->first();
            }

            if (!empty($previousData) && $previousData->version > $versionId) {
                throw new \Exception('VersionId (' . $versionId . ') for the new data must be higher than the previous versionId (' . $previousData->version . ')!');
            }
            if (empty($previousData) || (!empty($previousData) && $previousData->content !== $content)) {
                $block = new static;
                if (Request::input('brand_id') && Request::input('country_id') && Request::input('language_id')) {
                    $block->brand_id = Request::input('brand_id');
                    $block->country_id = Request::input('country_id');
                    $block->language_id = Request::input('language_id');
                } else {
                    $block->language_id = \Modules\Admin\Entities\Language::current();
                }

                $block->block_id = $blockId;
                $block->content = $content;
                $block->version = $versionId;
                $block->save();
            }
        }
    }

    public static function getBlockData($blockId, $versionId)
    {
        $getDataQuery = static::where('block_id', '=', $blockId)->where('language_id', '=', \Modules\Admin\Entities\Language::current());
        if (!empty($versionId)) {
            $getDataQuery = $getDataQuery->where('version', '<=', $versionId);
        }
        $blockData = $getDataQuery->orderBy('version', 'desc')->first();
        return $blockData ? $blockData->content : null;
    }

    /**
     * @return Collection
     */
    protected static function _preloadCollection()
    {
        return Block::getDataForVersion(new static, 0);
    }

    /**
     * @return array
     */
    protected static function _preloadByColumn()
    {
        return [['block_id', 'language_id']];
    }

}