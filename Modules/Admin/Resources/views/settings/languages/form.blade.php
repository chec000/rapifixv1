<h1>{{ isset($langEdit->locale_key) ? trans('admin::language.lang_edit_title') : trans('admin::language.lang_add_title') }}</h1>
<p class="text-right"><a href="{{ route('admin.languages.list') }}">{{trans('admin::language.lang_back_list')}}</a></p>
{!! Form::open() !!}

<div class="row">
    <!-- language locale field -->
    <div class="form-group col-xs-6 {!! FormMessage::getErrorClass('locale_key') !!}">
        {!! Form::label('locale_key',  trans('admin::language.lang_add_key') , ['class' => 'control-label']) !!}
        {!! Form::text('locale_key',  old("locale_key", isset($langEdit->locale_key) ? $langEdit->locale_key : ''), isset($langEdit->locale_key) ? ['required','class' => 'form-control', 'readonly' => true ] : ['class' => 'form-control' ]) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('locale_key') !!}</span>
    </div>

    <!-- language locale field -->
    <div class="form-group col-xs-6 {!! FormMessage::getErrorClass('corbiz_key') !!}">
        {!! Form::label('corbiz_key',  trans('admin::language.lang_add_corbizkey') , ['class' => 'control-label']) !!}
        {!! Form::text('corbiz_key',  old("corbiz_key", isset($langEdit->corbiz_key) ? $langEdit->corbiz_key : ''),  ['required','class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('corbiz_key') !!}</span>
    </div>
</div>
@if(!isset($langEdit))
    <div class="row">
        <!-- language name field -->
        <div class="form-group col-xs-6 {!! FormMessage::getErrorClass('language') !!}">
            {!! Form::label('language',  trans('admin::language.lang_add_name') , ['class' => 'control-label']) !!}
            {!! Form::text('language', old("language", isset($langEdit->language) ? $langEdit->translate($langEdit->locale_key)->language : ''), ['required','class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('language') !!}</span>
        </div>

        <!-- language country field -->
        <div class="form-group col-xs-6 {!! FormMessage::getErrorClass('language_country') !!}">
            {!! Form::label('language_country',  trans('admin::language.lang_add_country') , ['class' => 'control-label']) !!}
            {!! Form::text('language_country', old("language_country", isset($langEdit->language_country) ? $langEdit->translate($langEdit->locale_key)->language_country : ''), ['required','class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('language_country') !!}</span>
        </div>
    </div>
@endif

<div>
    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::language.lang_disclaimer') }}</p>

    @foreach ($languages as $i=> $lan)
        <div role="panel-group" id="accordion-{{$lan['id'] }}">
            <div class="panel panel-default">
                <div role="tab" class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#lang-language-{{$lan['id'] }}">{{trans('admin::language.country-language-title') . $lan['language'] }}</a>
                    </h4>
                </div>
                <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="lang-language-{{$lan['id'] }}"
                     class="panel-collapse {{($lan['id'] == Session::get('language') ? 'in' : 'collapse')}}" >
                    <div class="panel-body">

                        <h3>{!! $lan->language!!}</h3>
                        <div class="form-group">
                            <!-- language name field -->
                            <div class="form-group col-xs-6">
                                <label for="language_lang" class="control-label">{{ trans('admin::language.lang_add_name') }}</label>
                                <input class="form-control" name="language_lang[]" value="{!! isset($langEdit) && isset($langEdit->translate($lan->locale_key)->language) ? $langEdit->translate($lan->locale_key)->language : '' !!}" type="text">
                            </div>
                            <!-- language country field -->
                            <div class="form-group col-xs-6">
                                <label for="language_lang" class="control-label">{{ trans('admin::language.lang_add_country') }}</label>
                                <input class="form-control" name="language_country_lang[]" value="{!!  isset($langEdit) && isset($langEdit->translate($lan->locale_key)->language_country) ? $langEdit->translate($lan->locale_key)->language_country : '' !!}" type="text">
                                <input type="hidden" name="locale_lang[]" value="{!! $lan->locale_key!!}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- submit button -->
<button type="submit" class="btn btn-primary addButton"><i class="{{ isset($langEdit->locale_key) ? 'fa fa-edit' : 'fa fa-plus' }}"></i> &nbsp; {{ isset($langEdit) ? trans('admin::language.lang_edit_button') : trans('admin::language.lang_add_button') }}</button>

{!! Form::close() !!}