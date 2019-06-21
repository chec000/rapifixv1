<h1> {{trans('admin::shopping.orderestatus.update.updateoe')}}</h1>
<p class="text-right"><a href="{{ route('admin.orderestatus.list') }}">{{trans('admin::shopping.orderestatus.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_update_orderestatus']) !!}
<input type="hidden" value="{!!$orderestatus->id!!}" name="id_order_estatus">
<div class="row">

    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{!! trans('admin::shopping.orderestatus.add.legend_add') !!}</legend>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('key') !!}">
                {!! Form::label('key', trans('admin::shopping.orderestatus.add.key'), ['class' => 'control-label']) !!}

                {!! Form::text('key', isset($orderestatus->key_estatus) ? $orderestatus->key_estatus:'', ['required','class' => 'form-control','id'=>'key']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('key') !!}</span>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
                {!! Form::label('country_id', trans('admin::shopping.orderestatus.add.countries'), ['class' => 'control-label']) !!}
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
<h3>{{ trans('admin::shopping.orderestatus.add.oe_translates') }}</h3>
<p class="text-danger" style="font-style: italic;">{{ trans('admin::shopping.orderestatus.add.oe_disclaimer') }}</p>
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
                        <label for="language_lang" class="control-label">{{ trans('admin::shopping.orderestatus.add.name_orderestatus') }}</label>
                        <input  class="form-control" name="orderestatus_name[{{$lan->locale_key}}]" value="{{$lan->name or old('orderestatus_name.'.$lan->locale_key)}}" type="text">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="language_lang" class="control-label">{{ trans('admin::shopping.orderestatus.add.description') }}</label>
                        <input  class="form-control" name="description[{{$lan->locale_key}}]" value="{{$lan->description or old('description.'.$lan->locale_key)}}" type="text">
                        <input  class="form-control" name="orderestatus_locale[]" value="{!!$lan->locale_key !!}" type="hidden">
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

    {!!Form::submit(trans('admin::shopping.orderestatus.update.btn_update'),[ 'class'=>'btn btn-primary addButton'])!!}


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

