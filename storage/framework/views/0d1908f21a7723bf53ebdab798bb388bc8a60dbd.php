<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.blacklist.index.list_estatus')); ?></h1>
    </div>
    <?php if($can_add): ?>
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.blacklist.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::shopping.blacklist.index.add_new_blacklist')); ?></a>
    </div>
    <?php endif; ?>

</div>
<?php if(Session::has('info')): ?>

    <p class="alert <?php echo e(Session::get('info')['alertclass']); ?>" role="alert">
        <?php echo e(Session::get('info')['message']); ?>

    </p>

<?php endif; ?>
<div class="table">


    <table class="table table-striped" id="tbl_blacklist">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.blacklist.index.country')); ?></th>
                <th><?php echo e(trans('admin::shopping.blacklist.index.eo_number')); ?></th>
               
                <th><?php echo e(trans('admin::shopping.blacklist.index.status')); ?></th>
                <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::shopping.blacklist.index.actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $blacklist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr id="lang_<?php echo $bl->id; ?>">
                <td><?php echo $bl->country->name; ?></td>
                <td><?php echo e($bl->eo_number); ?></td>
                <td><span id="status<?php echo e($bl->id); ?>"  class="label  <?php echo e($bl->active ? 'label-success' : 'label-default'); ?> "><?php echo $bl->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                <?php if($can_edit || $can_delete): ?>
                    <td data-lid="<?php echo $bl->id; ?>">
                    <span onclick="disableBlacklist(<?php echo e($bl->id); ?>)" id='activeBlacklist<?php echo e($bl->id); ?>' class="<?php echo e($bl->active ? 'hide' : ''); ?>">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="<?php echo e(trans('admin::shopping.blacklist.index.enable')); ?>"></i>
                    </span>
                    <span onclick="disableBlacklist(<?php echo e($bl->id); ?>)" id='inactiveBlacklist<?php echo e($bl->id); ?>' class="<?php echo e($bl->active ? '' : 'hide'); ?>">
                        <i class="glyphicon glyphicon-play itemTooltip " title="<?php echo e(trans('admin::shopping.blacklist.index.disable')); ?>"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.blacklist.edit', ['oe_id' => $bl->id])); ?>" title="<?php echo e(trans('admin::language.lang_list_edit')); ?>"></a>

                        <span onclick="deleteBlacklist(<?php echo e($bl->id); ?>)" id='deleteBlacklist<?php echo e($bl->id); ?>'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="<?php echo e(trans('admin::shopping.blacklist.index.delete')); ?>"></i>
                     </span>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    $('#tbl_blacklist').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }  
    });
    function disableBlacklist(blacklist_id) {
        $.ajax({
            url: route('admin.blacklist.active'),
            type: 'POST',
            data: {blacklist_id: blacklist_id},
            success: function (data) {
                var label = $("#status" + blacklist_id);
                var iconActive = $("#activeBlacklist" + blacklist_id);
                var iconInactive = $("#inactiveBlacklist" + blacklist_id);
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

    function deleteBlacklist(blacklist_id) {
        $.ajax({
            url: route('admin.blacklist.delete'),
            type: 'POST',
            data: {blacklist_id: blacklist_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

</script>
<?php $__env->stopSection(); ?>