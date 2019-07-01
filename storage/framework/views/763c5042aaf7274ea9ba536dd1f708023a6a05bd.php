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
                        <div id="products-check-countries">
                            <label><?php echo e(trans('admin::shopping.orderestatus.index.countries')); ?></label>

                            <?php $__currentLoopData = $groupsByCountry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div data-country-checkbox="<?php echo e($category->country->id); ?>" name="check-countries">
                                    <input checked class="form-check-input" id="checkCountry_<?php echo e($category->country->id); ?>" value="<?php echo e($category->country->id); ?>" type="checkbox">
                                    <label for="checkCountry_<?php echo e($category->country->id); ?>" id="label-langsCountry_<?php echo e($category->country->id); ?>" class="form-check-label"><?php echo e($category->country->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $anotherCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uC): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div data-country-checkbox="<?php echo e($uC->id); ?>" name="check-countries">
                                    <input class="form-check-input" id="checkCountry_<?php echo e($uC->id); ?>" value="<?php echo e($uC->id); ?>" type="checkbox">
                                    <label for="checkCountry_<?php echo e($uC->id); ?>" id="label-langsCountry_<?php echo e($uC->id); ?>" class="form-check-label"><?php echo e($uC->name); ?></label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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