{!! Form::open() !!}

@if ($current_password)
        <!-- current password field -->
<div class="form-group {!! FormMessage::getErrorClass('current_password') !!}">
    {!! Form::label('current_password', trans('admin::userTranslations.form_edit.current_pass'), ['class' => 'control-label']) !!}
    {!! Form::password('current_password', ['class' => 'form-control']) !!}
    <span class="help-block">{!! FormMessage::getErrorMessage('current_password') !!}</span>
</div>
@endif

        <!-- password field -->
<div class="form-group {!! FormMessage::getErrorClass('new_password') !!}">
    {!! Form::label('new_password', trans('admin::userTranslations.form_edit.new_pass'), ['class' => 'control-label']) !!}
    {!! Form::password('new_password', ['class' => 'form-control']) !!}
    <span class="help-block">{!! FormMessage::getErrorMessage('new_password') !!}</span>
</div>

<!-- confirm password field -->
<div class="form-group ">
    {!! Form::label('new_password_confirmation', trans('admin::userTranslations.form_edit.confirm_int_password'), ['class' => 'control-label']) !!}
    {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
</div>

@if (isset($userId))
  <a href="{{ route('admin.users.edit', ['userId' => $userId]) }}" class="btn btn-warning"><i class="fa fa-lock"></i> Back</a>
@endif

@if($can_change_pass)
<!-- submit button -->
{!! Form::submit( trans('admin::userTranslations.form_edit.update_pass') , ['class' => 'btn btn-primary']) !!}
@endif

{!! Form::close() !!}
