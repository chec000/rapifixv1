<?php echo Form::open(['url' => Request::url()]); ?>

        <!-- username field -->
        
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <span style="font-size: 24px;
                 font-weight: 400;
                         line-height: 1.3333;">   <?php echo e(trans('admin::pages.login')); ?></span>
                </div>
            </div>
            
        </div>
        
        
<div class="form-group <?php echo FormMessage::getErrorClass('username'); ?>">
    <?php echo Form::label('username', trans('admin::pages.username'), ['class' => 'control-label']); ?>

    <?php echo Form::text('username', Request::input('username'), ['class' => 'form-control']); ?>

    <span class="help-block"><?php echo FormMessage::getErrorMessage('username'); ?></span>
</div>

<!-- password field -->
<div class="form-group <?php echo FormMessage::getErrorClass('password'); ?>">
    <?php echo Form::label('password', trans('admin::pages.password'), ['class' => 'control-label']); ?>

    <?php echo Form::password('password', ['class' => 'form-control']); ?>

</div>

<!-- remember field -->
<div class="form-group">
    <div class="checkbox remember-me">
        <label>
            <?php echo Form::checkbox('remember', 'yes', false); ?>

                <?php echo e(trans('admin::pages.login_remember')); ?>

        </label>
    </div>
</div>

<?php echo Form::hidden('login_path', Request::input('login_path')); ?>


        <!-- submit button -->
<p><?php echo Form::submit(trans('admin::pages.login'), ['class' => 'btn btn-primary']); ?></p>

<?php echo Form::close(); ?>


<div class="row">
    <div class="col-sm-12 forgot-pw">
        <a href="<?php echo route('admin.login.password.forgotten'); ?>">  <?php echo e(trans('admin::pages.forgot_password')); ?></a>
    </div>
</div>
