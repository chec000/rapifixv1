<?php $source_field_id = str_replace(['[', ']'], ['_', ''], $name . '[source]'); ?>
<?php $image_preview_id = str_replace(['[', ']'], ['_', ''], $name . '[image]'); ?>

<div class="form-group">
    <div class="row">

        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}

        <div class="col-sm-10">
            <div class="input-group">
                {!! Form::text($name.'[source]', $content, ['id' => $source_field_id, 'class' => 'img_src form-control']) !!}
                <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=2&field_id='.$source_field_id) !!}"
                       class="btn btn-default iframe-btn">{{ trans('admin::blocks.videouploaded.button') }}</a>
                </span>
            </div>
            <br>
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ trans('admin::blocks.videouploaded.info') }}
            </div>
        </div>
    </div>
</div>
