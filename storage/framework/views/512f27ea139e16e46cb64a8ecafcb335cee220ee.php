<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::brand.form_add.list_brands')); ?></h1>
    </div>
    <?php if($can_add): ?>
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.brand.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::brand.form_add.add_new_brand')); ?></a>
    </div>
    <?php endif; ?>

</div>

<div class="table-responsive">
    <?php if(isset($success)): ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo e($action == 'edit' ? trans('admin::language.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang))); ?>

    </div>
    <?php endif; ?>
    <table class="table table-striped" id="tbl_brands">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::brand.form_add.name_brand')); ?></th>
                <!--<th><?php echo e(trans('admin::form_add.lang_list_name')); ?></th>-->
                <th><?php echo e(trans('admin::brand.form_add.key_brand')); ?></th>
                <th><?php echo e(trans('admin::brand.form_add.url')); ?></th>
                <th style="width: 336px"><?php echo e(trans('admin::brand.form_add.countries')); ?></th>
                <th><?php echo e(trans('admin::brand.form_add.status')); ?></th>
                <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::brand.form_add.actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($brand->delete == 0): ?>
                    <tr id="lang_<?php echo $brand->id; ?>">
                        <td><?php echo $brand->name; ?></td>
                        <td><?php echo $brand->alias; ?></td>
                        <td><?php echo $brand->domain; ?></td>
                        <td>
                            <?php $__currentLoopData = $brand->brandCountry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bcountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <span class="label label-default"><?php echo $bcountry->country->name; ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </td>
                        <td><span id="status<?php echo e($brand->id); ?>"  class="label  <?php echo e($brand->active ? 'label-success' : 'label-default'); ?> "><?php echo $brand->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                        <?php if($can_edit || $can_delete || $can_remove): ?>
                            <td data-lid="<?php echo $brand->id; ?>">
                    <span onclick="disableBrand(<?php echo e($brand->id); ?>)" id='activeBrand<?php echo e($brand->id); ?>' class="<?php echo e($brand->active ? 'hide' : ''); ?>">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="<?php echo e(trans('admin::brand.form_add.enable')); ?>"></i>
                    </span>
                                <span onclick="disableBrand(<?php echo e($brand->id); ?>)" id='inactiveBrand<?php echo e($brand->id); ?>' class="<?php echo e($brand->active ? '' : 'hide'); ?>">
                        <i class="glyphicon glyphicon-play itemTooltip " title="<?php echo e(trans('admin::brand.form_add.disable')); ?>"></i>
                    </span>
                                <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.brand.editBrand', ['bread_id' => $brand->id])); ?>" title="<?php echo e(trans('admin::language.lang_list_edit')); ?>"></a>
                                <?php if($can_remove): ?>
                                    <form id="delete-brand-form-<?php echo e($brand->id); ?>" action="<?php echo e(route('admin.brand.delete', $brand->id)); ?>", method="POST" style="display: inline">
                                        <?php echo e(csrf_field()); ?>

                                        <a onclick="deleteElement(this)" data-code="<?php echo e($brand->id); ?>" data-element="<?php echo e($brand->name); ?>" id="delete-<?php echo e($brand->id); ?>" class="glyphicon glyphicon-trash itemTooltip" href="#" title="<?php echo e(trans('admin::brand.delete_brand')); ?>"></a>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    $('#tbl_brands').DataTable({
    "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }  
    });
    function deleteElement(element) {
        var code = $(element).data('code');
        var name = $(element).data('element');

        $('#confirm-modal .modal-body').text('<?php echo e(trans('admin::shopping.products.index.confirm')); ?> ' + name + '?');

        $('#confirm-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function(e) {
            $('#delete-brand-form-'+code).submit();
        });
    }
    function disableBrand(brand_id) {
    $.ajax({
    url: route('admin.bread.activeBrand'),
            type: 'POST',
            data: {brand_id: brand_id},
            success: function (data) {
            let label = $("#status" + brand_id);
            let iconActive = $("#activeBrand" + brand_id);
            let iconInactive = $("#inactiveBrand" + brand_id);
            if (data.status === 0) {
            iconActive.removeClass('hide');
            iconInactive.addClass('hide');
            label.removeClass('label-success').addClass('label-default');
            label.text(data.message);
            }
            else {
            iconActive.addClass('hide');
            iconInactive.removeClass('hide');
            label.removeClass('label-default').addClass('label-success');
            label.text(data.message);
            }
            }
    });
    }
</script>
<?php $__env->stopSection(); ?>