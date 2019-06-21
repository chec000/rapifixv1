<?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <li id="navtab<?php echo $index; ?>" class="take-all-space-you-can tab_background_violet <?php echo $index<0?' pull-right':''; ?>">
        <a href="<?php echo e('#tab'.$index); ?>" data-toggle="tab" aria-expanded="true"><?php echo $name; ?></a>
    </li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
