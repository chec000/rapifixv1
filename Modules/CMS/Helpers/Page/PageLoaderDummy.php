<?php namespace Modules\CMS\Helpers\Page;

use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\Theme;

class PageLoaderDummy extends PageLoader
{

    /**
     * PageLoaderDummy constructor.
     * @param string $themeName
     */
    public function __construct($themeName = '')
    {
        parent::__construct();
        $this->theme = $this->theme ?: $themeName;
    }

    /**
     * 
     */
    protected function _load()
    {
        $page = new Page;
        $page->id = 0;
        $page_lang = new PageLang;
        $page_lang->name = '';
        $page_lang->url = '';
        $page_lang->live_version = 0;
        $page->setRelation('pageCurrentLang', $page_lang);
        $this->pageLevels = [$page];
    }

}