<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.warehouses.index.title')); ?></h1>
    </div>
    <?php if(Auth::action('warehouses.create')): ?>
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.warehouses.create')); ?>" class="btn btn-warning addButton">
            <i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::shopping.warehouses.index.form-add-button')); ?>

        </a>
    </div>
    <?php endif; ?>
    <div class="col-md-12">
        <?php if(session('msg')): ?>
            <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
        <?php elseif(session('errors') != null): ?>
            <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
        <?php endif; ?>
    </div>
</div>

<div class="table">
    <table id="warehouses" class="table table-striped">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.warehouses.index.thead-name')); ?></th>
                <th><?php echo e(trans('admin::shopping.warehouses.index.thead-country')); ?></th>
                <th class="text-center"><?php echo e(trans('admin::shopping.warehouses.index.thead-active')); ?></th>
                <th class="text-center"><?php echo e(trans('admin::shopping.warehouses.index.thead-actions')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $warehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo $w->warehouse; ?></td>
                <td>
                    <?php $__currentLoopData = $w->country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default"><?php echo e($c); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td class="text-center">
                    <?php if($w->active == 1): ?>
                        <span class="label label-success"><?php echo app('translator')->getFromJson('admin::shopping.warehouses.index.active'); ?></span>
                    <?php else: ?>
                        <span class="label label-warning"><?php echo app('translator')->getFromJson('admin::shopping.warehouses.index.inactive'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <?php if($w->active == 1): ?>
                                <?php if(Auth::action('warehouses.changeStatus')): ?>
                                    <form name="formOff_<?php echo e($w->id); ?>" method="POST" action="<?php echo e(route('admin.warehouses.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($w['warehouse']); ?>"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_<?php echo e($w->id); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.warehouses.index.disable')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(Auth::action('warehouses.changeStatus')): ?>
                                    <form name="formOn_<?php echo e($w->id); ?>" method="POST" action="<?php echo e(route('admin.warehouses.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($w->warehouse); ?>"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_<?php echo e($w->id); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.warehouses.index.enable')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?php if(Auth::action('warehouses.edit')): ?>
                                <a class="fa fa-pencil itemTooltip" href="<?php echo e(route('admin.warehouses.edit', ['id' => $w->id ])); ?>"
                                   title="<?php echo e(trans('admin::shopping.warehouses.index.edit')); ?>" style="color: black"></a>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?php if(Auth::action('warehouses.delete')): ?>
                                <form name="formDel_<?php echo e($w->id); ?>" method="POST" action="<?php echo e(route('admin.warehouses.destroy', ['code' => $w->warehouse ])); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>

                                    <input type="hidden" name="code" value="<?php echo e($w->warehouse); ?>"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" data-id="<?php echo e($w->id); ?>" data-element="<?php echo e($w->warehouse); ?>" onclick="deleteElement(this)" title="<?php echo e(trans('admin::shopping.warehouses.index.delete')); ?>"></i>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                
                
                

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
</div>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    $('#warehouses').DataTable({
    "responsive": true,
            "ordering": false, "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }
    });
    function deleteElement(element) {
        var id = $(element).data('id');
        var name = $(element).data('element');

        $('#confirm-modal .modal-body').text('<?php echo e(trans('admin::shopping.products.index.confirm')); ?> ' + name + '?');

        $('#confirm-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function(e) {
            document.forms['formDel_'+id].submit();
        });
    }
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

</script>
<?php $__env->stopSection(); ?>