<style>
    .form-check-input { margin-left: 20px !important; }
</style>
<div id="brand-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo e($title); ?></h4>
            </div>

            <div class="modal-body">
                <form id="categories" method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-brands'); ?></label>
                                <?php $__currentLoopData = $userBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="radio">
                                        <label>
                                            <?php if(old('brand-user') != null): ?>
                                                <input data-name="<?php echo e($brand['name']); ?>" type="radio" name="brand-user" id="optionsRadios1" value="<?php echo e($brand['id']); ?>"
                                                        <?php echo e(old('brand-user') == $brand['id'] ? ' checked' : ''); ?> >
                                            <?php else: ?>
                                                <input data-name="<?php echo e($brand['name']); ?>" type="radio" name="brand-user" id="optionsRadios2" value="<?php echo e($brand['id']); ?>">
                                            <?php endif; ?>
                                            <?php echo e($brand['name']); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="col-sm-6">
                                <div id="products-check-countries">
                                    <label><?php echo e(trans('admin::shopping.orderestatus.index.countries')); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-cancell-button'); ?></button>
                <button id="accept-modal" type="button" class="btn btn-primary"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-next-button'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->