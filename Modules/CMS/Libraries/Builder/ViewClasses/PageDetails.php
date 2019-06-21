<?php namespace Modules\CMS\Libraries\Builder\ViewClasses;

use Modules\CMS\Helpers\Page\Path;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageLang;

class PageDetails
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     * @deprecated
     */
    public $full_url;

    /**
     * @var string
     * @deprecated
     */
    public $full_name;

    /**
     * @var string
     */
    public $urlSegment;

    /**
     * @var string
     */
    public $fullName;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Page
     */
    public $page;

    /**
     * @var PageLang
     */
    public $pageLang;

    /**
     * PageDetails constructor.
     * @param int $pageId
     * @param int $groupContainerPageId
     */
    public function __construct($pageId, $groupContainerPageId = 0)
    {
        $fullPaths = Path::getFullPath($pageId . ($groupContainerPageId ? ',' . $groupContainerPageId : ''));
        $page = Page::preload($pageId);
        $pageLang = PageLang::preload($pageId);
        
        $this->urlSegment = $pageLang->url;
        $this->url = $fullPaths->fullUrl;

        $this->name = $pageLang->name;
        $this->fullName = $fullPaths->fullName;

        $this->full_name = $this->fullName;
        $this->full_url = $this->url;

        $this->id = $page->id;

        $this->page = $page;
        $this->pageLang = $pageLang;
    }

}