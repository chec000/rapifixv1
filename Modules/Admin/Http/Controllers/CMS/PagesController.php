<?php

namespace Modules\Admin\Http\Controllers\CMS;

use Auth;
use Modules\Admin\Entities\ACL\User;
use Modules\CMS\Helpers\DateTimeHelper;
use Modules\CMS\Helpers\Page\PageCache;
use Modules\CMS\Helpers\Page\Path;
use Modules\CMS\Http\Controllers\StartController;
use Modules\CMS\Libraries\Blocks\Repeater;
use Modules\CMS\Helpers\View\PaginatorRender;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Shopping\Entities\Legal;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Block;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\BrandCountry;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageLang;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\PageGroup;
use Modules\CMS\Entities\PagePublishRequests;
use Modules\CMS\Entities\PageVersion;
use Modules\CMS\Entities\PageVersionSchedule;
use Modules\CMS\Entities\ThemeTemplate;
use Modules\Admin\Entities\HistorialModel;
use Modules\CMS\Libraries\Builder\FormMessage;
use Illuminate\Http\Request as rqs;
use Request;
use Response;
use View;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller {

    public function getIndex() {
        $rootPages = Page::join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id')->where(function ($query) {
                    $query->whereIn('cms_page_lang.url', ['', '/']);
                })->where('cms_page_lang.language_id', '=', \Modules\Admin\Entities\Language::current())->where('link', '=', 0)->get(['cms_pages.*'])->all();
        $rootPageIds = array_map(function($rootPage) {
            return 'list_' . $rootPage->id;
        }, $rootPages);
        if (empty(Request::all())) {
            $brand_id = 0;
            $country_id = 0;
            $lang_id = 0;
        } else {
            $brand_id = Request::get('brand_id');
            $country_id = Request::get('country_id');
            $lang_id = Request::get('language_id');
        }
        $brand_filter = $brand_id;
        $country_filter = $country_id;
        $language_filter = $lang_id;

        $brands = Brand::selectArrayBrandUseractive();
        $countries = BrandCountry::selectCountryBrandUser($brand_id);
        $languages = Country::selectArrayCountryLanguages($country_id);

        $this->layoutData['content'] = View::make('admin::cms.pages.pages', array(
                    'add_page' => Auth::action('pages.add'),
                    'page_states' => Auth::user()->getPageStates(),
                    'max' => Page::at_limit(),
                    'rootPageIds' => $rootPageIds,
                    'brands' => $brands,
                    'countries' => $countries,
                    'languages' => $languages,
                    'brand_filter' => $brand_filter,
                    'country_filter' => $country_filter,
                    'language_filter' => $language_filter,
                    'groups_exist' => PageGroup::count()));

        $this->layoutData['modals'] = View::make('admin::modals.general.delete_item')->render() .
                View::make('admin::cms.modals.pages.history', ['pages' => $this->getPages()])->render();
    }

    public function getPagesByParameters(rqs $request) {
        $pages = Page::getPagesByParameters($request->brand_id, $request->country_id, $request->language_id);
        if ($pages != null) {
            $response = array(
                'data' => $pages,
                'code' => 200
            );
        } else {
            $response = array(
                'data' => trans('admin::pages.message'),
                'code' => 500
            );
        }

        return $response;
    }

    public function getAdd($parentPageId = 0, $groupId = 0) {
        //dd(Request::all());
        $brand = Brand::find(!empty(Request::get('brand_id')) ? Request::get('brand_id') : 0);
        $country = Country::find(!empty(Request::get('country_id')) ? Request::get('country_id') : 0);
        $language = Language::find(!empty(Request::get('language_id')) ? Request::get('language_id') : 0);
       if(Request::has('groupId')){
           $groupId=Request::get('groupId');
       }
        $publishingOn = config('admin.config.publishing') > 0;
        $cabPublish = ($publishingOn && Auth::action('pages.version-publish', ['page_id' => $parentPageId]))
            || (!$publishingOn && Auth::action('pages.edit', ['page_id' => $parentPageId]));
 
        $page = new Page;
        if ($parentPageId && $parent = Page::find($parentPageId)) {
            $page->parent = $parent->id;
            $page->template = $parent->child_template;
        } else {
            $page->parent = 0;
        }
        if ($groupId && $group = PageGroup::find($groupId)) {
            $page->groups->add($group);
            $page->template = $group->default_template;
            $page->parent = $parentPageId ? $page->parent : -1;
        }
        $page->group_container = 0;
        $page->link = 0;
        $page->live = $cabPublish ? 1 : 0;
        $page->sitemap = 1;

        // get item name, or default to page
        $item_name = $page->groupItemsNames() ?: trans('admin::pages.item');

        // get page info tab contents
        $tab_headers = [];
        $tab_contents = [];
        list($tab_headers[0], $tab_contents[0]) = $page->tabInfo();
        $tab_data = [
            'headers' => View::make('admin::cms.partials.tabs.header', ['tabs' => $tab_headers])->render(),
            'contents' => View::make('admin::cms.partials.tabs.content', ['tabs' => $tab_contents, 'item' => $item_name, 'new_page' => true, 'publishing' => $publishingOn, 'can_publish' => $cabPublish, 'page' => $page])->render()
        ];

        $this->layoutData['content'] = View::make('admin::cms.pages.pages.add', [
            'page' => $page,
            'item_name' => $item_name,
            'tab' => $tab_data,
            'country' => $country,
            'brand' => $brand,
            'language' => $language
        ]);
    }

    private function exitPage($country_id, $language_id, $url, $brand_id) {
        try {
            $result = array();
            $pageOld = Page::join('cms_page_lang', 'cms_pages.id', '=', 'cms_page_lang.page_id')
                ->where([
                    ['brand_id', '=', $brand_id],
                    ['country_id', '=', $country_id],
                    ['link', '=', 0],
                    ['cms_page_lang.url', '=', $url],
                    ['cms_page_lang.language_id', '=', $language_id]
                ])->first();

            if ($pageOld != null) {
                $result = ['exist' => true, 'page_id' => $pageOld->page_id];
            } else {
                $result = ['exist' => false, 'page_id' => null];
            }
        } catch (Exception $ex) {
            return $result = ['exist' => false, 'page_id' => null];
        }

        return $result;
    }

    private function getOldPage($country_id, $brand_id, $url) {
        try {
            $page = Page::join('cms_page_lang', 'cms_pages.id', '=', 'cms_page_lang.page_id')
                ->where([['country_id', '=', $country_id],
                    ['brand_id', '=', $brand_id],
                    ['link', '=', 0],
                    ['cms_page_lang.url', '=', $url]
                ])->select('cms_pages.*')->first();
            return $page;
        } catch (Exception $ex) {
            return null;
        }
    }

    private function getLink($brand_id, $country_id, $language_id, $name) {
        try {
            $pageLink = Page::join('cms_page_lang', 'cms_pages.id', '=', 'cms_page_lang.page_id')
                ->where([
                    ['brand_id', '=', $brand_id],
                    ['country_id', '=', $country_id],
                    ['cms_page_lang.name', '=', $name],
                    ['cms_page_lang.language_id', '!=', $language_id]
                ])->select('cms_pages.*')->first();
            return $pageLink;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function postAdd($pageId = 0, $groupId = 0) {                  
        $page_version = PageVersion::prepareNew();
        $page_name = Request::input("page_info_lang");
        $page_info = Request::input('page_info') ?: [];
        $page_info_lang = Request::input('page_info_lang') ?: [];
        $page_groups = Request::input('page_groups') ?: [];         
        $page_info_other = Request::input('page_info_other') ?: [];
        $page_info['brand_id'] = Request::input('brand_id');
        $page_info['country_id'] = Request::input('country_id');
        $page_info_lang['language_id'] = Request::input('language_id');
        $langUrl = Request::input('page_info_lang');
        $parentPage = $this->getOldPage(Request::input('country_id'), Request::input('brand_id'), $langUrl['url']);
        $exist = $this->exitPage(Request::input('country_id'), Request::input('language_id'), $langUrl['url'], Request::input('brand_id'));
       
        if ($exist['exist']) {
            FormMessage::add('page_info_lang[url]', trans('admin::pages.validation_url'));
            return $this->getAdd();
        } else if ($parentPage != null) {
            $page = $parentPage;
        } else {
            $link = $this->getLink(Request::input('brand_id'), Request::input('country_id'), Request::input('language_id'), $page_name['name']);
            if ($link != null) {
                if ($link->link == 1) {
                    $page = $link;
                }
            } else {
                $page = new Page;
            }
        }
        $pageCurrentExist = Page::join('cms_page_lang', 'cms_pages.id', '=', 'cms_page_lang.page_id')
            ->where([
                ['template', '=', $page_info['template']['select']],
                ['brand_id', '=', $page_info['brand_id']],
                ['country_id', '=', $page_info['country_id']],
                ['cms_page_lang.url', '=', $langUrl['url']],
            ])->select('cms_pages.*', 'cms_page_lang.url')->first();

        $pageConfId = $pageCurrentExist != null ? $pageCurrentExist->id : null;

        if (!$page->savePostData($page_version, $page_info, $page_info_lang, $page_groups, $page_info_other, false, $pageConfId)) {
            $this->getAdd($pageId);
            return null;
        } else {
            $pageIdCreated = $pageConfId != null ? $pageConfId : $page->id;
            //$pageLangName =  $pageConfId!=null ?  $page_info_lang['name'] : $page->pageCurrentLangFilter->name;
            $pageLangName = $page_info_lang['name'];
            AdminLog::new_log('Added page \'' . $pageLangName . '\' (Page ID ' . $pageIdCreated . ')');

//         return $this->getIndex();
            return \redirect()->route('admin.pages.edit', ['pageId' => $pageIdCreated, 'version' => 0, 'language' => Request::input('language_id')]);
        }
    }

    public function getEdit($pageId, $versionId = 0, $language_id = null) {
        // get page data

        if (!($page = Page::find($pageId))) {
            return 'Page Not Found';
        }
        $brand = Brand::find($page->brand_id);
        $country = Country::find($page->country_id);
        $language = Language::find($language_id);

        PageVersionSchedule::checkPageVersionIds();

        $publishingOn = config('admin.config.publishing') > 0;
        $auth = [
            'can_publish' => ($publishingOn && Auth::action('pages.version-publish', ['page_id' => $pageId])) || (!$publishingOn && Auth::action('pages.edit', ['page_id' => $pageId])),
            'can_duplicate' => $page->canDuplicate(),
            'can_preview' => Auth::action('pages.preview')
        ];

        // get page lang data

        $flat = ($language_id != null);
        $page->setLangEdit($language_id);
        //dd($page->pageCurrentLangFilter);
        if (!($page_lang = ($flat) ? $page->pageCurrentLangFilter : $page->pageCurrentLang)) {
            if (!($page_lang = ($flat) ? $page->pageCurrentLangFilter : $page->pageCurrentLang )) {
                return 'Page Lang Data Not Found';
            }
            $page_lang->language_id = ($flat) ? $language_id : \Modules\Admin\Entities\Language::current();
            $page_lang = $page_lang->replicate();

            $page_lang->save();
        }
        $page_lang->url = ltrim($page_lang->url, '/');

        $versionData = [];
        $versionData['latest'] = PageVersion::latest_version($pageId);
        $versionData['editing'] = ($versionId == 0 || $versionId > $versionData['latest']) ? $versionData['latest'] : $versionId;
        $versionData['live'] = $page_lang->live_version;

        $frontendLink = Path::getFullUrl($pageId);
        if (!$page->is_live() && $page->link == 0) {
            $live_page_version = PageVersion::where('page_id', '=', $pageId)->where('version_id', '=', $versionData['live'])->first();
            if (!empty($live_page_version)) {
                $frontendLink .= '?preview=' . $live_page_version->preview_key;
            }
        }

        // if loading a non live version get version template rather than current page template
        if ($versionData['live'] != $versionData['editing']) {
            if ($page_version = PageVersion::where('version_id', '=', $versionData['editing'])->where('page_id', '=', $pageId)->first()) {
                $page->template = $page_version->template;
            } else {
                return 'Page Version Data Not Found';
            }
        }
        // load blocks content
        if ($page->link == 0) {

            $blocks = ThemeTemplate::templateBlocks(config('cms.frontend.theme'), $page->template);

            $blocks_content = PageBlock::preloadPage($pageId, $versionData['editing']);
            $blocks_content['page_id'] = $pageId;
//        dd($blocks);
            list($tab_headers, $tab_contents) = Block::getTabs($blocks, $blocks_content, $page->id, $versionId, $language_id);
        } else {
            $tab_headers = [];
            $tab_contents = [];
        }
//        dd($tab_contents);
        // load page info and order so page info is first and block categories are in order
        list($tab_headers[0], $tab_contents[0]) = $page->tabInfo();
        ksort($tab_headers);

        // load version / publish requests
        if ($publishingOn && count($tab_headers) > 1) {
            $tab_headers[-1] = 'Versions';
            $tab_contents[-1] = View::make('admin::cms.partials.tabs.versions.main', ['content' => PageVersion::version_table($page->id)])->render();
            list($tab_headers[-2], $tab_contents[-2]) = $page->tabRequests();
        }


        // remove empty tabs
        $tab_headers = array_filter($tab_headers);
//        dd($tab_contents);
        // get item name, or default to page
        $item_name = $page->groupItemsNames() ?: 'Page';

        $tab_data = [
            'headers' => View::make('admin::cms.partials.tabs.header', ['tabs' => $tab_headers])->render(),
            'contents' => View::make('admin::cms.partials.tabs.content', ['tabs' => $tab_contents, 'item' => $item_name, 'new_page' => false, 'publishing' => $publishingOn, 'can_publish' => $auth['can_publish'], 'page' => $page])->render()
        ];

        // add required modals
        if ($publishingOn) {
            $intervals = PageVersionSchedule::selectOptions();
            $this->layoutData['modals'] = View::make('admin::cms.modals.pages.publish')->render() .
                    View::make('admin::cms.modals.pages.publish_schedule', ['intervals' => $intervals, 'live_version' => $versionData['live']])->render() .
                    View::make('admin::cms.modals.pages.request_publish')->render() .
                    View::make('admin::cms.modals.pages.rename_version')->render();
        }

        if ($page->parent > 0) {
           $page_lang->url= $this->getSubURL($page->parent, $page_lang->language_id,$page_lang->url);
        }

        $this->layoutData['content'] = View::make('admin::cms.pages.pages.edit', [
                    'page' => $page,
                    'page_lang' => $page_lang,
                    'item_name' => $item_name,
                    'publishingOn' => $publishingOn,
                    'tab' => $tab_data,
                    'frontendLink' => $frontendLink,
                    'version' => $versionData,
                    'auth' => $auth,
                    'country' => $country,
                    'brand' => $brand,
                    'language' => $language,
                    'brands' => Brand::selectArrayBrandUseractive(),
                    'countries' => BrandCountry::selectCountryBrandUser(0),
                    'languages' => Country::selectArrayCountryLanguages(0)
        ]);
        return null;
    }

    private function getSubURL($parent, $language_id,$url) {
        try {
            $page_url = PageLang::where([['page_id', '=', $parent],
                            ['language_id', '=', $language_id]
                    ])->select('url')->first();
            $page_url_custom=$page_url->url.'/'.$url;
        return $page_url_custom;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function postEdit($pageId) {
        $existingPage = Page::find($pageId);
        if (!$existingPage) {
            return 'Page not found';
        }
        $langPagEdit = (Request::input('duplicate') == 1) ? Request::input('duplicate_language') : Request::input('language_id');

        $publish = false;
        $publishing = (bool) config('admin.config.publishing');
        $canPublish = Auth::action('pages.version-publish', ['page_id' => $pageId]);
        if ($publishing && $existingPage->link == 0) {
            // check if publish
            if (Request::input('publish') != '' && $canPublish) {
                $publish = true;
                // check if there were requests to publish the version being edited
                $overwriting_page_version = PageVersion::where('version_id', '=', Request::input('versionFrom'))->where('page_id', '=', $pageId)->first();
                $requests = PagePublishRequests::where('page_version_id', '=', $overwriting_page_version->id)->where('status', '=', 'awaiting')->get();
                if (!$requests->isEmpty()) {
                    foreach ($requests as $request) {
                        $request->status = 'approved';
                        $request->mod_id = Auth::user()->id;
                        $request->save();
                    }
                }
            }
        } elseif (!$publishing || ($existingPage->link == 1 && $canPublish)) {
            $publish = true;
        }

        $page_info = Request::input('page_info') ?: [];
        $page_info_lang = Request::input('page_info_lang') ?: [];
        $page_groups = Request::input('page_groups') ?: [];
        $page_info_other = Request::input('page_info_other') ?: [];

        // run if duplicate button was hit
        if (Request::input('duplicate') == 1) {
            $currentUrl = Request::input('duplicate_url');
            $page_info['brand_id'] = Request::input('duplicate_brand');
            $page_info['country_id'] = Request::input('duplicate_country');
            $page_info_lang['language_id'] = Request::input('duplicate_language');
            $targetCodes = Page::where('code', $page_info['code'])
                ->where('brand_id', $page_info['brand_id'])
                ->where('country_id', $page_info['country_id'])->get();
            if (count($targetCodes) > 0) {
                $this->addAlert('danger', trans('admin::pages.errors.duplicate_code'));
                return $this->getEdit($pageId, 0, Request::input('language_id'));
            } else {
                $targetPage = Page::join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id')
                    ->where('cms_page_lang.url', $currentUrl)
                    ->where('cms_page_lang.language_id', $page_info_lang['language_id'])
                    ->where('cms_pages.brand_id', $page_info['brand_id'])
                    ->where('cms_pages.country_id', $page_info['country_id'])->first();
                if ($targetPage != null) {
                    $this->addAlert('danger', trans('admin::pages.errors.duplicate_url'));
                    return $this->getEdit($pageId, 0, Request::input('language_id'));
                }
            }

            if ($existingPage->canDuplicate()) {
                $targetPage = Page::join('cms_page_lang', 'cms_page_lang.page_id', '=', 'cms_pages.id')
                    ->where('cms_page_lang.url', $currentUrl)->where('cms_pages.brand_id', $page_info['brand_id'])
                    ->where('cms_pages.country_id', $page_info['country_id'])->select('cms_pages.*')->first();
                if ($targetPage != null) {
                    //duplica solo lang
                    $duplicatePage = $targetPage->saveDuplicateFromPostDataOnlyLang($page_info, $page_info_lang, $page_groups, $page_info_other);
                } else {
                    //duplicate everything
                    $duplicatePage = $existingPage->saveDuplicateFromPostData($page_info, $page_info_lang, $page_groups, $page_info_other);
                }
                if ($duplicatePage) {
                    Repeater::setDuplicate();
                    /* session()->put('filters.brand_id', $page_info['brand_id']);
                      session()->put('filters.country_id', $page_info['country_id']);
                      session()->put('filters.language_id', $page_info_lang['language_id']); */
                    Block::submit($duplicatePage->id, 1, $publish);
                    return \redirect()->route('admin.pages.edit', ['pageId' => $duplicatePage->id, 'version' => 0, 'language' => $langPagEdit]);
                } else {
                    $this->addAlert('danger', 'Duplication failed');
                    return $this->getEdit($pageId, 0, $langPagEdit);
                }
            } else {
                return abort(403, 'Action not permitted');
            }
        }

        $langUrl = Request::input('page_info_lang');
        $exist = $this->exitPage(Request::input('country_id'), Request::input('language_id'), $langUrl['url'], Request::input('brand_id'));

        if ($exist['exist'] && $exist['page_id'] != $existingPage->id) {

            FormMessage::add('page_info_lang[url]', trans('admin::pages.validation_url'));
            return $this->getEdit($pageId, 0, $langPagEdit);
        }

        $page_info['brand_id'] = Request::input('brand_id');
        $page_info['country_id'] = Request::input('country_id');
        $page_info_lang['language_id'] = Request::input('language_id');

        $version = PageVersion::add_new($pageId);

        $page_back = $existingPage;
        if ($existingPage->saveEditPage($version, $page_info, $page_info_lang, $page_groups, $page_info_other)) {
            $pageLang = PageLang::where([['page_id', '=', $existingPage->id],
                            ['language_id', '=', !empty(Request::get('language_id')) ? Request::get('language_id') : 0]
                    ])->first();
            AdminLog::new_log('Updated page \'' . $pageLang->name . '\' (Page ID ' . $page_back->id . ')');
        } else {
            $this->addAlert('warning', '"Page Info" not updated (check tab for errors)');
        }

        // update blocks
        Block::submit($pageId, $version->version_id, $publish);
        $this->addAlert('success', 'Page Content Updated');

        if ($publish) {
            if (Request::input('publish_request') != '') {
                PagePublishRequests::add($pageId, $version->version_id, Request::input('request_note'));
            }
            $version->publish();
            PageCache::clear($pageId);
        }

        // display page edit form
        return $this->getEdit($pageId, $version->version_id, $langPagEdit);
    }

    public function postSort() {
        $pages = Request::input('list');
        if (!empty($pages)) {
            Page::sortPages($pages);
        }
        return 1;
    }

    public function searchPages(rqs $request) {

        try {
            $pages = Page::searchPages($request);

            if ($pages != null) {
                $response = array(
                    'data' => $pages,
                    'code' => 200
                );
            } else {
                $response = array(
                    'data' => trans('admin::pages.message'),
                    'code' => 500
                );
            }
        } catch (Exception $ex) {
            $response = array(
                'data' => trans('admin::pages.message'),
                'code' => 500
            );
        }

        return $response;
    }

    /*     * No esta completo
     */

    public function postDelete($pageId) {
        if ($page = Page::find($pageId)) {
            return json_encode($page->delete());
        }
        return Response::make('Page with ID ' . $pageId . ' not found', 500);
    }

    public function postVersions($pageId) {
        return PageVersion::version_table($pageId);
    }

    public function postVersionSchedule($pageId) {
        $publishingOn = (config('admin.config.publishing') > 0) ? true : false;
        if (!$publishingOn || !Auth::action('pages.version-publish', ['page_id' => $pageId])) {
            return 0;
        }

        $scheduledVersionId = Request::input('remove');
        if (!empty($scheduledVersionId)) {
            $scheduledVersion = PageVersionSchedule::find($scheduledVersionId);
            if (!empty($scheduledVersion)) {
                $scheduledVersion->delete();
                return 1;
            } else {
                return 0;
            }
        }

        $scheduleFrom = DateTimeHelper::jQueryToMysql(Request::input('schedule_from'));
        $scheduleTo = DateTimeHelper::jQueryToMysql(Request::input('schedule_to'));
        $scheduleToVersion = Request::input('schedule_to_version');
        $scheduleRepeat = Request::input('schedule_repeat') ?: 0;
        $versionId = Request::input('version_id');
        $pageVersion = PageVersion::where('page_id', '=', $pageId)->where('version_id', '=', $versionId)->first();

        if (!empty($pageVersion) && !empty($scheduleFrom)) {

            $pageVersionSchedule = new PageVersionSchedule;
            $pageVersionSchedule->page_version_id = $pageVersion->id;
            $pageVersionSchedule->live_from = $scheduleFrom;
            if (is_numeric($scheduleRepeat)) {
                $pageVersionSchedule->repeat_in = $scheduleRepeat;
            } else {
                $pageVersionSchedule->repeat_in_func = $scheduleRepeat;
            }
            $pageVersionSchedule->save();

            if (!empty($scheduleTo) && !empty($scheduleToVersion)) {

                $pageVersion = PageVersion::where('page_id', '=', $pageId)->where('version_id', '=', $scheduleToVersion)->first();
                if (!empty($pageVersion)) {
                    $pageVersionSchedule = new PageVersionSchedule;
                    $pageVersionSchedule->page_version_id = $pageVersion->id;
                    $pageVersionSchedule->live_from = $scheduleTo;
                    if (is_numeric($scheduleRepeat)) {
                        $pageVersionSchedule->repeat_in = $scheduleRepeat;
                    } else {
                        $pageVersionSchedule->repeat_in_func = $scheduleRepeat;
                    }
                    $pageVersionSchedule->save();
                }
            }
            return 1;
        }

        return 0;
    }

    public function postVersionRename($pageId) {
        $version_name = Request::input('version_name');
        $version_id = Request::input('version_id');
        if (!empty($pageId) && !empty($version_id)) {
            $page_version = PageVersion::where('page_id', '=', $pageId)->where('version_id', '=', $version_id)->first();
            if (!empty($page_version) && ($page_version->user_id == Auth::user()->id || Auth::action('pages.version-publish', ['page_id' => $pageId]))) {
                $page_version->label = $version_name;
                $page_version->save();
                return 1;
            }
        }
        return 0;
    }

    public function postVersionPublish($pageId) {
        $version_id = Request::input('version_id');
        if (!empty($pageId) && !empty($version_id)) {
            $page_version = PageVersion::where('page_id', '=', $pageId)->where('version_id', '=', $version_id)->first();
            if (!empty($page_version)) {
                return $page_version->publish();
            }
        }
        return 0;
    }

    public function postRequests($pageId) {
        if (empty($pageId)) {
            // block access to all requests
            return 0;
        }

        $type = Request::input('request_type');
        $type = $type ? ['status' => $type] : [];

        $show = Request::input('request_show');
        $show = $show ?: ['page' => false, 'status' => true, 'requested_by' => true];


        $requests = PagePublishRequests::all_requests($pageId, $type, 25);
        if ($requests->isEmpty()) {
            $requests = 'No awaiting requests';
            $pagination = '';
        } else {
            $pagination = PaginatorRender::admin($requests);
        }
        return View::make('admin::cms.partials.tabs.publish_requests.table', array('show' => $show, 'requests' => $requests, 'pagination' => $pagination))->render();
    }

    public function postRequestPublish($pageId) {
        $version_id = Request::input('version_id');
        $note = Request::input('note');
        return PagePublishRequests::add($pageId, $version_id, $note);
    }

    public function postRequestPublishAction($pageId) {
        $request_id = Request::input('request');
        $request = PagePublishRequests::with('page_version')->find($request_id);
        if (!empty($request)) {
            $request_action = Request::input('request_action');
            return $request->process($request_action);
        } else {
            return 0;
        }
    }

    public function getTinymcePageList() {
        $pages = array();
        $all_pages = Page::all();
        foreach ($all_pages as $page) {
            if (config('admin.config.advanced_permissions') && !Auth::action('pages', ['page_id' => $page->id])) {
                continue;
            }
            $pages[] = $page->id;
        }
        $page_details = Path::getFullPaths($pages, html_entity_decode(' &raquo; '));
        $json_array = array();
        foreach ($page_details as $page_detail) {
            $details = new \stdClass;
            $details->title = $page_detail->fullName;
            $details->value = $page_detail->fullUrl;
            $json_array[] = $details;
        }
        usort($json_array, function ($a, $b) {
            return strcmp($a->title, $b->title);
        });
        return json_encode($json_array);
    }

    public function getPages() {

        try {
            $brandsUser = User::userBrandId();
            $countriesUser = User::userCountriesPermission();
            $pages = Page::join('cms_page_lang as pl', 'cms_pages.id', '=', 'pl.page_id')
                    ->whereIn('cms_pages.brand_id', $brandsUser)
                    ->whereIn('cms_pages.country_id', $countriesUser)
                    ->get();

            if (count($pages) > 0) {
                return $this->buildHistory($pages);
            } else {
                return null;
            }
            return null;
        } catch (Exception $ex) {
            return null;
        }
    }

    private function buildHistory($pages) {

        $pages_list = array();
        if (count($pages) > 0) {
            foreach ($pages as $p) {
                $page = new HistorialModel();
                $page->setStatus($p->live);
                $page->setUrl($p->url);
                $page->setNombre($p->name);
                $country = Country::find($p->country_id);
                $page->setCountries($country['name']);
                $page->setMarcas(Brand::find($p->brand_id)['name']);
                $page->setLanguage(Language::find($p->language_id)['language']);
                if ($p->group_container > 0) {
                    $page->setStatus(2);
                } else {
                    if ($p->link == 1) {
                        $page->setStatus(1);
                    } else {
                        $page->setStatus(4);
                    }
                }
                if (!$p->is_live()) {
                    $page->setStatus(3);
                }
                array_push($pages_list, $page);
            }

            return $pages_list;
        }
    }

    public function previewPages(rqs $request) {

        try {
            $pages = Page::searchPages($request);

            if ($pages != null) {
                $response = array(
                    'data' => $pages,
                    'code' => 200
                );
            } else {
                $response = array(
                    'data' => trans('admin::pages.message'),
                    'code' => 500
                );
            }
        } catch (Exception $ex) {
            $response = array(
                'data' => trans('admin::pages.message'),
                'code' => 500
            );
        }

        return $response;
    }

    public function goToPreviewPage() {
        $brand_id_preview = Request::get('brand_id');
        $country_id_preview = Request::get('country_id');
        $language_id_preview = Request::get('language_id');
        $extra = Request::get('extra') ?: '';
        $url_preview = Request::get('url_page');
        $preview_key = Request::get('preview_key');
        $preview_key = str_replace('/', '', $preview_key);

        $brand = Brand::find($brand_id_preview);
        $domain = preg_replace('/^www\./', '', $brand->domain);

        Session::put('portal.main.domain', $domain);
        Session::put('portal.main.brand.id', $brand->id);
        Session::put('portal.main.brand.domain', $brand->domain);
        Session::put('portal.main.brand.parent_brand_id', $brand->parent_brand_id);
        Session::put('portal.main.brand.is_main', $brand->is_main);
        Session::put('portal.main.brand.favicon', $brand->favicon);
        Session::put('portal.main.brand.logo', $brand->logo);
        Session::put('portal.main.brand.name', strtolower($brand->name));
        Session::forget('portal.main.brand.countries');
        foreach ($brand->countries as $country) {
            Session::push('portal.main.brand.countries', $country);
        }

        $startController = new StartController();
        $startController->saveCountryId($country_id_preview);
        $startController->getLanguageId($language_id_preview);

        $url = $brand->domain . $extra . $url_preview . $preview_key;
        return redirect($url);
    }

}
