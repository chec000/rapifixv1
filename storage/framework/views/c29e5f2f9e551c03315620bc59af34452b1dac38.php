<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::menu.list_menu')); ?></h1>
    </div>
    <?php if(@can_add): ?>   
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.menuadmin.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::menu.add_menu')); ?></a>
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
    <table class="table table-striped" id="tbl_menus">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::brand.form_add.name_brand')); ?></th>
                <!--<th><?php echo e(trans('admin::form_add.lang_list_name')); ?></th>-->
                <th><?php echo e(trans('admin::menu.icon')); ?></th>
                <th><?php echo e(trans('admin::brand.form_add.status')); ?></th>
                <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::brand.form_add.actions')); ?></th>

                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="menu_<?php echo $m->id; ?>">
                <td><?php echo $m->item_name; ?></td>
                <td><?php echo $m->icon; ?></td>
                <td><span id="status<?php echo e($m->id); ?>"  class="label  <?php echo e($m->active ? 'label-success' : 'label-default'); ?> "><?php echo $m->active== 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                <?php if($can_edit || $can_delete): ?>
                <td data-lid="<?php echo $m->id; ?>">
                    <span onclick="disable_menu(<?php echo e($m->id); ?>)" id='activeBrand<?php echo e($m->id); ?>' class="<?php echo e($m->active ? '' : 'hide'); ?>">
                        <i class="glyphicon glyphicon-play itemTooltip  " title="<?php echo e(trans('admin::menu.disable_menu')); ?>"></i>
                    </span>
                    <span onclick="disable_menu(<?php echo e($m->id); ?>)" id='inactiveBrand<?php echo e($m->id); ?>' class="<?php echo e($m->active ? 'hide' : ''); ?>">                                
                        <i class="glyphicon glyphicon-stop  itemTooltip " title="<?php echo e(trans('admin::menu.enable_menu')); ?>"></i>                            
                    </span>                                
                    <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.menuadmin.update', ['id_menu' => $m->id])); ?>" title="<?php echo e(trans('admin::menu.update_menu')); ?>"></a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    function disable_menu(id) {
    $.ajax({
            url: route('admin.menuadmin.active'),
            type: 'POST',
            data: {menu_id: id},
            success: function (data) {
            let label = $("#status" + id);
            let iconActive = $("#activeBrand" + id);
            let iconInactive = $("#inactiveBrand" + id);
            if (data.status === 0) {
            iconActive.addClass('hide');
            iconInactive.removeClass('hide');
            label.removeClass('label-success').addClass('label-default');
            label.text(data.message);
            }
            else {
            iconActive.removeClass('hide');
            iconInactive.addClass('hide');
            label.removeClass('label-default').addClass('label-success');
            label.text(data.message);
            }
            }

    });
    }

    $('#tbl_menus').DataTable({
    "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }  
    });

</script>
<?php $__env->stopSection(); ?>