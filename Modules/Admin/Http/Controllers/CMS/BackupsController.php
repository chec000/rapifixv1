<?php namespace Modules\Admin\Http\Controllers\CMS;

use Auth;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Entities\AdminLog;
use Modules\CMS\Entities\Backup;
use Request;
use Response;

class BackupsController extends Controller
{

    public function postUndo()
    {
        if ($logIds = Request::input('log_ids')) {
            if (is_string($logIds)) {
                $logIds = [$logIds];
            }
            foreach ($logIds as $logId) {
                $log = AdminLog::find($logId);
                if ($log && ((time() - strtotime($log->created_at)) < config('admin.config.undo_time') && $log->user_id == Auth::user()->id) || Auth::action('backups.restore')) {
                    if (Backup::restore($logId) == 1) {
                        AdminLog::new_log('Restored log ID #' . $logId);
                    } else {
                        return Response::make('Error restoring log ID #'.$logId, 500);
                    }
                }
            }
            return 'Success - restored ID #' . implode(', ', $logIds);
        }
        return 'Success';
    }

}