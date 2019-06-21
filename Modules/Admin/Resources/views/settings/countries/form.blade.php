<h1>{{ trans('admin::countries.add_title') }}</h1>
<p class="text-right"><a href="{{ route('admin.countries.list') }}">{{trans('admin::countries.back_list')}}</a></p>
{!! Form::open() !!}

<div class="row">
    <!-- country key field -->
    <div class="col-sm-6">
            <div class="form-group  {!! FormMessage::getErrorClass('country_key') !!}">
        {!! Form::label('country_key',  trans('admin::countries.add_key') , ['required','class' => 'control-label']) !!}
        {!! Form::text('country_key',  old("country_key", isset($countryEdit->country_key) ? $countryEdit->country_key : ''), ['required','maxlength'=>'5','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('country_key') !!}</span>
    </div>
    </div>


    <!-- country timezone field -->
    <div class="col-sm-6 ">
            <div class="form-group {!! FormMessage::getErrorClass('corbiz_key') !!}">
          {!! Form::label('corbiz_key',  trans('admin::countries.corbiz_key') , ['class' => 'control-label']) !!}   
        {!! Form::text('corbiz_key',  old("country_key", isset($countryEdit->corbiz_key) ? $countryEdit->corbiz_key : ''), ['required','class' => 'form-control','maxlength'=>8] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('corbiz_key') !!}</span>
    </div>
    </div>

</div>
<div class="row">
    <!-- country currency_key field -->
    <div class="col-sm-6">
            <div class="form-group  {!! FormMessage::getErrorClass('currency_key') !!}">
        {!! Form::label('currency_key',  trans('admin::countries.add_currencyKey') , ['required','class' => 'control-label']) !!}
            {!! Form::text('currency_key',  old("currency_key", isset($countryEdit->currency_key) ? $countryEdit->currency_key : ''), ['required','maxlength'=>'10','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('currency_key') !!}</span>
    </div>
    </div>


    <!-- country currency_symbol field -->
<!--    <div class="form-group col-xs-6 {!! FormMessage::getErrorClass('currency_symbol') !!}">
        {!! Form::label('currency_symbol',  trans('admin::countries.add_currencySymbol') , ['required','class' => 'control-label']) !!}
        {!! Form::text('currency_symbol',  old("currency_symbol", isset($countryEdit->currency_symbol) ? $countryEdit->currency_symbol : ''), ['required','maxlength'=>'10','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('currency_symbol') !!}</span>
    </div>-->
    <div class="col-md-6">
            <div class="{!!isset($validacion)?'has-error':'' !!}}  form-group {!! FormMessage::getErrorClass('languages') !!} ">
        {!! Form::label('languages', trans('admin::countries.add_lang'), ['class' => 'control-label']) !!}
        {!! Form::select('languages[]', $langSelect, Request::input('languages'),array('required','class' => 'form-control'
            , 'multiple'=>true, 'name' => 'languages[]', 'id' => 'multiselect_language_id')) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('languages') !!}</span>
              <span class="text-danger">{{$validacion}}</span>
    </div>
</div>
</div>
<div class="row">

   
    <div class="col-md-6">
           <div class="form-group {!! FormMessage::getErrorClass('timezone') !!}">
        {!! Form::label('timezone',  trans('admin::countries.add_timezone') , ['class' => 'control-label']) !!}
        {!! Form::text('timezone',  old("country_key", isset($countryEdit->timezone) ? $countryEdit->timezone : ''), ['required','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('timezone') !!}</span>
    </div>
    </div>
    <div class="col-md-6">
<!--           <div class="form-group {!! FormMessage::getErrorClass('number_format') !!}">
        {!! Form::label('number_format',  trans('admin::countries.add_numberf') , ['required','class' => 'control-label']) !!}
        {!! Form::text('number_format',  old("number_format", isset($countryEdit->number_format) ? $countryEdit->number_format : ''), ['required','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('number_format') !!}</span>
    </div>-->
      <div class="form-group  {!! FormMessage::getErrorClass('default_locale') !!}  ">
        {!! Form::label('default_locale',  trans('admin::countries.add_locale') , ['required','class' => 'control-label']) !!}
        {!! Form::text('default_locale',  old("default_locale", isset($countryEdit->default_locale) ? $countryEdit->default_locale : ''), ['required','maxlength'=>'8','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('default_locale') !!}</span>
     
    </div>
    </div>
     
</div>
<div class="row">
        <div class="col-sm-12">
            <div class="form-group  {!! FormMessage::getErrorClass('webservice') !!}">
        {!! Form::label('webservice',  trans('admin::countries.web_service') , ['required','class' => 'control-label']) !!}
        {!! Form::url('webservice',  old("webservice"), ['required','maxlength'=>'250','class' => 'form-control'] ) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('webservice') !!}</span>
    </div>
    </div>
</div>

<div class="row">
    <!-- country number_format field -->


    <!-- country default_locale field -->
    <div class="col-md-6">
       <div class="form-group">
        <label>{{ trans('admin::countries.add_flag') }}</label>
        <div class="input-group">
            <input id="flag" class="img_src form-control" name="flag" value=''  type="text">
            <span class="input-group-btn">
                <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
            </span>
        </div>
    </div>
    </div>
    <div class="form-group col-md-6">
        <label for="shopping_active">
            <input type="checkbox" name="shopping_active" value="1" checked>{{  trans('admin::countries.add_shopping')  }}
            <span class="help-block">{!! FormMessage::getErrorMessage('shopping_active') !!}</span>
        </label>
        <label for="inscription_active">
            <input type="checkbox" name="inscription_active" value="1" checked>{{  trans('admin::countries.add_inscription')  }}
            <span class="help-block">{!! FormMessage::getErrorMessage('inscription_active') !!}</span>
        </label>
                <label for="admirable_customer">
            <input type="checkbox" name="admirable_customer" value="1" checked>{{  trans('admin::countries.add_admirable_customer')  }}
            <span class="help-block">{!! FormMessage::getErrorMessage('admirable_customer') !!}</span>
        </label>
    </div>
</div>



    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
    <p class="text-danger" style="font-style: italic;">{{ trans('admin::countries.disclaimer') }}</p>

    @foreach ($languages as $i=> $lan)
        <div role="panel-group" id="accordion-{{$lan['id'] }}">
            <div class="panel panel-default">
                <div role="tab" class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#country-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
                    </h4>
                </div>
                <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="country-language-{{$lan['id'] }}"
                     class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'}}" >
                    <div class="panel-body">
                        <h3>{!! $lan->language!!}</h3>
                        <div class="form-group">
                            <!-- language name field -->
                            <div class="form-group">
                                <label class="control-label">{{ trans('admin::countries.add_name') }}</label>
                                <input class="form-control" name="name_lang[]" value="" type="text">
                                <input  name="locale[]" type="hidden"  value="{{$lan->locale_key}}">
                                <input  type="hidden" name='language_id[]' value="{{$lan->id}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
<span class="text-danger">{!!$msg!!}</span>
</div>
<!-- submit button -->
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; {{ isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button') }}</button>

{!! Form::close() !!}

@section('scripts')

    <script type='text/javascript'>
        $(document).ready(function () {        
                load_editor_js();
            $('#multiselect_language_id').select2();
            $("#multiselect_language_id");
              var lan= $('#multiselect_language_id');
            var span=lan.siblings('span');
          span.css('width', '100%');
        });
    </script>
@endsection