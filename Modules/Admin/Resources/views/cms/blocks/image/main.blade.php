<?php $source_field_id = str_replace(['[', ']'], ['_', ''], $name . '[source]'); ?>
<?php $image_preview_id = str_replace(['[', ']'], ['_', ''], $name . '[image]'); ?>

<div class="form-group">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-3">
            <div class="thumbnail maxthumbnail">
                @if (!empty($content->file))
                    <a class="fancybox" href="{!! $content->file !!}">
                        <img id="{!! $image_preview_id !!}" alt="{!! $content->title !!}"
                             src="{{ asset($content->file) }}" width="200" height="150"/>
                    </a>
                @else
                    <img id="{!! $image_preview_id !!}" alt="{{ trans('admin::blocks.image.no_image') }}"
                         src="//placeholdit.imgix.net/~text?txtsize=19&bg=efefef&txtclr=aaaaaa%26text%3Dno%2Bimage&txt=no+image&w=200&h=150"/>
                @endif
            </div>
        </div>
        <div class="col-sm-7">
            <label>{{ trans('admin::blocks.image.source') }}:</label>
            <div class="input-group">
                {!! Form::text($name.'[source]', $content->file, ['id' => $source_field_id, 'class' => 'img_src form-control']) !!}
                <span class="input-group-btn">
                    <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id='.$source_field_id) !!}"
                       class="btn btn-default iframe-btn">{{ trans('admin::blocks.image.button') }}</a>
                </span>
            </div>
            <label style="clear:both; margin-top:20px;">{{ trans('admin::blocks.image.title') }}:</label>
            {!! Form::text($name.'[alt]', $content->title, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
