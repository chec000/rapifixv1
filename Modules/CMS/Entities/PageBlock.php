<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Request;

class PageBlock extends Eloquent
{
    use DataPreLoad;

    /**
     * @var string
     */
    protected $table = 'cms_page_blocks';

    /**
     * @var array
     */
    protected static $_preloadDone = [];

    /**
     * @param $content
     * @param $blockId
     * @param $versionId
     * @param $pageId
     * @throws \Exception
     */
    public static function updateBlockData($content, $blockId, $versionId, $pageId)
    {
        //dd($versionId);
        if (Request::input('duplicate_language')) {
            $language_id = Request::input('duplicate_language');
        } else if (Request::input('language_id')) {
            $language_id = Request::input('language_id');
        } else {
            $language_id = \Modules\Admin\Entities\Language::current();
        }
        
        if(Request::has('duplicate_language') && Request::input('duplicate_language') !=0 ){
            $block = new static;
            $block->block_id = $blockId;
            $block->page_id = $pageId;
            $block->language_id = $language_id;
            $block->content = $content;
            $block->version = $versionId;
            $block->save();            
        }else{

        $previousData = static::where('block_id', '=', $blockId)->where('page_id', '=', $pageId)->where('language_id', '=', $language_id)->orderBy('version', 'desc')->first();
        if (!empty($previousData) && $previousData->version > $versionId) {
            throw new \Exception('VersionId ('.$versionId.') for the new data must be higher than the previous versionId ('.$previousData->version.')!');
        }
        if (empty($previousData) || (!empty($previousData) && $previousData->content !== $content)) {
            $block = new static;
            $block->block_id = $blockId;
            $block->page_id = $pageId;
            $block->language_id = $language_id;
            $block->content = $content;
            $block->version = $versionId;
            $block->save();
        }            
        }

    }

    /**
     * @param $blockId
     * @param $versionId
     * @param $pageId
     * @return mixed|null
     */
    public static function getBlockData($blockId, $versionId, $pageId)
    {
        $getDataQuery = static::where('block_id', '=', $blockId)->where('page_id', '=', $pageId)->where('language_id', '=', \Modules\Admin\Entities\Language::current());
        if (!empty($versionId)) {
            $getDataQuery = $getDataQuery->where('version', '<=', $versionId);
        }
        $blockData = $getDataQuery->orderBy('version', 'desc')->first();
        return $blockData ? $blockData->content : null;
    }

    /**
     * Load all page block data for a page
     * @param $pageId
     * @param int $version
     * @return PageBlock[][] array keys block_id then language_id
     */
    public static function preloadPage($pageId, $version = 0)
    {
        static::_preloadDataByPage($pageId, $version);
        return static::_preloadGet('byVersionPage', [$version, $pageId]) ?: [];
    }

    /**
     * Load all page block data for block on page,
     * @param $pageId
     * @param $blockId
     * @param int $version
     * @param string $preloadBy
     * @return PageBlock[] array key is language_id
     */
    public static function preloadPageBlock($pageId, $blockId, $version = 0, $preloadBy = 'page_id')
    {
        ($preloadBy == 'page_id') ? static::_preloadDataByPage($pageId, $version) : static::_preloadDataByBlock($blockId, $version);
        return static::_preloadGet('byVersionPage', [$version, $pageId, $blockId]) ?: [];
    }

    /**
     * Load page block data for block on page in current language
     * @param $pageId
     * @param $blockId
     * @param int $version
     * @param string $preloadBy
     * @return static
     */
    public static function preloadPageBlockLanguage($pageId, $blockId, $version = 0, $preloadBy = 'page_id', $brandId = 0, $countryId = 0,$language_id=0)
    {
   ($preloadBy == 'page_id') ? static::_preloadDataByPage($pageId, $version) : static::_preloadDataByBlock($blockId, $version);           
        if($brandId != 0 && $countryId != 0){           
            return  static::_preloadGet('byVersionPage', [$version, $pageId, $blockId,$language_id]) ?: new static; 
            } else {
            return static::_preloadGet('byVersionPage', [$version, $pageId, $blockId, $language_id]) ?: new static;
        }

    }
    
    public static function preleadPageBlockContent($pageId, $blockId, $version = 0, $preloadBy = 'page_id', $brandId = 0, $countryId = 0,$language_id=0){
    
           ($preloadBy == 'page_id') ? static::_preloadDataByPage($pageId, $version) : static::_preloadDataByBlock($blockId, $version);           
        if($brandId != 0 && $countryId != 0){       
            $data=  static::_preloadGetBlock('byVersionPage', [$version, $pageId, $blockId,$language_id]);
       if($data!=null){
           return $data;
       }else{
           return null;
       }
//            return  static:: _preloadGetBlock('byVersionPage', [$version, $pageId, $blockId,$language_id]) ?: new static; 
            } else {
            return static:: _preloadGetBlock('byVersionPage', [$version, $pageId, $blockId, $language_id]) ?: new static;
        }
    }
    

    /**
     * @param $pageIds
     * @param $version
     */
    protected static function _preloadDataByPage($pageIds, $version)
    {
        $unloadedPageIds = [];
        $pageIds = is_array($pageIds) ? $pageIds : [$pageIds];
        foreach ($pageIds as $pageId) {
            $doneKey = 'v' . $version . 'p' . $pageId;
            if (empty(static::$_preloadDone[$doneKey])) {
                $unloadedPageIds[] = $pageId;
                static::$_preloadDone[$doneKey] = true;
            }
        }
        if ($unloadedPageIds) {
            $pageBlocks = Block::getDataForVersion(new static, $version, ['page_id' => $unloadedPageIds]);
            static::_preload($pageBlocks, 'byVersionPage', [['@'.$version, 'page_id', 'block_id', 'language_id']]);
        }
    }

    /**
     * @param $blockIds
     * @param $version
     */
    protected static function _preloadDataByBlock($blockIds, $version)
    {
        $unloadedBlockIds = [];
        $blockIds = is_array($blockIds) ? $blockIds : [$blockIds];
        foreach ($blockIds as $blockId) {
            $doneKey = 'v' . $version . 'b' . $blockId;
            if (empty(static::$_preloadDone[$doneKey])) {
                $unloadedBlockIds[] = $blockId;
                static::$_preloadDone[$doneKey] = true;
            }
        }
        if ($unloadedBlockIds) {
            $pageBlocks = Block::getDataForVersion(new static, $version, ['block_id' => $unloadedBlockIds]);
            static::_preload($pageBlocks, 'byVersionPage', [['@'.$version, 'page_id', 'block_id', 'language_id', 'brand_id', 'country_id']]);
        }
    }

    /**
     * Load page block data for all live versions of a block across all pages
     * @param int $blockId
     * @param bool $reload
     * @return PageBlock[]
     */
    public static function livePageBlocksForBlock($blockId, $reload = false)
    {
        if ($reload) {
            static::_preloadClear('liveBlocks');
        }
        if (!static::_preloadIsset('liveBlocks', $blockId)) {
            $pageBlocks = Block::getDataForVersion(new static, -1, ['block_id' => $blockId, 'language_id' => \Modules\Admin\Entities\Language::current()]);
            static::_preload($pageBlocks, 'liveBlocks', [['block_id']], null, true);
        }
        return static::_preloadGet('liveBlocks', $blockId) ?: [];
    }

}
