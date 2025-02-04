<h1>Change Password</h1>

@if (isset($success) && $success)

    @if ($level == 'admin')
        <p class="text-success">Password for {!! $user->email !!} has been successfully updated!</p>
        <p><a href="{{ route('admin.users.edit', ['userId' => $user->id]) }}" class="btn btn-info">Return to user details page</a></p>
    @elseif ($level == 'user')
        <p class="text-success">Your password has been successfully updated!</p>
        <p><a href="{{ route('admin.account.index') }}" class="btn btn-info">Return to account settings</a></p>
    @else
        <p class="text-success">Your password has been successfully updated!</p>
        <p><a href="{!! route('admin.login') !!}" class="btn btn-info">You can now login here</a></p>
    @endif

@else

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input class="form-control" value="{!! $user->email !!}" id="inputIcon" type="text" title="email" disabled/>
        </div>
    </div>

    {!! $form !!}

@endif

