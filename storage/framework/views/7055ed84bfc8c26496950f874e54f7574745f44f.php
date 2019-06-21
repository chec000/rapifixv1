<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.orders.index.list_orders')); ?></h1>
    </div>


</div>


    <p id="message_activated" role="alert">

    </p>



<div class="table">

    <table class="table table-striped table-hover dt-responsive" id="tbl_order">
        <thead>
            <tr>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.countries')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.order_number')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.distributor_number')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.order_type')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.source')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.orders.index.status')); ?></th>
                <th><?php echo e(trans('admin::shopping.orders.index.payment_type')); ?></th>
                <th><?php echo e(trans('admin::shopping.orders.index.payment_trans')); ?></th>
                <th><?php echo e(trans('admin::shopping.orders.index.corbiz_order_number')); ?></th>
                <th><?php echo e(trans('admin::shopping.orders.index.date_created')); ?></th>

                <?php if($can_edit || $can_delete): ?>
                    <th><?php echo e(trans('admin::shopping.orders.index.actions')); ?></th>
                <?php endif; ?>
            </tr>


        </thead>
        <tbody>


        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $or): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="lang_<?php echo $or->id; ?>">
                <td><?php echo $or->country->name; ?></td>
                <td><?php echo $or->order_number; ?></td>
                <td><?php echo $or->distributor_number; ?></td>
                <td><?php echo $or->shop_type; ?></td>
                <td><?php echo $or->source->source_name; ?></td>
                <td><?php echo $or->estatus->name; ?></td>
                <td><?php echo $or->bank->name; ?></td>
                <td><?php echo $or->bank_authorization; ?></td>
                <td><?php echo $or->corbiz_order_number; ?></td>
                <td><?php echo $or->created_at; ?></td>


                <?php if($can_edit): ?>

                    <td data-lid="<?php echo $or->id; ?>">
                        <a class="glyphicon glyphicon-eye-open itemTooltip" href="<?php echo e(route('admin.orders.detail', ['oe_id' => $or->id])); ?>" title="<?php echo e(trans('admin::shopping.orders.index.detail')); ?>"></a>
                        <?php if($or->estatus->key_estatus == 'CORBIZ_ERROR' && in_array($or->source->source_name,Config::get('admin.sources'))): ?>
                            <span onclick="changeOrderStatus(<?php echo e($or->id); ?>)" id='activeOrderEstatus<?php echo e($or->id); ?>'>
                            <i class="glyphicon glyphicon-check itemTooltip" style="color:green;" title="<?php echo e(trans('admin::shopping.orders.index.activate')); ?>"></i>
                        </span>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <tfoot>
        <tr>
            <th><?php echo e(trans('admin::shopping.orders.index.country')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.order_number')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.payment_type')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.order_type')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.source')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.status')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.payment_type')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.payment_trans')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.corbiz_order_number')); ?></th>
            <th><?php echo e(trans('admin::shopping.orders.index.date_created')); ?></th>

            <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::shopping.orders.index.actions')); ?></th>
            <?php endif; ?>


        </tr>
        </tfoot>

    </table>


</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    /* $('#tbl_order').DataTable({
    "responsive": true,
     "ordering": true

    }); */

    var translations  = {
            0:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.0")); ?>',
            1:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.1")); ?>',
            2:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.2")); ?>',
            3:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.3")); ?>',
            4:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.4")); ?>',
            5:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.5")); ?>',
            6:           '<?php echo e(trans("admin::shopping.orders.detail.chooseoption.6")); ?>',
    }


    $(document).ready(function() {

        $('#tbl_order').DataTable( {
            "responsive": true,
            "ordering" : true,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }





                initComplete: function () {
                this.api().columns('.select-filter').every( function (index) {
                    var pos  = index;
                    var column = this;

                    console.log(translations[0]);
                    var select = $('<select><option value="">'+translations[pos]+'</option></select>')
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
    } );


    function changeOrderStatus(order_id) {
        $.ajax({
            url: route('admin.orders.active'),
            type: 'POST',
            data: {order_id: order_id},
            success: function (data) {

                if(data.status){
                    $("#message_activated").addClass('alert alert-success');
                    $("#message_activated").html(data.message);
                    setTimeout(function(){ location.reload(); }, 1000);
                }else{
                    $("#message_activated").addClass('alert alert-danger');
                    $("#message_activated").html(data.message);
                }

            }
        });
    }



</script>
<?php $__env->stopSection(); ?>