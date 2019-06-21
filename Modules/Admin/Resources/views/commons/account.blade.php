<h1>{{trans('admin::accountSettings.account_settings')}}</h1>

<br/>

{!! $account !!}

@if ($change_password || $setAlias)
    <!--<a href="{{ route('admin.users.edit', ['userId' => $userId]) }}" class="btn btn-warning"><i class="fa fa-lock"></i> {{trans('admin::accountSettings.edit_user')}}</a>-->
     <a href="{{ route('admin.account.password') }}" class="btn btn-warning"><i class="fa fa-unlock-alt"></i> &nbsp; {{trans('admin::accountSettings.change_pass')}}</a>
@endif

@if ($setAlias)
    <!-- <a href="{{ route('admin.account.name') }}" class="btn btn-warning"><i class="fa fa-users"></i> &nbsp; {{trans('admin::accountSettings.set_alias')}}</a> -->
@endif


@if ($auto_blog_login)
    {{ ($change_password)?'&nbsp;':'' }}
    <a href="{{ route('admin.account.blog') }}" class="btn btn-warning"><i class="fa fa-share"></i> &nbsp; {{trans('admin::accountSettings.auto_blog_logind_details')}}</a>
@endif