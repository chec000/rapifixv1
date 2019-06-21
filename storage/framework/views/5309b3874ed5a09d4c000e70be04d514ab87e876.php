<div class="form-group <?php echo e($field_class); ?>">
    <div class="row">
        <?php echo Form::label($name, $label, ['class' => 'control-label col-sm-2']); ?>

        <div class="col-sm-10">
            <?php echo Form::hidden($name . '[exists]', 1); ?>

            <?php echo Form::select($name . '[select]', $selectOptions, $submitted_data?:$content, ['id' => $name, 'style' => 'width: 100%', 'class' => 'form-control chosen-select '.$class] + $disabled); ?>

            <span class="help-block"><?php echo e($field_message); ?></span>
        </div>
    </div>
</div>
