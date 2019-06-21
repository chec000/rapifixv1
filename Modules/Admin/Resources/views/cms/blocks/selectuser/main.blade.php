<div class="form-group {{ $field_class }}">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-5">
            {!! Form::hidden($name . '[exists]', 1) !!}
            {!! Form::select($name . '[select]', $selectOptions, $submitted_data?:$content, ['style' => 'width: 100%', 'class' => 'form-control chosen-select '.$class]) !!}
        </div>
        <div class="col-sm-5">
            {!! Form::text($name . '[custom]', $customName, ['class' => 'form-control', 'placeholder' => trans('admin::blocks.selectuser.placeholder')]) !!}
        </div>
        <span class="help-block">{{ $field_message }}</span>
    </div>
</div>
