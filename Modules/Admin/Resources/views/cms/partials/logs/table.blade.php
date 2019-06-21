<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>{{ trans('admin::logs.action') }}</th>
        <th>{{ trans('admin::logs.user') }}</th>
        <th>{{ trans('admin::logs.date') }}</th>
    </tr>

    @foreach ($logs as $log)

        <tr>
            <td>{!! $log->id !!}</td>
            <td>{!! $log->log !!}</td>
            <td>{!! ($log->user)?$log->user->email:'Undefined' !!}</td>
            <td>{!! DateTimeHelper::display($log->created_at) !!}</td>
            <td>
                @if($log->backup && (((time()-strtotime($log->created_at)) < config('admin.config.undo_time') && $log->user_id == Auth::user()->id) || Auth::action('backups.restore')))
                    <a href="javascript:undo_log({!! $log->id !!})">Restore</a>
                @endif
            </td>
        </tr>

    @endforeach

</table>
