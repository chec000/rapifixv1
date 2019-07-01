<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.customer.index.list_orders')); ?></h1>
    </div>


</div>


    <p id="message_activated" role="alert">

    </p>



<div class="table">


    <table class="table table-striped table-hover dt-responsive" id="tbl_customer">
        <thead>
            <tr>

                <th class="select-filter"><?php echo e(trans('admin::shopping.customer.index.country')); ?></th>
                <th class="select-filter"><?php echo e(trans('admin::shopping.customer.index.sponsor')); ?></th>
                <th ><?php echo e(trans('admin::shopping.customer.index.sponsor_name')); ?></th>
                <th ><?php echo e(trans('admin::shopping.customer.index.customer_code')); ?></th>
                <th><?php echo e(trans('admin::shopping.customer.index.name')); ?></th>
                <th><?php echo e(trans('admin::shopping.customer.index.status')); ?></th>
                <th><?php echo e(trans('admin::shopping.customer.index.date_created')); ?></th>
                <th><?php echo e(trans('admin::shopping.customer.index.actions')); ?></th>

            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="lang_<?php echo $cm->id; ?>">

                <td><?php echo $cm->country->name; ?></td>
                <td><?php echo $cm->sponsor; ?></td>
                <td><?php echo $cm->sponsor_name; ?></td>
                <td><?php echo $cm->ca_number; ?></td>
                <td><?php echo $cm->ca_name; ?><?php echo e($cm->ca_lastname); ?></td>
                <td><?php echo $cm->status; ?></td>
                <td><?php echo $cm->created_at; ?></td>
                <td><a class="glyphicon glyphicon-eye-open itemTooltip" href="<?php echo e(route('admin.customers.detail', ['cm_id' => $cm->id])); ?>" title="<?php echo e(trans('admin::shopping.orders.index.detail')); ?>"></a></td>



            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
        <tfoot>
        <tr>

            <th class="select-filter"><?php echo e(trans('admin::shopping.customer.index.country')); ?></th>
            <th class="select-filter"><?php echo e(trans('admin::shopping.customer.index.sponsor')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.sponsor_name')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.customer_code')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.name')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.status')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.date_created')); ?></th>
            <th><?php echo e(trans('admin::shopping.customer.index.actions')); ?></th>
        </tr>

        </tfoot>


    </table>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
        $('#tbl_customer').DataTable( {
            "responsive": true,
            "ordering" : true,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }, 
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



    var translations  = {
        0:           '<?php echo e(trans("admin::shopping.customer.detail.chooseoption.0")); ?>',
        1:           '<?php echo e(trans("admin::shopping.customer.detail.chooseoption.1")); ?>',
        2:           '<?php echo e(trans("admin::shopping.customer.detail.chooseoption.2")); ?>',
        3:           '<?php echo e(trans("admin::shopping.customer.detail.chooseoption.3")); ?>',
    }


    $(document).ready(function() {

    } );


    function changeOrderStatus(order_id) {
        $.ajax({
            url: route('admin.customer.active'),
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