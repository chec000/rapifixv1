<h1> {{trans('admin::shopping.registrationparameters.add.new_registrationparameters')}}</h1>
<p class="text-right"><a href="{{ route('admin.registrationparameters.list') }}">{{trans('admin::shopping.registrationparameters.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_add_registrationparameters']) !!}


<fieldset class="fieldset_gray">
    <legend class="legend_gray">{!! trans('admin::shopping.registrationparameters.add.legend_add') !!}</legend>
    <div class="col-md-6">
        <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
            {!! Form::label('country_id', trans('admin::shopping.registrationparameters.add.country'), ['class' => 'control-label']) !!}
            {!! Form::select('country_id', $countries, Request::input('country_id'),array('required','class' => 'form-control'
            , 'name' => 'country_id', 'id' => 'multiselect_country_id')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
        </div>
    </div>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('min_age') !!}">
                {!! Form::label('min_age', trans('admin::shopping.registrationparameters.add.min_age'), ['class' => 'control-label']) !!}

                {!! Form::number('min_age', isset($registrationparameters->min_age)? $registrationparameters->min_age:'', ['required','class' => 'form-control','id'=>'min_age','min'=>1,'max'=>100]) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('min_age') !!}</span>
            </div>

        </div>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('max_age') !!}">
                {!! Form::label('max_age', trans('admin::shopping.registrationparameters.add.max_age'), ['class' => 'control-label']) !!}

                {!! Form::number('max_age', isset($registrationparameters->max_age)? $registrationparameters->max_age:'', ['required','class' => 'form-control','id'=>'max_age','min'=>1,'max'=>100]) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('max_age') !!}</span>
            </div>

        </div>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('has_documents') !!}">
                {!! Form::label('has_documents', trans('admin::shopping.registrationparameters.add.has_documents'), ['class' => 'control-label']) !!}

                {{ Form::radio('has_documents', 1 , true, ['required','id'=>'has_documents']) }}
                {!! Form::label('has_documents', trans('admin::shopping.registrationparameters.add.has_documents_yes'), ['class' => 'control-label']) !!}
                {{ Form::radio('has_documents', 0 , false, ['required','id'=>'has_documents']) }}
                {!! Form::label('has_documents', trans('admin::shopping.registrationparameters.add.has_documents_no'), ['class' => 'control-label']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('has_documents') !!}</span>
            </div>

        </div>




        




                    <div class="col-md-9 alert alert-danger" id="mensaje" style="display: none;">

                            {{trans('admin::shopping.registrationparameters.add.max_age_validation')}}


                    </div>
    <div class="col-md-9 alert alert-danger" id="mensaje2" style="display: none;">

        {{trans('admin::shopping.registrationparameters.add.hundredvalidation')}}


    </div>

</fieldset>






@if(!empty($msg))
<p class="alert alert-danger">{!!$msg!!}</p>
@endif




<div class="form-group">
        <button class='btn btn-primary addButton' type="button" id="enviaForm">
        {{trans('admin::shopping.registrationparameters.add.btn_add')}}
    </button>

</div>

{!! Form::close() !!}

@section('scripts')
<script type="text/javascript">



    $(document).ready(function () {
        load_editor_js();

        $("#enviaForm").click(function (e) {
             var min_age = $("#min_age").val();
             var max_age = $("#max_age").val();

            if(parseInt(min_age) >= parseInt(max_age) || parseInt(max_age) <= parseInt(min_age)){
                $("#mensaje").show();
                $("#mensaje2").hide();
            }else if((parseInt(min_age) < 1 || parseInt(min_age) > 100) || (parseInt(max_age) < 1 || parseInt(max_age)  > 100)){

                $("#mensaje").hide();
                $("#mensaje2").show();
            }
            else{
                $("#mensaje").hide();
                $("#mensaje2").hide();
                $("#form_add_registrationparameters").submit();
            }


        });


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