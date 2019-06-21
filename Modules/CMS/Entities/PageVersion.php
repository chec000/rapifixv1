<?php namespace Modules\CMS\Entities;

use Auth;
use Modules\CMS\Helpers\View\PaginatorRender;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use DateTimeHelper;
use Eloquent;
use View;
use Request;

class PageVersion extends Eloquent
{
    use DataPreLoad;

    protected $table = 'cms_page_versions';

    public function user()
    {
        return $this->belongsTo('Modules\Admin\Entities\ACL\User');
    }

    public function scheduled_versions()
    {
        return $this->hasMany('Modules\CMS\Entities\PageVersionSchedule')->orderBy('live_from');
    }

    public static function latest_version($page_id, $return_obj = false)
    {
        $version = self::where('page_id', '=', $page_id)->orderBy('version_id', 'desc')->first();
        if (!empty($version)) {
            return $return_obj ? $version : $version->version_id;
        }
        return 0;
    }

    public static function can_publish($pageId)
    {
        if (config('admin.config.publishing')) {
            return Auth::action('pages.version-publish', ['page_id' => $pageId]);
        } else {
            return Auth::action('pages.edit', ['page_id' => $pageId]);
        }
    }

    public static function getLiveVersion($pageId)
    {
        if (Request::input('duplicate_language')) {
            $language_id = Request::input('duplicate_language');
        } else if (Request::input('language_id')) {
            $language_id = Request::input('language_id');
        } else {
            $language_id = \Modules\Admin\Entities\Language::current();
        }

        if (!static::_preloadIsset('liveVersions') ) {
            $pageLangTable = (new PageLang)->getTable();
            $pageVersionsTable = (new static)->getTable();

            $pageVersions = self::join($pageLangTable, function ($join) use($pageLangTable, $pageVersionsTable) {
                $join->on($pageLangTable.'.page_id', '=', $pageVersionsTable.'.page_id')->on($pageLangTable.'.live_version', '=', $pageVersionsTable.'.version_id');
            })->where('language_id', '=', $language_id)
                ->orderBy($pageLangTable.'.page_id')->get([$pageVersionsTable.'.*']);
            static::_preload($pageVersions, 'liveVersions', ['page_id']);
        }
        return static::_preloadGet('liveVersions', $pageId);
    }

    public static function add_new($page_id, $label = null)
    {
        $page_version = new self;
        $page_version->page_id = $page_id;
        $page_version->version_id = self::latest_version($page_id) + 1;
        $page_version->template = !empty($page_id) ? Page::find($page_id)->template : 0;
        $page_version->label = $label;
        $page_version->preview_key = base_convert((rand(10, 99) . microtime(true)), 10, 36);
        $page_version->save();
        return $page_version;
    }

    /**
     * Does not save automatically and requires page_id before save + other version specific page data (ie. template)
     * @param null $label
     * @return static
     */
    public static function prepareNew($label = null)
    {
        $pageVersion = new static;
        $pageVersion->version_id = 1;
        $pageVersion->label = $label;
        $pageVersion->preview_key = base_convert((rand(10, 99) . microtime(true)), 10, 36);
        return $pageVersion;
    }

    public function publish($set_live = false, $ignore_auth = false)
    {
        if (Request::input('duplicate_language')) {
            $language_id = Request::input('duplicate_language');
        } else if (Request::input('language_id')) {
            $language_id = Request::input('language_id');
        } else {
            $language_id = \Modules\Admin\Entities\Language::current();
        }

        //dd(\Modules\Admin\Entities\Language::current());
        $page_lang = PageLang::where('page_id', '=', $this->page_id)->where('language_id', '=', $language_id)->first();

        $page = Page::find($this->page_id);
        $haveAuth = $ignore_auth || static::can_publish($this->page_id);

        if (!empty($page_lang) && !empty($page) && $haveAuth) {
            $page_lang->live_version = $this->version_id;
            //dd($this);
            $page_lang->save();
            PageSearchData::updateText(strip_tags($page_lang->name), 0, $page->id);
            $page->template = $this->template;
            if ($set_live && $page->live == 0) {
                if (!empty($page->live_start) || !empty($page->live_end)) {
                    $page->live = 2;
                } else {
                    $page->live = 1;
                }
            }
            $page->save();
            return 1;
        }
        return 0;
    }

    public static function version_table($page_id)
    {
        $versionsQuery = static::with(['user', 'scheduled_versions'])->where('page_id', '=', $page_id)->orderBy('version_id', 'desc');
        $versions = $versionsQuery->paginate(15);
        $pagination = PaginatorRender::admin($versions);

        $page_lang = PageLang::where('page_id', '=', $page_id)->where('language_id', '=', \Modules\Admin\Entities\Language::current())->first();
        $live_version = static::where('page_id', '=', $page_id)->where('version_id', '=', $page_lang ? $page_lang->live_version : 0)->first();
        $live_version = $live_version ?: new static;

        $can_publish = Auth::action('pages.version-publish', ['page_id' => $page_id]);

        return View::make('admin::cms.partials.tabs.versions.table', ['versions' => $versions, 'pagination' => $pagination, 'live_version' => $live_version, 'can_publish' => $can_publish])->render();
    }

    public function save(array $options = array())
    {
        $user = Auth::user();
        if (empty($options['system']) && !empty($user)) {
            $this->user_id = $user->id;
        } else {
            $this->user_id = 0;
        }
        return parent::save($options);
    }

    public function getName()
    {
        return $this->label ?: ('version ' . DateTimeHelper::display($this->created_at, 'short'));
    }

}
