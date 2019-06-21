<h1>Forgotten Password</h1>


<?php if(isset($success)): ?>

    <p class="success"><?php echo $success; ?></p>

    <?php else: ?>

    <?php echo Form::open(['url' => Request::url()]); ?>


    <!-- email field -->
    <div class="form-group <?php echo FormMessage::getErrorClass('email'); ?>">
        <?php echo Form::label('email', 'Email Address', ['class' => 'control-label']); ?>

        <?php echo Form::text('email', Request::input('email'), ['class' => 'form-control']); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('email'); ?></span>
    </div>

    <!-- submit button -->
    <?php echo Form::submit('Send me an email', ['class' => 'btn btn-primary', 'onclick' => 'return validate()']); ?>


    <?php echo Form::close(); ?>


<?php endif; ?>


