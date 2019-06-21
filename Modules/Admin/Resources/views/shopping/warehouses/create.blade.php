
<h1> {{ trans('admin::shopping.warehouses.add.label.title') }} </h1>
<p class="text-right">
    <a href="{{ route('admin.warehouses.index') }}">
        {{ trans('admin::shopping.warehouses.add.label.back_list') }}
    </a>
</p>
{!! Form::open( ['route' => 'admin.warehouses.store']) !!}
<fieldset class="fieldset_gray">
    <legend class="legend_gray">{!! trans('admin::shopping.warehouses.add.label.legend_add') !!}</legend>
    <div class="col-md-6">
        <div  class= "form-group">
            {!! Form::label('warehouse', trans('admin::shopping.warehouses.add.label.warehouse'), ['class' => 'control-label']) !!}
            {!! Form::text('warehouse', old('warehouse'), ['required', 'class' => 'form-control',
            'placeholder' => trans('admin::shopping.warehouses.add.input.warehouse'), 'id'=>'warehouse']) !!}
            <span class="help-block" style="color: red">{{ $errors->first('warehouse') }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('country_id', trans('admin::shopping.warehouses.add.label.country'), ['class' => 'control-label']) !!}
            {!! Form::select('country_id[]', $countries, Request::input('country_id'),array('class' => 'form-control'
               , 'name' => 'country_id[]', 'id' => 'multiselect_country_id')) !!}
            <span class="help-block" style="color: red">{{ $errors->first('country') }}</span>
        </div>
    </div>
</fieldset>
<div class="form-group text-center">
        <button class='btn btn-primary addButton' type="submit">
        {{trans('admin::shopping.warehouses.add.label.button-save')}}
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
</script>
@stop