<?php namespace Modules\CMS\Helpers\Page;

use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageGroup;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\PageVersion;
use Modules\CMS\Entities\Template;
use Modules\CMS\Entities\Theme;
use Illuminate\Database\Eloquent\Builder;
use Request;

class PageLoader
{
    /**
     * @var array
     */
    public $pageLevels;

    /**
     * @var bool
     */
    public $is404;

    /**
     * @var bool
     */
    public $isLive;

    /**
     * @var null|PageVersion
     */
    public $previewVersion;

    /**
     * @var false|string
     */
    public $customTemplate;

    /**
     * @var false|string
     */
    public $feedExtension;

    /**
     * @var false|string
     */
    public $searchQuery;

    /**
     * @var string
     */
    public $theme;

    /**
     * @var string
     */
    public $template;

    /**
     * @var string
     */
    public $contentType;

    /**
     * PageLoader constructor.
     */
    public function __construct()
    {
        $this->pageLevels = [];
        $this->is404 = true;
        $this->isLive = true;
        $this->previewVersion = false;
        $this->customTemplate = false;
        $this->feedExtension = false;
        $this->searchQuery = false;
        $this->searchRequired = false;
        $this->_load();
    }

    /**
     *
     */
    protected function _load()
    {
        $this->_loadPageLevels();
        $this->_loadPageStatus();
        $this->_loadPageTemplate();
    }

    /**
     * Load all page levels for current request.
     * Also check if search page or feed page.
     */
    protected function _loadPageLevels()
    {
        $urlSegments = count(Request::segments());
              // check for homepage feed
        if ($urlSegments == 1 && substr(Request::segment(1), 0, 5) == 'root.') {
            if ($this->feedExtension = Feed::getFeedExtensionFromPath(Request::segment(1))) {
                $urlSegments = 0;
            }
        }

        // load homepage
        if (empty($this->pageLevels[0])) {
            $this->pageLevels[0] = self::_loadHomePage();
        }

        // load sub pages
        if ($urlSegments) {
            for ($i = 1; $i <= $urlSegments; $i++) {
                if (empty($this->pageLevels[$i])) {

                    $currentSegment = Request::segment($i);
                    if ($urlSegments == $i && $this->feedExtension = Feed::getFeedExtensionFromPath($currentSegment)) {
                        Feed::removeFeedExtensionFromPath($currentSegment);
                    }

                    $parentPage = $this->pageLevels[$i - 1];
                    if ($i == 1) {
                        $parentPage = isset($parentPage) ? clone $parentPage : new Page;
                        $parentPage->id = 0;
                    }

                    $this->pageLevels[$i] = self::_loadSubPage($currentSegment, $parentPage);

                    if (empty($this->pageLevels[$i])) {
                        if (($searchOffset = self::_isSearchPage($currentSegment, $parentPage)) !== false) {
                            $this->searchRequired = true;
                            $this->searchQuery = implode('/', array_slice(Request::segments(), $i - 1 + $searchOffset));
                            unset($this->pageLevels[$i]);
                            $urlSegments = $i - 1;
                        }
                        break;
                    }

                }
            }
        }

        $this->pageLevels = array_filter($this->pageLevels);
        
        if (!empty($this->pageLevels[$urlSegments])) {
            $this->is404 = false;
        } else {
            $page404 = new Page;
            $page404Lang = new PageLang;
            $page404Lang->url = '';
            $page404Lang->name = '404';
            $page404->setRelation('pageCurrentLang', $page404Lang);
            $this->pageLevels[] = $page404;
        }

        if ($this->searchQuery === false && $query = Request::input('q')) {
            $this->searchQuery = $query;
        }
        $this->searchQuery = $this->searchQuery !== false ? urldecode($this->searchQuery) : false;
    }

    /**
     * Load current page status.
     * Is live, Is preview, Custom Template
     */
    protected function _loadPageStatus()
    {
        $lowestLevelPage = count($this->pageLevels) > 0 ? end($this->pageLevels) : null;

        if ($lowestLevelPage) {

            /** @var Page $lowestLevelPage */
            $this->isLive = $lowestLevelPage->is_live();

            if (!$this->is404) {
                if ($previewKey = Request::input('preview')) {
                    $this->previewVersion = PageVersion::where('page_id', '=', $lowestLevelPage->id)->where('preview_key', '=', $previewKey)->first() ?: null;
                }
            }

        }

        if($customTemplate = Request::get('external')) {
            $this->customTemplate = 'externals.' . $customTemplate;
        }

    }

