<h1>Change Password</h1>

<?php if(isset($success) && $success): ?>

    <?php if($level == 'admin'): ?>
        <p class="text-success">Password for <?php echo $user->email; ?> has been successfully updated!</p>
        <p><a href="<?php echo e(route('admin.users.edit', ['userId' => $user->id])); ?>" class="btn btn-info">Return to user details page</a></p>
    <?php elseif($level == 'user'): ?>
        <p class="text-success">Your password has been successfully updated!</p>
        <p><a href="<?php echo e(route('admin.account.index')); ?>" class="btn btn-info">Return to account settings</a></p>
    <?php else: ?>
        <p class="text-success">Your password has been successfully updated!</p>
        <p><a href="<?php echo route('admin.login'); ?>" class="btn btn-info">You can now login here</a></p>
    <?php endif; ?>

<?php else: ?>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input class="form-control" value="<?php echo $user->email; ?>" id="inputIcon" type="text" title="email" disabled/>
        </div>
    </div>

    <?php echo $form; ?>


<?php endif; ?>

