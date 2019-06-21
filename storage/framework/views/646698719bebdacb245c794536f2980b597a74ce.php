<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::language.lang_list')); ?></h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if(Auth::action('languages.add') == true): ?>
            <a href="<?php echo e(route('admin.languages.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                <?php echo e(trans('admin::language.lang_add')); ?></a>
        <?php endif; ?>
    </div>
</div>

<div class="table-responsive">
    <?php if(isset($success)): ?>
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo e($action == 'edit' ? trans('admin::language.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang))); ?>

        </div>
    <?php endif; ?>
    <table class="table table-striped" id="tb_lang">
        <thead>
        <tr>
            <th><?php echo e(trans('admin::language.lang_list_key')); ?></th>
            <th><?php echo e(trans('admin::language.lang_list_corbiz')); ?></th>
            <th><?php echo e(trans('admin::language.lang_list_name')); ?></th>
            <th><?php echo e(trans('admin::language.lang_list_active')); ?></th>
            <?php if(Auth::action('languages.edit') || Auth::action('languages.delete')): ?>
                <th><?php echo e(trans('admin::language.lang_list_actions')); ?></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languague): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="lang_<?php echo $languague->id; ?>">
                <td><?php echo $languague->locale_key; ?></td>
                <td><?php echo $languague->corbiz_key; ?></td>
                <td><?php echo $languague->language; ?></td>
                <td>
                    <span class="label label-success langActive" style="display:<?php echo e(($languague->active == 1) ? '' : 'none'); ?>"><?php echo e(trans('admin::language.lang_list_st_active')); ?></span>
                    <span class="label label-default langInactive" style="display:<?php echo e(($languague->active == 0) ? '' : 'none'); ?>"><?php echo e(trans('admin::language.lang_list_st_inactive')); ?></span>
                </td>
                <?php if(Auth::action('languages.edit') || Auth::action('languages.active') || Auth::action('languages.delete')): ?>
                    <td data-lid="<?php echo $languague->id; ?>">
                        <?php if(Auth::action('languages.active')): ?>
                            <?php $enable = ($languague->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($languague->active == 0) ? ' hide' : null; ?>
                            <i onclick="inactivate(<?php echo $languague->id; ?>)" class="glyphicon glyphicon-stop itemTooltip<?php echo $enable; ?>" title="<?php echo e(trans('admin::language.lang_list_enable')); ?>"></i>
                            <i onclick="activate(<?php echo $languague->id; ?>)" class="glyphicon glyphicon-play itemTooltip<?php echo $disable; ?>" title="<?php echo e(trans('admin::language.lang_list_disable')); ?>"></i>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.languages.edit', ['langId' => $languague->id])); ?>" title="<?php echo e(trans('admin::language.lang_list_edit')); ?>"></a>
                            <?php if(Auth::action('languages.delete')): ?>
                                <form id="delete-lang-form-<?php echo e($languague->id); ?>" action="<?php echo e(route('admin.languages.delete', $languague->id)); ?>", method="POST" style="display: inline">
                                    <?php echo e(csrf_field()); ?>

                                    <a onclick="deleteElement(this)" data-code="<?php echo e($languague->id); ?>" data-element="<?php echo e($languague->language); ?>" id="delete-<?php echo e($languague->id); ?>" class="glyphicon glyphicon-trash itemTooltip" href="#" title="<?php echo e(trans('admin::language.delete_lang')); ?>"></a>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">

        $('#tb_lang').DataTable({
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
                $('#delete-lang-form-'+code).submit();
            });
        }

        function disable_lang(lang_id, active) {
            $.ajax({
                url: route('admin.languages.edit.post', {langId: lang_id, action: 'status'}),
                type: 'POST',
                data: {set: active},
                success: function (r) {
                    if (r == 1) {
                        if (active == 0) {
                            $("#lang_" + lang_id + " .glyphicon-play").addClass('hide');
                            $("#lang_" + lang_id + " .glyphicon-stop").removeClass('hide');
                            $("#lang_" + lang_id + " .langActive").hide();
                            $("#lang_" + lang_id + " .langInactive").show();
                        }
                        else {
                            $("#lang_" + lang_id + " .glyphicon-stop").addClass('hide');
                            $("#lang_" + lang_id + " .glyphicon-play").removeClass('hide');
                            $("#lang_" + lang_id + " .langActive").show();
                            $("#lang_" + lang_id + " .langInactive").hide();
                        }
                    }
                    else {
                        cms_alert('danger', '<?php echo e(trans('admin::language.lang_err_disable')); ?>');
                    }
                }
            });
        }

        function activate(id) {
            disable_lang(id,0);
        }

        function inactivate(id) {
            disable_lang(id,1);
        }

    </script>
<?php $__env->stopSection(); ?>
