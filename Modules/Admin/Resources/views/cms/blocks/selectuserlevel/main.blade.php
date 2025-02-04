<div class="form-group {{ $field_class }}">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::hidden($name . '[exists]', 1) !!}
            {!! Form::select($name . '[select]', $selectOptions, $submitted_data?:$content, ['id' => $name, 'style' => 'width: 100%', 'class' => 'form-control chosen-select '.$class] + $disabled) !!}
            <span class="help-block">{{ $field_message }}</span>
            @isset($errorWebService)
                <span class="error-block"></span>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ trans('admin::blocks.selectuserlevel.error') }}</strong><br>
                    {!! $errorWebService !!}
                </div>
            @endisset
        </div>
    </div>
</div>
