<?php
$input_id = str_replace(['[', ']'], ['_', ''], $name);
?>

<div class="form-group {{ $field_class }}">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::hidden($name . '[exists]', 1) !!}
            {!! Form::select($name . '[select]', $placeHolder, $content, ['class' => 'form-control video-search', 'id' => $input_id, 'style' => 'width:100%;']) !!}
            <a href="#" onclick="$('#{!! $input_id !!}').select2('val', ''); $('#{!! $input_id !!}_preview').css('display', 'none'); return false;">
                {{ trans('admin::blocks.video.clear') }}
            </a>
            <div style="padding-top: 10px;">
                <iframe id="{!! $input_id !!}_preview" class="pull-left yt-video"
                        src="{!! $videoInfo?'//www.youtube.com/embed/'.$content:'' !!}" width="300" height="200"
                        style="padding-right:15px;border:0;{!! empty($placeHolder)?'display:none':'' !!}"></iframe>
                <p class="pull-left">{{ trans('admin::blocks.video.results') }}</p>
            </div>
            <span class="help-block">{{ $field_message }}</span>
        </div>
    </div>
</div>
