<?php namespace Modules\Admin\Http\Controllers\CMS;

use Auth;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\Admin\Helpers\Tools\Import\WpApi;
/**
 *
 */
class ImportWpController extends Controller
{
  public function postImport()
  {
    $url = request()->get('blog_url');
    $wpImport = new WpApi($url);
    $ret = $wpImport->importPosts();

    $this->layoutData['content'] = view('admin::cms.pages.tools.wordpress.import', array('url' => $url, 'can_import' => Auth::action('wpimport'), 'result' => $ret));
  }

  public function getImport()
  {
    $this->layoutData['content'] = view('admin::cms.pages.tools.wordpress.import', array('url' => '', 'can_import' => Auth::action('wpimport'), 'result' => []));
  }
}
