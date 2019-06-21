<h1> {{trans('admin::shopping.registrationreferences.add.new_registrationreferences')}}</h1>
<p class="text-right"><a href="{{ route('admin.registrationreferences.list') }}">{{trans('admin::shopping.registrationreferences.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_add_registrationreferences']) !!}


<fieldset class="fieldset_gray">
    <legend class="legend_gray">{!! trans('admin::shopping.registrationreferences.add.legend_add') !!}</legend>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('key') !!}">
                {!! Form::label('key', trans('admin::shopping.registrationreferences.add.key'), ['class' => 'control-label']) !!}

                {!! Form::text('key', isset($registrationreferences->key)? $registrationreferences->key:'', ['required','class' => 'form-control','id'=>'key']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('key') !!}</span>
            </div>

        </div>

        <div class="col-md-6">
            <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
                {!! Form::label('country_id', trans('admin::shopping.registrationreferences.add.countries'), ['class' => 'control-label']) !!}
                {!! Form::select('country_id[]', $countries, Request::input('country_id'),array('required','class' => 'form-control'
                , 'multiple'=>true, 'name' => 'country_id[]', 'id' => 'multiselect_country_id')) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
            </div>
        </div>

        



        <div class="row">
                    <div class="col-md-12">

                        <p class="text-danger">{!!$validacion!!}</p>

                    </div>
    </div>
</fieldset>





@if(isset($add))
<h3>{{ trans('admin::shopping.registrationreferences.add.oe_translates') }}</h3>
<p class="text-danger" style="font-style: italic;">{{ trans('admin::shopping.registrationreferences.add.oe_disclaimer') }}</p>
@if($errors->any())
    <div class="alert alert-danger"><span class="text-capitalize text-danger">{{$errors->first()}}</span></div>
@endif
@foreach ($languages as $i=> $lan)
<div role="panel-group" id="accordion-{{$lan['id'] }}">
    <div class="panel panel-default">
        <div role="tab" class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#brand-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
            </h4>
        </div>
        <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="brand-language-{{$lan['id'] }}"
             class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'}}" >
                     <div class="panel-body">
                        <h3>{!! $lan->language_country!!}</h3>
                        <!-- language name field -->
                        <div class="row">
                                <div class="form-group col-sm-6">
                            <label for="language_lang" class="control-label">{{ trans('admin::shopping.registrationreferences.add.name') }}</label>
                            <input  class="form-control" name="registrationreferences_name[{{$lan->locale_key}}]" value="{{ old('registrationreferences_name.'.$lan->locale_key) }}" type="text">

                        </div>
                        <!-- language country field -->
                        <div class="form-group col-sm-6">


                            <input type="hidden" name="registrationreferences_locale[]" value="{!! $lan->locale_key!!}">

                        </div>
                        </div>
                        <div class="row">

                            <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
                        </div>
                    </div>
            

            </div>
        </div>
    </div>

@endforeach


@endif
<div class="form-group">
        <button class='btn btn-primary addButton' type="submit">
        {{trans('admin::shopping.registrationreferences.add.btn_add')}}
    </button>

</div>

{!! Form::close() !!}

@section('scripts')
<script type="text/javascript">



    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_country_id').select2();
        $('#multiselect_domain').select2();
          var country= $('#multiselect_country_id');
          var span=country.siblings('span');
          span.css('width', '100%');

    });








    $('#parent_id').on('change', function (e) {
        //  var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $.ajax({
            url: route('admin.menu.order'),
            type: 'POST',
            data: {menu_id: valueSelected},
            success: function (data) {
                if (data !== null) {
                    $('#order').val(data.order + 1);
                }
            }
        });
    });


</script>
@stop