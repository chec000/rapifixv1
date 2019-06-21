<div class="form-group">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-5">
            <label>{{ trans('admin::blocks.map.lat') }}:</label>
            {!! Form::text($name.'[lat]', $content->lat, ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-5">
            <label>{{ trans('admin::blocks.map.long') }}:</label>
            {!! Form::text($name.'[long]', $content->long, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
