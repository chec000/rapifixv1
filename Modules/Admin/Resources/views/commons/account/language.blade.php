<h1>{{ trans('admin::language.change_lang') }}</h1>

{!! Form::open() !!}

@if ($saved)
    <p class="text-success">{{ trans('admin::language.message_updated') }}</p>
@endif

<!-- confirm password field -->
<div class="form-group {!! FormMessage::getErrorClass('language') !!}">
    {!! Form::label('language',  trans('admin::language.lang'), ['class' => 'control-label']) !!}
    {!! Form::select('language', $languages, $language, ['class' => 'form-control']) !!}
    <span class="help-block">{!! FormMessage::getErrorMessage('language') !!}</span>
</div>

<!-- submit button -->
{!! Form::submit( trans('admin::language.change'), ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}