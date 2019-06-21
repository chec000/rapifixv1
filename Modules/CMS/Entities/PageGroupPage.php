<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Dimsav\Translatable\Translatable;

class PageGroupPage extends Eloquent
{
    use DataPreLoad, Translatable;

    public $translatedAttributes = ['name', 'item_name'];

    /**
     * @var string
     */
    protected $table = 'cms_page_group_pages';

    /**
     * @param $pageId
     * @return array
     */
    public static function getGroupIds($pageId)
    {
        static::_preloadOnce(null, 'pageGroups', ['page_id'], 'group_id', true);
        return array_unique(static::_preloadGet('pageGroups', $pageId) ?: []);
    }

    /**
     *
     */
    public static function clearGroupIds()
    {
        static::_preloadClear('pageGroups');
    }

}