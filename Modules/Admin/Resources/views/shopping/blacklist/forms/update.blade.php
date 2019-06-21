<h1> {{trans('admin::shopping.blacklist.update.updateoe')}}</h1>
<p class="text-right"><a href="{{ route('admin.blacklist.list') }}">{{trans('admin::shopping.blacklist.add.back_list')}}</a></p>
{!! Form::open( ['id'=>'form_update_blacklist']) !!}
<input type="hidden" value="{!!$blacklist->id!!}" name="id_blacklist">
<div class="row">

    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{!! trans('admin::shopping.blacklist.add.legend_add') !!}</legend>


        <div class="col-md-6">
            <div class="form-group   {!! FormMessage::getErrorClass('country_id') !!}">
                {!! Form::label('country_id', trans('admin::shopping.blacklist.add.country'), ['class' => 'control-label']) !!}
                <select class="form-control" name="country_id">
                    <option>{{trans('admin::shopping.blacklist.add.option')}}</option>
                    @foreach ($countries as $key=>$value)
                        <option value="{{ $key }}"{{ ( $blacklist->country_id == $key ) ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                <span class="help-block">{!! FormMessage::getErrorMessage('country_id') !!}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div  class= "form-group {!! FormMessage::getErrorClass('eo_number') !!}">
                {!! Form::label('eo_number', trans('admin::shopping.blacklist.add.eo_number'), ['class' => 'control-label']) !!}

                {!! Form::text('eo_number', isset($blacklist->eo_number)? $blacklist->eo_number:'', ['required','class' => 'form-control','id'=>'eo_number']) !!}
                <span class="help-block">{!! FormMessage::getErrorMessage('eo_number') !!}</span>
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



<div class="form-group">

    {!!Form::submit(trans('admin::shopping.blacklist.update.btn_update'),[ 'class'=>'btn btn-primary addButton'])!!}


</div>

<!--<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; Add Language</button>-->

{!! Form::close() !!}
@section('scripts')
<script type="text/javascript">





    $(document).ready(function () {
        load_editor_js();



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

