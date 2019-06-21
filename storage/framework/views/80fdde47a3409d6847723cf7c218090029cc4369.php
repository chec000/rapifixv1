<h1><?php echo trans('admin::themes.labels.themes'); ?></h1>
<br/>

<h2><?php echo trans('admin::themes.labels.manage_themes'); ?></h2>

<?php echo trans('admin::themes.labels.view_all_uploaded'); ?>


<br />

<div class="form-horizontal">
    <div class="form-inline">
        <a href="<?php echo e(route('admin.themes.list')); ?>" class="btn btn-warning"><i class="fa fa-tint"></i> &nbsp; <?php echo trans('admin::themes.labels.manage_themes'); ?></a>
    </div>
</div>

<?php if(!empty($blockSettings)): ?>

    <br />

    <h2><?php echo trans('admin::themes.labels.block_setting'); ?></h2>

    <?php $__currentLoopData = $blockSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <p><a href="<?php echo e(url('support/'.$s['value'])); ?>"><?php echo trans('admin::themes.labels.'.$s['traslate']); ?></a></p>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>