    /**
     * Load theme name, template name and content type to return
     */
    public function _loadPageTemplate()
    {
        $theme = Theme::find(config('cms.frontend.theme'));
        $lowestLevelPage = count($this->pageLevels) > 0 ? end($this->pageLevels) : null;

        $this->theme = !empty($theme) && is_dir(base_path('/resources/views/themes/' . $theme->theme)) ? $theme->theme : 'default';
        $this->template = $lowestLevelPage ? Template::name($this->previewVersion ? $this->previewVersion->template : $lowestLevelPage->template) : '';
        $this->contentType = $this->feedExtension ? Feed::getMimeType($this->feedExtension) : 'text/html; charset=UTF-8';
    }

    /**
     * @return Page|null
     */
    protected function _loadHomePage()
    {
        $paths = ['', '/'];
        return self::_pageQuery($paths, 0);
    }

    /**
     * @param string $path
     * @param Page $parentPage
     * @return Page|null
     */
    protected function _loadSubPage($path, Page $parentPage)
    {
        $paths = [$path];
        $page = self::_pageQuery($paths, $parentPage->id);

        if (!$page && $parentPage->group_container > 0) {
            $page = self::_pageQuery($paths, false, $parentPage->group_container);
            if ($page) {
                $group = PageGroup::preload($parentPage->group_container);
                $page = in_array($page->id, $group->itemPageIdsFiltered($parentPage->id)) ? $page : null;
            }
        }

        return $page;
    }

    /**
     * @param array $paths
     * @param bool|int $byParentId
     * @param bool|int $byGroupContainerId
     * @return Page|null
     */
    protected function _pageQuery($paths, $byParentId = false, $byGroupContainerId = false)
    {
        //ITS HERE
        /** @var Builder $pageQuery */
        $brand_id = session()->get('portal.main.brand.id', 0);
        $country_id = session()->get('portal.main.country_id', 0);
        $language_id = session()->get('portal.main.language_id', 0);
        

        if ($brand_id != 0 && $country_id != 0 && $language_id != 0) {
            $pageQuery = Page:: join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id')
                 ->where('cms_pages.brand_id', '=', $brand_id)
                ->where('cms_pages.country_id', '=', $country_id)
                ->where('cms_page_lang.language_id', $language_id);
        } else {
            $pageQuery = Page::join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id');
        }        
            $pageQuery->whereIn('cms_page_lang.url', $paths);
      
            //Se modificó la consulta para que se obtenga el home de los blogs
            
            
            
        $pageQuery = Page::join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id')
            ->whereIn('cms_page_lang.url', $paths);
    
        
        if ($byParentId !== false) {
            $pageQuery->where('parent', '=', $byParentId);
        }

        if ($byGroupContainerId !== false) {
            $pageQuery->join('cms_page_group_pages', 'cms_page_group_pages.page_id', '=', 'cms_pages.id')
                ->where('cms_page_group_pages.group_id', '=', $byGroupContainerId);
        }

        /** @var Page $page */
        $page = $pageQuery->first(['cms_pages.*']);
    
        //dd('brand_id: '.$brand_id.' / country_id: '.$country_id.' / page_id: '.$page->id);
        
        if (!empty($page) && $page->pageFrontLang()) {
            return $page;
        } else {
            return null;
        }
    }

    /**
     * If a search page returns an additional offset from which segment to take the search query
     * @param string $path
     * @param Page $parentPage
     * @return false|int
     */
    protected function _isSearchPage($path, Page $parentPage)
    {
        $ppIsNamedSearch = ($parentPage->pageLang() && $parentPage->pageLang()->url == 'search');
        if ($path == 'search' || $ppIsNamedSearch) {
            return $ppIsNamedSearch ? 0 : 1;
        } else {
            return false;
        }
    }

}
