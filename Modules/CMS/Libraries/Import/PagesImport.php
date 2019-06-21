<?php namespace Modules\CMS\Libraries\Import;

use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageGroupPage;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\PagePublishRequests;
use Modules\CMS\Entities\PageVersion;
use Modules\CMS\Entities\Template;
use Illuminate\Support\Facades\DB;

class PagesImport extends AbstractImport
{
    /**
     * @var Page
     */
    protected $_currentPage;

    /**
     * @var PageLang
     */
    protected $_currentPageLang;

    /**
     * @var PageGroupPage[]
     */
    protected $_newPageGroupPages;

    /**
     * @var array
     */
    protected $_templateIds;

    /**
     *
     */
    const IMPORT_FILE_DEFAULT = 'pages.csv';

    /**
     * @return array
     */
    public function fieldMap()
    {
        return [
            'Page Id' => [
                'mapTo' => ['Page', 'id'],
            ],
            'Page Name' => [
                'mapTo' => ['PageLang', 'name'],
                'validate' => 'required'
            ],
            'Page Url' => [
                'mapTo' => ['PageLang', 'url'],
                'validate' => 'required'
            ],
            'Page Live Version' => [
                'mapTo' => ['PageLang', 'live_version'],
                'default' => 1
            ],
            'Page Language Id' => [
                'mapTo' => ['PageLang', 'language_id'],
                'default' => config('cms.frontend.language')
            ],
            'Page Template' => [
                'mapTo' => ['Page', 'template'],
                'mapFn' => '_mapTemplate'
            ],
            'Parent Page Id' => [
                'mapTo' => ['Page', 'parent'],
                'default' => 0
            ],
            'Default Child Template' => [
                'mapTo' => ['Page', 'child_template'],
                'default' => 0
            ],
            'Page Order Value' => [
                'mapTo' => ['Page', 'order'],
                'default' => 1000
            ],
            'Is Link (0 or 1)' => [
                'mapTo' => ['Page', 'link'],
                'default' => 0
            ],
            'Is Live (0 or 1)' => [
                'mapTo' => ['Page', 'live'],
                'default' => 1
            ],
            'In Sitemap (0 or 1)' => [
                'mapTo' => ['Page', 'sitemap'],
                'default' => 1
            ],
            'Container for Group Id' => [
                'mapTo' => ['Page', 'group_container'],
                'default' => 0
            ],
            'Container Url Priority' => [
                'mapTo' => ['Page', 'group_container_url_priority'],
                'default' => 0
            ],
            'Canonical Parent Page Id' => [
                'mapTo' => ['Page', 'canonical_parent'],
                'default' => 0
            ],
            'Group Ids (Comma Separated)' => [
                'mapFn' => '_mapGroups'
            ]
        ];
    }

    /**
     *
     */
    protected function _beforeRun()
    {
        // wipe data
        DB::table((new Page)->getTable())->truncate();
        DB::table((new PageLang)->getTable())->truncate();
        DB::table((new PageVersion)->getTable())->truncate();
        DB::table((new PageGroupPage)->getTable())->truncate();
        DB::table((new PagePublishRequests)->getTable())->truncate();

        $this->_templateIds = [];
        $templates = Template::get();
        foreach ($templates as $template) {
            $this->_templateIds[$template->template] = $template->id;
        }
    }

    /**
     *
     */
    protected function _beforeRowMap()
    {
        $this->_currentPage = new Page;
        $this->_currentPageLang = new PageLang;
    }

    /**
     * @param array $importInfo
     * @param string $importFieldData
     */
    protected function _mapTo($importInfo, $importFieldData)
    {
        list($model, $attribute) = $importInfo['mapTo'];
        $this->{'_current'.$model}->$attribute = $importFieldData;
    }

    /**
     *
     */
    protected function _afterRowMap()
    {
        $this->_currentPage->save();
        $this->_currentPageLang->page_id = $this->_currentPage->id;
        $this->_currentPageLang->save();
        foreach ($this->_newPageGroupPages as $newPageGroupPage) {
            $newPageGroupPage->page_id = $this->_currentPage->id;
            $newPageGroupPage->save();
        }
        PageVersion::add_new($this->_currentPage->id);
    }

    /**
     * @param string $importFieldData
     * @return string
     */
    protected function _mapTemplate($importFieldData)
    {
        $templateName = trim($importFieldData);
        return array_key_exists($templateName, $this->_templateIds) ? $this->_templateIds[$templateName] : config('admin.config.default_template');
    }

    /**
     * @param $importFieldData
     */
    protected function _mapGroups($importFieldData)
    {
        $this->_newPageGroupPages = [];
        $groupIds = $importFieldData ? explode(',', $importFieldData) : [];
        foreach ($groupIds as $groupId) {
            $newPageGroupPage = new PageGroupPage;
            $newPageGroupPage->group_id = $groupId;
            $this->_newPageGroupPages[] = $newPageGroupPage;
        }
    }

}