<?php if(session('msg')): ?>
    <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
<?php elseif(session('errors') != null): ?>
    <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
<?php endif; ?>
<div class="row textbox">
    <div class="col-sm-6">
        <h1> <?php echo e(trans('admin::shopping.promoprods.index.title')); ?> </h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if(Auth::action('confirmationbanners.create')): ?>
            <a href="<?php echo e(route('admin.promoprods.create')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 <?php echo e(trans('admin::shopping.promoprods.index.form-add-button')); ?> 
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_confirmations">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.promoprods.index.thead-promoname')); ?></th>
                <th><?php echo e(trans('admin::shopping.promoprods.index.thead-productsrelated')); ?></th>
                <th><?php echo e(trans('admin::shopping.promoprods.index.thead-promoprods-active')); ?></th>
                <?php if(Auth::action('confirmationbanners.edit') || Auth::action('confirmationbanners.delete')): ?>
                    <th class="text-center"><?php echo e(trans('admin::shopping.promoprods.index.thead-promoprods-actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="prom_<?php echo $pro->id; ?>">
                <td>
                    <?php echo e($pro->clv_promo); ?>

                </td>
                <td>
                    <ul>
                        <?php $__currentLoopData = $pro->promoprods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li>
                                 <?php echo e($pp->clv_producto); ?>

                                </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>


                   
                </td>
                <td>
                    <?php if($pro->active == 1): ?>
                        <span class="label label-success"><?php echo app('translator')->getFromJson('admin::shopping.promoprods.index.promoprodactive'); ?></span>
                    <?php else: ?>
                        <span class="label label-warning"><?php echo app('translator')->getFromJson('admin::shopping.promoprods.index.promoprodinactive'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <?php if($pro->active == 1): ?>
                                <?php if(Auth::action('confirmationbanners.changeStatus')): ?>
                                    <form name="formOff_<?php echo e($pro->id); ?>" method="POST" action="<?php echo e(route('admin.promoprods.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="new-status" value="deactivate"/>
                                        <input type="hidden" name="id" value="<?php echo e($pro->id); ?>"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_<?php echo e($pro->id); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.promoprods.index.disable')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(Auth::action('confirmationbanners.changeStatus')): ?>
                                    <form name="formOn_<?php echo e($pro->id); ?>" method="POST" action="<?php echo e(route('admin.promoprods.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="new-status" value="activate"/>
                                        <input type="hidden" name="id" value="<?php echo e($pro->id); ?>"/>

                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_<?php echo e($pro->id); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.promoprods.index.enable')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?php if(Auth::action('confirmationbanners.edit')): ?>
                                <a class="fa fa-pencil itemTooltip" href="<?php echo e(route('admin.promoprods.edit',['id' => $pro->id]
)); ?>"
                               title="<?php echo e(trans('admin::shopping.promoprods.index.edit')); ?>" style="color: black"></a>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?php if(Auth::action('confirmationbanners.delete')): ?>
                                <form name="formDel_<?php echo e($pro->id); ?>" method="POST" action="<?php echo e(route('admin.promoprods.destroy', ['id' => $pro->id])); ?>">
                                    <input type="hidden" name="type" value="deactivate"/>
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>

                                    <input type="hidden" name="id" value="<?php echo e($pro->id); ?>"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="document.forms['formDel_<?php echo e($pro->id); ?>'].submit();"
                                       title="<?php echo e(trans('admin::shopping.promoprods.index.delete')); ?>"></i>
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
        $('#tb_confirmations').DataTable({
            "responsive": true,
            "ordering": false
        });


    </script>
<?php $__env->stopSection(); ?>