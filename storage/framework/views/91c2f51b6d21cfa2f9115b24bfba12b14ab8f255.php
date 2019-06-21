<div class="form-group <?php echo e($field_class); ?>">
    <div class="row">
        <?php echo Form::label($name, $label, ['class' => 'control-label col-sm-2']); ?>

        <div class="col-sm-10">
            <?php echo Form::hidden($name . '[exists]', 1); ?>

            <?php echo Form::select($name . '[select]', $selectOptions, $submitted_data?:$content, ['id' => $name, 'style' => 'width: 100%', 'class' => 'form-control chosen-select '.$class] + $disabled); ?>

            <span class="help-block"><?php echo e($field_message); ?></span>
            <?php if(isset($errorWebService)): ?>
                <span class="error-block"></span>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?php echo e(trans('admin::blocks.selectuserlevel.error')); ?></strong><br>
                    <?php echo $errorWebService; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
