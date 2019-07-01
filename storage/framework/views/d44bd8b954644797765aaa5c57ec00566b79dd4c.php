<?php if(session('msg')): ?>
    <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
<?php elseif(session('errors') != null): ?>
    <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
<?php endif; ?>
<div class="row textbox">
    <div class="col-sm-6">
        <h1> <?php echo e(trans('admin::shopping.categories.index.title')); ?> </h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if(Auth::action('categories.create')): ?>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 <?php echo e(trans('admin::shopping.categories.index.form-add-button')); ?> 
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.categories.index.thead-category-name-global')); ?></th>
                <th><?php echo e(trans('admin::shopping.categories.index.thead-category-countries')); ?></th>
                <th><?php echo e(trans('admin::shopping.categories.index.thead-category-brand')); ?></th>
                <th><?php echo e(trans('admin::shopping.categories.index.thead-category-active')); ?></th>
                <?php if(Auth::action('categories.edit') || Auth::action('categories.delete')): ?>
                    <th class="text-center"><?php echo e(trans('admin::shopping.categories.index.thead-category-actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="cat_<?php echo $cat->id; ?>">
                <td><?php echo e($cat->code); ?> - <?php echo e($cat->global_name); ?></td>
                <td>
                    <?php $__currentLoopData = $cat->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default"><?php echo e($country->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td><?php echo e($cat->brandGroup->brand->name); ?></td>
                <td>
                    <?php if($cat->actives == 1): ?>
                        <span class="label label-success"><?php echo app('translator')->getFromJson('admin::shopping.categories.index.category_active'); ?></span>
                    <?php else: ?>
                        <span class="label label-warning"><?php echo app('translator')->getFromJson('admin::shopping.categories.index.category_inactive'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <?php if($cat->actives == 1): ?>
                                <?php if(Auth::action('categories.changeStatus')): ?>
                                    <form name="formOff_<?php echo e($cat->code); ?>" method="POST" action="<?php echo e(route('admin.categories.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($cat->code); ?>"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_<?php echo e($cat->code); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.categories.index.disable_category')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(Auth::action('categories.changeStatus')): ?>
                                    <form name="formOn_<?php echo e($cat->code); ?>" method="POST" action="<?php echo e(route('admin.categories.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($cat->code); ?>"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_<?php echo e($cat->code); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.categories.index.enable_category')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a class="fa fa-pencil itemTooltip" href="<?php echo e(route('admin.categories.edit', ['id' => $cat->code])); ?>"
                               title="<?php echo e(trans('admin::shopping.categories.index.edit_category')); ?>" style="color: black"></a>

                        <?php if(Auth::action('categories.edit')): ?>

                            <?php endif; ?>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?php if(Auth::action('categories.delete')): ?>
                                <form name="formDel_<?php echo e($cat->code); ?>" method="POST" action="<?php echo e(route('admin.categories.destroy', ['code' => $cat->code])); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>

                                    <input type="hidden" name="code" value="<?php echo e($cat->code); ?>"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="deleteElement(this)" data-id="<?php echo e($cat->code); ?>" data-element="<?php echo e($cat->global_name); ?>" title="<?php echo e(trans('admin::shopping.categories.index.delete_category')); ?>"></i>
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
        $('#tb_products').DataTable({
            "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }  
        });
        function deleteElement(element) {
            var id = $(element).data('id');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('<?php echo e(trans('admin::shopping.categories.index.confirm')); ?>');
            $('#accept-confirm').text('<?php echo e(trans('admin::shopping.categories.index.confirm_yes')); ?>');
            $('#cancel-confirm').text('<?php echo e(trans('admin::shopping.categories.index.confirm_no')); ?>');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                document.forms['formDel_'+id].submit();
            });
        }
        function disable_product(active,productId) {
            var url  = '<?php echo e(route('admin.categories.changeStatus')); ?>';
            var type = 'activate';
            if (active==='0'){
                type = 'deactivate';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {id: productId, type: type},
                success: function (r) {
                    if (r.status === 0) {
                        $("#product_" + productId + " .glyphicon-play").addClass('hide');
                        $("#product_" + productId + " .glyphicon-stop").removeClass('hide');
                        $("#product_" + productId + " .cActive").hide();
                        $("#product_" + productId + " .cInactive").show();
                    }
                    else {
                        $("#product_" + productId + " .glyphicon-stop").addClass('hide');
                        $("#product_" + productId + " .glyphicon-play").removeClass('hide');
                        $("#product_" + productId + " .cActive").show();
                        $("#product_" + productId + " .cInactive").hide();
                    }
                }
            });
        }
        $(document).ready(function () {
            $('.glyphicon-play').click(function () {
                disable_product(0,$(this).parent().attr('data-cid'));
            });
            $('.glyphicon-stop').click(function () {
                disable_product(1,$(this).parent().attr('data-cid'));
            });
        });

    </script>
<?php $__env->stopSection(); ?>