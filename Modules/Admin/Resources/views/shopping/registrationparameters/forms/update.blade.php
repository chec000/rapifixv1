<h1> {{trans('admin::shopping.registrationparameters.update.updateoe')}}</h1>
<p class="text-right"><a href="{{ route('admin.registrationparameters.list') }}">{{trans('admin::shopping.registrationparameters.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_update_registrationparameters']) !!}
<input type="hidden" value="{!!$registrationparameters->id!!}" name="id_registration_parameters">
<div class="row">

    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{!! trans('admin::shopping.registrationparameters.add.legend_add') !!}</legend>


        <div class="col-md-6">
            <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
                {!! Form::label('country_id', trans('admin::shopping.registrationparameters.add.country'), ['class' => 'control-label']) !!}
                <select class="form-control" name="country_id">
                    <option>{{trans('admin::shopping.registrationparameters.add.option')}}</option>
                    @foreach ($countries as $key=>$value)
                        <option value="{{ $key }}"{{ ( $registrationparameters->country_id == $key ) ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
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

                {{ Form::radio('has_documents', 1 ,$registrationparameters->has_documents==1 ? 'checked':'', ['required','id'=>'has_documents']) }}
                {!! Form::label('has_documents', trans('admin::shopping.registrationparameters.add.has_documents_yes'), ['class' => 'control-label']) !!}
                {{ Form::radio('has_documents', 0 ,$registrationparameters->has_documents==0 ? 'checked':'', ['required','id'=>'has_documents']) }}
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
</div>


<div class="row">
    <div class="col-md-12">
        <p class="text-danger">{!!$validacion!!}</p>
    </div>
</div>



<div class="form-group">

    {!!Form::button(trans('admin::shopping.registrationparameters.update.btn_update'),[ 'class'=>'btn btn-primary addButton','id' => 'enviaForm'])!!}


</div>

<!--<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; Add Language</button>-->

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
                $("#form_update_registrationparameters").submit();
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

