<div class="row installThumbs">
    <?php $__currentLoopData = $thumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-6 col-md-3" id="theme<?php echo e($thumb->name); ?>">
            <div class="thumbnail<?php echo e($thumb->active?' activeTheme':''); ?>">
                <?php if($auth['manage']): ?>
                    <i class="glyphicon glyphicon-remove deleteTheme activeSwitch <?php echo e(($thumb->active)?' hidden':''); ?>" data-theme="<?php echo e($thumb->name); ?>" title="Delete"></i>
                <?php endif; ?>
                <div class="img-container">
                    <img src="<?php echo e($thumb->image); ?>" class="img-responsive" alt="<?php echo e($thumb->name); ?>">
                </div>
                <div class="caption">
                    <p>
                        <span class="label label-success <?php echo e(!$thumb->active?' hidden':''); ?> activeSwitch"><?php echo trans('admin::themes.labels.active'); ?></span>
                        <?php if(!$thumb->install): ?><span class="label label-default"><?php echo trans('admin::themes.labels.installed'); ?></span>
                        <?php else: ?><span class="label label-danger"><?php echo trans('admin::themes.labels.no_installed'); ?></span><?php endif; ?>
                    </p>
                    <h3><?php echo e($thumb->name); ?></h3>
                    <p>
                        <?php $__currentLoopData = $thumb->buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $button; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
