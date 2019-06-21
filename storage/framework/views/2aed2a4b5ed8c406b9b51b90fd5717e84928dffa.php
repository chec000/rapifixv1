<?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="tab-pane" id="tab<?php echo $index; ?>">

        <br/><br/>

        <?php echo $content; ?>


        <?php if($index >= 0 && ((!empty($page) && !$page->link) || $can_publish)): ?>

            <?php if($new_page): ?>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp;  <?php echo trans('admin::pages.add_page'); ?></button>
                    </div>
                </div>
            <?php elseif(!$publishing): ?>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" name="publish" value="publish" type="submit"><i class="fa fa-floppy-o"></i> <?php echo trans('admin::siteWideContent.buttons.update_page'); ?></button>
                    </div>
                </div>
            <?php elseif($publishing): ?>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp;<?php echo trans('admin::siteWideContent.buttons.save_version'); ?></button>
                        &nbsp;
                        <?php if($can_publish): ?>
                            <button class="btn btn-primary" name="publish" type="submit" value="publish"><i class="fa fa-floppy-o"></i>
                                &nbsp; <?php echo e($page->is_live() ? trans('admin::siteWideContent.buttons.save_version_publish') :trans('admin::siteWideContent.buttons.save_version_ready_go')); ?></button>
                        <?php else: ?>
                            <button class="btn btn-primary request_publish"><i class="fa fa-paper-plane"></i> &nbsp;
                                <?php echo trans('admin::siteWideContent.buttons.save_request_publish'); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>