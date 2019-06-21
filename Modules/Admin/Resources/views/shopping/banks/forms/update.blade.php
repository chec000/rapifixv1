<h1> {{trans('admin::shopping.banks.update.updateoe')}}</h1>
<p class="text-right"><a href="{{ route('admin.banks.list') }}">{{trans('admin::shopping.banks.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_update_banks']) !!}
<input type="hidden" value="{!!$banks->id!!}" name="id_bank">
<div class="row">

    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{!! trans('admin::shopping.banks.add.legend_add') !!}</legend>


        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('bank_key') !!}">
                {!! Form::label('bank_key', trans('admin::shopping.banks.add.bank_key'), ['class' => 'control-label']) !!}

                {!! Form::text('bank_key', isset($banks->bank_key)? $banks->bank_key:'', ['required','class' => 'form-control','id'=>'bank_key']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('bank_key') !!}</span>
            </div>

        </div>

        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('url') !!}">
                {!! Form::label('url', trans('admin::shopping.banks.add.url'), ['class' => 'control-label']) !!}

                {!! Form::text('url', isset($banks->url)? $banks->url:'', ['required','class' => 'form-control','id'=>'url']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('url') !!}</span>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group {!! FormMessage::getErrorClass('flag') !!}">
                <label class="control-label">{{ trans('admin::shopping.banks.add.image') }}</label>
                <div class="input-group">
                    <input id="logo" class="img_src form-control" name="logo" value="{{$banks->logo}}" type="text">
                    <span class="input-group-btn">
                        <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=logo') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                    </span>
                </div>
                <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
                {!! Form::label('country_id', trans('admin::shopping.banks.add.countries'), ['class' => 'control-label']) !!}
                {!! Form::select('country_id[]', $countries, $countriesSelected,array('required','class' => 'form-control'
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
</div>


<div class="row">
    <div class="col-md-12">
        <p class="text-danger">{!!$validacion!!}</p>
    </div>
</div>

@if(isset($update))
<h3>{{ trans('admin::shopping.banks.add.translates') }}</h3>
<p class="text-danger" style="font-style: italic;">{{ trans('admin::shopping.banks.add.disclaimer') }}</p>
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
                <h3>{!! $lan->language!!}</h3>
                <div class="row">
                    <!-- language name field -->
                    <div class="form-group col-sm-6">
                        <label for="language_lang" class="control-label">{{ trans('admin::shopping.banks.add.name') }}</label>
                        <input  class="form-control" name="banks_name[{{$lan->locale_key}}]" value="{{$lan->name or old('banks_name.'.$lan->locale_key)}}" type="text">
                        <input  class="form-control" name="banks_locale[]" value="{!!$lan->locale_key !!}" type="hidden">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="language_lang" class="control-label">{{ trans('admin::shopping.banks.add.description') }}</label>
                        <textarea  class="form-control" name="banks_description[{{$lan->locale_key}}]">{{$lan->description or old('banks_description.'.$lan->locale_key)}}</textarea>

                    </div>


                </div>




                 <div class="row">
                    <div class="form-group col-md-6 {!! FormMessage::getErrorClass('flag') !!}">

                         <span class="help-block">{!! FormMessage::getErrorMessage('flag') !!}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endforeach
<span class="text-danger">{!!$msg!!}</span>
@endif

<div class="form-group">

    {!!Form::submit(trans('admin::shopping.banks.update.btn_update'),[ 'class'=>'btn btn-primary addButton'])!!}


</div>

<!--<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; Add Language</button>-->

{!! Form::close() !!}
@section('scripts')
<script type="text/javascript">



    function displayAction() {
        $("#div_action").css("display", "block");

    }

    function hideAction() {
        $("#div_action").css("display", "none");
        $("#no_selected_action").prop("selected", true);
    }





    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_country_id').select2();
        $('#multiselect_domain').select2();


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

