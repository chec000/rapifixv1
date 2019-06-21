<?php namespace Modules\Admin\Http\Controllers\CMS;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\PageSearchLog;
use View;

class SearchController extends Controller
{

    public function getIndex()
    {
        $search_data = PageSearchLog::orderBy('count', 'DESC')->orderBy('updated_at', 'DESC')->get();
        $this->layoutData['content'] = View::make('admin::cms.pages.search', array('search_data' => $search_data));
    }


}
