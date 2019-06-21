<h1>{{ trans('admin::dashboard.header') }}</h1>
<br/>

<div class="row">
    <div class="col-md-12">
        <div class="well well-home">
            <div class="row">
                <div class="col-md-7">
                    <h2>{!! trans('admin::dashboard.hi', ['name' => Auth::user()->getName()]) !!}</h2>
                    <p>{{ trans('admin::dashboard.welcome') }}</p>
                    <p>{{ trans('admin::dashboard.click_pages') }}</p>
                </div>
                <div class="col-md-5 text-center">
                    <a href="{{ route('admin.account.index') }}" class="btn btn-default" style="margin-top:30px;">
                        <i class="fa fa-lock"></i>  &nbsp; {{ trans('admin::dashboard.account_asasettings') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($any_requests)
    <div class="row">
        <div class="col-md-12">
            <div class="well well-home">
                <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i>{{ trans('admin::dashboard.publish_request') }}</h3>
                {!! $requests !!}
                <p><a class="btn btn-default" href="{{ route('admin.home.requests') }}">{{ trans('admin::dashboard.view_request') }}</a></p>
            </div>
        </div>
    </div>
@endif

@if ($any_user_requests)
    <div class="row">
        <div class="col-md-12">
            <div class="well well-home">
                <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ trans('admin::dashboard.pending_publish') }}</h3>
                {!! $user_requests !!}
                <p><a class="btn btn-default" href="{{ route('admin.home.your-requests') }}">{{ trans('admin::dashboard.view_your_request') }}</a></p>
            </div>
        </div>
    </div>
@endif

<div class="row">
    @if ($searchLogNumber)
    <div class="col-md-6">
        <div class="well well-home">
            <h3><i class="fa fa-search" aria-hidden="true"></i> {{ trans('admin::dashboard.search_data') }} {{ $searchLogNumber?' (top '.$searchLogNumber.')':'' }}</h3>
            {!! preg_replace('/<h1.*>(.*)<\/h1>/', '', $searchLogs) !!}
            <p><a class="btn btn-default" href="{{ route('admin.search') }}">{{ trans('admin::dashboard.view_all_logs') }}</a></p>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <div class="col-md-12">
        <div class="well well-home">
            <h3><i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('admin::dashboard.site_updates') }}</h3>
            {!! $logs !!}
            <p><a class="btn btn-default" href="{{ route('admin.home.logs') }}">{{ trans('admin::dashboard.view_admin_logs') }}</a></p>
        </div>
    </div>
</div>
