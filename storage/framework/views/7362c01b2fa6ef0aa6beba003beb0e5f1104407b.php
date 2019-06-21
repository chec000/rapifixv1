<?php if(session('msg')): ?>
    <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
<?php elseif(session('errors') != null): ?>
    <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
<?php endif; ?>
<div class="row textbox">
    <div class="col-sm-6">
        <h1> <?php echo e(trans('admin::shopping.filters.index.title')); ?> </h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if(Auth::action('filters.create')): ?>
            <a href="<?php echo e(route('admin.filters.create')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 <?php echo e(trans('admin::shopping.filters.index.form-add-button')); ?>

            </a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="tb_products">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.filters.index.thead-name-global')); ?></th>
                <th><?php echo e(trans('admin::shopping.filters.index.thead-brand')); ?></th>
                <th><?php echo e(trans('admin::shopping.filters.index.thead-country')); ?></th>
                <th class="text-center"><?php echo e(trans('admin::shopping.filters.index.thead-active')); ?></th>
                <?php if(Auth::action('filters.edit') || Auth::action('filters.delete')): ?>
                    <th class="text-center"><?php echo e(trans('admin::shopping.filters.index.thead-actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="cat_<?php echo $fil->id; ?>">
                <td><?php echo e($fil->code); ?> - <?php echo e($fil->global_name); ?></td>
                <td><?php echo e($fil->brandGroup->brand->name); ?></td>
                <td>
                    <?php $__currentLoopData = $fil->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filCountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default"><?php echo e($filCountry->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td class="text-center">
                    <?php if($fil->actives == 1): ?>
                        <span class="label label-success"><?php echo app('translator')->getFromJson('admin::shopping.filters.index.category_active'); ?></span>
                    <?php else: ?>
                        <span class="label label-warning"><?php echo app('translator')->getFromJson('admin::shopping.filters.index.category_inactive'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-3 text-center">
                            <a href="<?php echo e(route('admin.filters.categoriesshow', ['code' => $fil->code, 'idCountry' => 0, 'idCategory' => 0])); ?>"
                               title="<?php echo e(trans('admin::shopping.products.index.edit_product')); ?>" style="text-decoration: none;color: #000;">
                                <i class="fa fa-random" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="col-xs-3 text-center">
                            <?php if($fil->actives == 1): ?>
                                <?php if(Auth::action('filters.changeStatus')): ?>
                                    <form name="formOff_<?php echo e($fil->code); ?>" method="POST" action="<?php echo e(route('admin.filters.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($fil->code); ?>"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_<?php echo e($fil["code"]); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.filters.index.disable_category')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if(Auth::action('filters.changeStatus')): ?>
                                    <form name="formOn_<?php echo e($fil->code); ?>" method="POST" action="<?php echo e(route('admin.filters.changeStatus')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="code" value="<?php echo e($fil->code); ?>"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_<?php echo e($fil->code); ?>'].submit();"
                                           title="<?php echo e(trans('admin::shopping.filters.index.enable_category')); ?>"></i>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-3 text-center">
                            <?php if(Auth::action('filters.edit')): ?>
                                <a class="fa fa-pencil itemTooltip" href="<?php echo e(route('admin.filters.edit', ['id' => $fil->code])); ?>"
                               title="<?php echo e(trans('admin::shopping.filters.index.edit_category')); ?>" style="color: black"></a>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-3 text-center">
                            <?php if(Auth::action('filters.delete')): ?>
                                <form name="formDel_<?php echo e($fil->code); ?>" method="POST" action="<?php echo e(route('admin.filters.destroy', ['code' => $fil->code])); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <?php echo e(method_field('DELETE')); ?>

                                    <input type="hidden" name="code" value="<?php echo e($fil->code); ?>"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" onclick="deleteElement(this)" data-id="<?php echo e($fil->code); ?>" data-element="<?php echo e($fil->global_name); ?>" title="<?php echo e(trans('admin::shopping.filters.index.delete_category')); ?>"></i>
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
               }, 
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