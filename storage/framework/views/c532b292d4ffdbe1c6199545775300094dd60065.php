<?php
$input_id = str_replace(['[', ']'], ['_', ''], $name);
?>

<div class="form-group <?php echo e($field_class); ?>">
    <div class="row">
        <?php echo Form::label($name, $label, ['class' => 'control-label col-sm-2']); ?>

        <div class="col-sm-10">
            <?php echo Form::hidden($name . '[exists]', 1); ?>

            <?php echo Form::select($name . '[select]', $placeHolder, $content, ['class' => 'form-control video-search', 'id' => $input_id, 'style' => 'width:100%;']); ?>

            <a href="#" onclick="$('#<?php echo $input_id; ?>').select2('val', ''); $('#<?php echo $input_id; ?>_preview').css('display', 'none'); return false;">
                <?php echo e(trans('admin::blocks.video.clear')); ?>

            </a>
            <div style="padding-top: 10px;">
                <iframe id="<?php echo $input_id; ?>_preview" class="pull-left yt-video"
                        src="<?php echo $videoInfo?'//www.youtube.com/embed/'.$content:''; ?>" width="300" height="200"
                        style="padding-right:15px;border:0;<?php echo empty($placeHolder)?'display:none':''; ?>"></iframe>
                <p class="pull-left"><?php echo e(trans('admin::blocks.video.results')); ?></p>
            </div>
            <span class="help-block"><?php echo e($field_message); ?></span>
        </div>
    </div>
</div>
