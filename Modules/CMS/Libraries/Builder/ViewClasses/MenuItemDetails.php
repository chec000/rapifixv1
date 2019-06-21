<?php namespace Modules\CMS\Libraries\Builder\ViewClasses;

use Modules\CMS\Helpers\Page\Path;
use Modules\CMS\Entities\MenuItem;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageLang;

class MenuItemDetails
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var Page
     */
    public $page;

    /**
     * @var MenuItem
     */
    public $item;

    /**
     * @var int
     */
    public $parentPageId;

    /**
     * MenuItemDetails constructor.
     * @param MenuItem $item
     * @param bool $active
     * @param int $parentPageId
     * @param bool $canonicals
     */
    public function __construct(MenuItem $item, $active = false, $parentPageId = 0, $canonicals = false)
    {
        $pageId = Path::unParsePageId($item->page_id);
        if (!$item->id && !$canonicals) {
            $item->page_id = Path::parsePageId($pageId, $parentPageId);
        }
        
        $this->item = $item;
        $this->page = Page::preload($pageId);
        $this->parentPageId = $parentPageId;

        $this->active = $active;

        $this->name = $item->custom_name ?: PageLang::getName($pageId);
        $this->url = ($this->page && $this->page->link) ? PageLang::getUrl($pageId) : Path::getFullUrl($item->page_id);
    }

}