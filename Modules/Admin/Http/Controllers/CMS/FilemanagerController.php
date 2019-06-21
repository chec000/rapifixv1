<?php namespace Modules\Admin\Http\Controllers\CMS;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
use URL;

class FilemanagerController extends Controller
{

    public function getIndex()
    {
        $this->layoutData['content'] = View::make('admin::cms.pages.filemanager', ['filemanager' => URL::to(config('admin.config.public').'/filemanager/dialog.php')]);
    }

}
