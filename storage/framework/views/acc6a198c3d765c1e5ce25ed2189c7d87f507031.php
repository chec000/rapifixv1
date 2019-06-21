<?php echo Form::open(); ?>


<?php if($current_password): ?>
        <!-- current password field -->
<div class="form-group <?php echo FormMessage::getErrorClass('current_password'); ?>">
    <?php echo Form::label('current_password', trans('admin::userTranslations.form_edit.current_pass'), ['class' => 'control-label']); ?>

    <?php echo Form::password('current_password', ['class' => 'form-control']); ?>

    <span class="help-block"><?php echo FormMessage::getErrorMessage('current_password'); ?></span>
</div>
<?php endif; ?>

        <!-- password field -->
<div class="form-group <?php echo FormMessage::getErrorClass('new_password'); ?>">
    <?php echo Form::label('new_password', trans('admin::userTranslations.form_edit.new_pass'), ['class' => 'control-label']); ?>

    <?php echo Form::password('new_password', ['class' => 'form-control']); ?>

    <span class="help-block"><?php echo FormMessage::getErrorMessage('new_password'); ?></span>
</div>

<!-- confirm password field -->
<div class="form-group ">
    <?php echo Form::label('new_password_confirmation', trans('admin::userTranslations.form_edit.confirm_int_password'), ['class' => 'control-label']); ?>

    <?php echo Form::password('new_password_confirmation', ['class' => 'form-control']); ?>

</div>

<?php if(isset($userId)): ?>
  <a href="<?php echo e(route('admin.users.edit', ['userId' => $userId])); ?>" class="btn btn-warning"><i class="fa fa-lock"></i> Back</a>
<?php endif; ?>

<?php if($can_change_pass): ?>
<!-- submit button -->
<?php echo Form::submit( trans('admin::userTranslations.form_edit.update_pass') , ['class' => 'btn btn-primary']); ?>

<?php endif; ?>

<?php echo Form::close(); ?>

