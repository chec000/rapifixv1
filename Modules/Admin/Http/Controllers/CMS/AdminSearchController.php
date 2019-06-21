<?php namespace Modules\Admin\Http\Controllers\CMS;

use Auth;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Backup;
use Illuminate\Http\Request;
use Modules\CMS\Entities\Page;
use Modules\CMS\Entities\PageBlock;
use Modules\CMS\Entities\PageGroup;
use Modules\CMS\Entities\PageGroupPage;
use Modules\CMS\Entities\PageLang;
use Modules\Admin\Entities\Language;
class AdminSearchController extends Controller
{

  function search(Request $request)
  {
    $q = $request->get('q');
    $searchEntity = $request->get('search_entity');

    $searchres = $searchEntity::adminSearch($q);
    if ($searchres->count() == 0)
    {
      return '<p>No items match your search.</p>';
    }

    return Page::getPageListView($searchres);
  }
}
