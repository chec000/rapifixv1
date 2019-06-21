<style>.required{color:red;font-weight:bold;}.message-label{margin-bottom: 2px;}.message-label span {height: 60px;}</style>
<div id="csv-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo e(trans('admin::shopping.products.updateproduct.label.load_csv')); ?></h4>
            </div>

            <div class="modal-body">
                <form id="csv_form" method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group">
                        <label class="control-label"><?php echo e(trans('admin::cedis.add.select_country')); ?></label><span class="required">*</span>
                        <select id="country" name="country" class="form-control input-sm" required="required">
                            <option></option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e(old('country') == $country->id ? 'selected' : ''); ?> value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="file" id="file_csv" name="file_csv">
                        <p class="help-block"><?php echo e(trans('admin::distributorsPool.csv.file_ext')); ?></p>
                    </div>

                    <div class="form-group">
                        <p class="help-block"><?php echo e(trans('admin::distributorsPool.csv.instructions')); ?></p>
                        <ol>
                            <li><?php echo e(trans('admin::shopping.products.updateproduct.label.inst_01')); ?>:
                                <a href="<?php echo e(asset('files/productos.csv')); ?>"><?php echo e(trans('admin::shopping.products.updateproduct.label.file_demo')); ?></a>
                            </li>
                            <li><?php echo e(trans('admin::shopping.products.updateproduct.label.inst_02')); ?></li>
                            <li><?php echo e(trans('admin::shopping.products.updateproduct.label.inst_03')); ?></li>
                        </ol>
                    </div>
                </form>

                <div id="modal-messages"></div>
            </div>

            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(trans('admin::distributorsPool.general.close')); ?></button>
                <button id="upload-file" type="button" class="btn btn-primary"><?php echo e(trans('admin::distributorsPool.csv.upload')); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->