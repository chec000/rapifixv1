<a href="<?php echo e($href ?: 'javascript:void(0)'); ?>" data-theme="<?php echo e($thumb->name); ?>" data-theme-id="<?php echo e($thumb->id); ?>" class="btn btn-default <?php echo e(implode(' ', $classes)); ?>">
    <span class="glyphicon glyphicon-<?php echo e($glyphicon); ?>"></span> <?php echo e($label); ?>

</a>
