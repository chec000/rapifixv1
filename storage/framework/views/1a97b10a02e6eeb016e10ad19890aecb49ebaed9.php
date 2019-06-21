<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.orderestatus.index.list_estatus')); ?></h1>
    </div>
    <?php if($can_add): ?>
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.orderestatus.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::shopping.orderestatus.index.add_new_orderestatus')); ?></a>
    </div>
    <?php endif; ?>

</div>
<?php if(Session::has('info')): ?>

    <p class="alert <?php echo e(Session::get('info')['alertclass']); ?>" role="alert">
        <?php echo e(Session::get('info')['message']); ?>

    </p>

<?php endif; ?>
<div class="table">


    <table class="table table-striped" id="tbl_orderestatus">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.orderestatus.index.key_estatus')); ?></th>
                <th><?php echo e(trans('admin::shopping.orderestatus.index.countries')); ?></th>
                <th><?php echo e(trans('admin::shopping.orderestatus.index.status')); ?></th>
                <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::shopping.orderestatus.index.actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $orderestatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="lang_<?php echo $oe->id; ?>">
                <td><?php echo $oe->key_estatus; ?></td>



                <td><?php $__currentLoopData = $oe->orderEstatusCountry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="label label-default" style="margin-right: .25em;"><?php echo $ocountry->country->name; ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                <td><span id="status<?php echo e($oe->id); ?>"  class="label  <?php echo e($oe->active ? 'label-success' : 'label-default'); ?> "><?php echo $oe->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                <?php if($can_edit || $can_delete): ?>
                    <td data-lid="<?php echo $oe->id; ?>">
                    <span onclick="disableOrderEstatus(<?php echo e($oe->id); ?>)" id='activeOrderEstatus<?php echo e($oe->id); ?>' class="<?php echo e($oe->active ? 'hide' : ''); ?>">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="<?php echo e(trans('admin::shopping.orderestatus.index.enable')); ?>"></i>
                    </span>
                    <span onclick="disableOrderEstatus(<?php echo e($oe->id); ?>)" id='inactiveOrderEstatus<?php echo e($oe->id); ?>' class="<?php echo e($oe->active ? '' : 'hide'); ?>">
                        <i class="glyphicon glyphicon-play itemTooltip " title="<?php echo e(trans('admin::shopping.orderestatus.index.disable')); ?>"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.orderestatus.editOe', ['oe_id' => $oe->id])); ?>" title="<?php echo e(trans('admin::language.lang_list_edit')); ?>"></a>
                     <span onclick="deleteOrderEstatus(<?php echo e($oe->id); ?>)" id='deleteOrderEstatus<?php echo e($oe->id); ?>'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="<?php echo e(trans('admin::shopping.orderestatus.index.delete')); ?>"></i>
                     </span>
                     <span onclick="getCountries(<?php echo e($oe->id); ?>)">
                        <i class="glyphicon glyphicon-globe itemTooltip " title="<?php echo e(trans('admin::shopping.banks.index.countries')); ?>"></i>
                     </span>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" role="dialog" id="countriesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.orderestatus.updatecountries')); ?>" id="countriesSelection" method="post">

                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


                <div class="modal-header">

                    <p><?php echo e(trans('admin::shopping.banks.index.instructions')); ?></p>
                </div>
                <div class="modal-body" id="bodyCountries">





                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal" ><?php echo e(trans('admin::shopping.registrationreferences.index.close')); ?></button>
                    <button type="submit" class="btn btn-primary" id="saveCountries"><?php echo e(trans('admin::shopping.registrationreferences.index.save')); ?></button>

                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    $('#tbl_orderestatus').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }
    });
    function disableOrderEstatus(order_estatus_id) {
        $.ajax({
            url: route('admin.orderestatus.active'),
            type: 'POST',
            data: {order_estatus_id: order_estatus_id},
            success: function (data) {
                var label = $("#status" + order_estatus_id);
                var iconActive = $("#activeOrderEstatus" + order_estatus_id);
                var iconInactive = $("#inactiveOrderEstatus" + order_estatus_id);
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

    function deleteOrderEstatus(order_estatus_id) {
        $.ajax({
            url: route('admin.orderestatus.delete'),
            type: 'POST',
            data: {order_estatus_id: order_estatus_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

    function getCountries(oe_id) {


        $.ajax({
            url: route('admin.orderestatus.countries'),
            type: 'POST',
            data: {oe_id: oe_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function (i, item) {
                        console.log(i, item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name[' + i + ']" type="checkbox" value="' + parseInt(item.estatus) + '" ' + check + '>' + item.name + '</label></div>');

                    });

                    $("#bodyCountries").append('<input name="reference_identifier" type="hidden" value="' + oe_id + '">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });
    }

</script>
<?php $__env->stopSection(); ?>