<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::countries.list_title')); ?></h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if($can_add == true): ?>
            <a href="<?php echo e(route('admin.countries.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                <?php echo e(trans('admin::countries.list_add')); ?></a>
        <?php endif; ?>
    </div>
</div>
<div class="table-responsive">
    <?php if(isset($success)): ?>
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo e($action == 'edit' ? trans('admin::countries.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang))); ?>

        </div>
    <?php endif; ?>
    <table class="table table-striped" id="tb_country">
        <thead>
        <tr>
            <th><?php echo e(trans('admin::countries.corbiz_key')); ?></th>
            <th><?php echo e(trans('admin::countries.list_name')); ?></th>
            <th><?php echo e(trans('admin::countries.list_lang')); ?></th>
            <!--<th><?php echo e(trans('admin::countries.maintenance')); ?></th>-->
            <th><?php echo e(trans('admin::countries.list_active')); ?></th>
            <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::countries.list_actions')); ?></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="country_<?php echo $country->id; ?>">
                <td><?php echo $country->corbiz_key; ?></td>
                <td><?php echo $country->name; ?></td>
                <td>
                    <?php $__currentLoopData = $country->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default">   <?php echo $lang->language->language; ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                <!--<td>-->
<!--                    <span style="margin-right: 4px;" class="label label-<?php echo e(($country->shopping_active == 1) ? 'success' : 'danger'); ?>"><span class="glyphicon glyphicon-<?php echo e(($country->shopping_active == 1) ? 'ok' : 'remove'); ?>"><span class="label label-<?php echo e(($country->inscription_active == 1) ? 'success' : 'danger'); ?>" ></span> </span> <span><?php echo e(trans('admin::countries.list_shopping')); ?></span>  </span>
                    <span  style="margin-right: 4px;"  class="label label-<?php echo e(($country->inscription_active == 1) ? 'success' : 'danger'); ?>"><span class="glyphicon glyphicon-<?php echo e(($country->inscription_active == 1) ? 'ok' : 'remove'); ?>"><span class="label label-<?php echo e(($country->inscription_active == 1) ? 'success' : 'danger'); ?>" ></span> </span><span style="margin-left: 4px;"><?php echo e(trans('admin::countries.list_inscription')); ?></span> </span>
                    <span  style="margin-right: 4px;" class="label label-<?php echo e(($country->customer_active == 1) ? 'success' : 'danger'); ?>"><span class="glyphicon glyphicon-<?php echo e(($country->customer_active == 1) ? 'ok' : 'remove'); ?>"><span class="label label-<?php echo e(($country->inscription_active == 1) ? 'success' : 'danger'); ?>" ></span></span><span style="margin-left: 4px;"><?php echo e(trans('admin::countries.add_admirable_customer')); ?></span> </span>-->

                <!--</td>-->
                <td>
                    <span class="label label-success cActive" style="display:<?php echo e(($country->active == 1) ? '' : 'none'); ?>"><?php echo e(trans('admin::countries.list_st_active')); ?></span>
                    <span class="label label-default cInactive" style="display:<?php echo e(($country->active == 0) ? '' : 'none'); ?>"><?php echo e(trans('admin::countries.list_st_inactive')); ?></span>
                </td>
                <?php if($can_edit || $can_delete || $can_remove): ?>
                    <td data-cid="<?php echo $country->id; ?>">
                        <?php if($can_edit): ?>
                            <?php $enable = ($country->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($country->active == 0) ? ' hide' : null; ?>
                            <i onclick="inactivate(<?php echo $country->id; ?>)" class="glyphicon glyphicon-stop itemTooltip<?php echo $enable; ?>" title="<?php echo e(trans('admin::countries.list_enable')); ?>"></i>
                            <i onclick="activate(<?php echo $country->id; ?>)" class="glyphicon glyphicon-play itemTooltip<?php echo $disable; ?>" title="<?php echo e(trans('admin::countries.list_disable')); ?>"></i>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.countries.edit', ['countryId' => $country->id])); ?>" title="<?php echo e(trans('admin::countries.list_edit')); ?>"></a>
                                <?php if($can_remove): ?>
                                    <form id="delete-country-form-<?php echo e($country->id); ?>" action="<?php echo e(route('admin.countries.delete', $country->id)); ?>", method="POST" style="display: inline">
                                        <?php echo e(csrf_field()); ?>

                                        <a onclick="deleteElement(this)" data-code="<?php echo e($country->id); ?>" data-element="<?php echo e($country->name); ?>" id="delete-<?php echo e($country->id); ?>" class="glyphicon glyphicon-trash itemTooltip" href="#" title="<?php echo e(trans('admin::countries.delete_country')); ?>"></a>
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

        $('#tb_country').DataTable({
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
                $('#delete-country-form-'+code).submit();
            });
        }

        function disable_country(country_id) {
            $.ajax({
                url: route('admin.countries.active'),
                type: 'POST',
                data: {countryId: country_id},
                success: function (r) {
                    if (r.status === 0) {
                        $("#country_" + country_id + " .glyphicon-play").addClass('hide');
                        $("#country_" + country_id + " .glyphicon-stop").removeClass('hide');
                        $("#country_" + country_id + " .cActive").hide();
                        $("#country_" + country_id + " .cInactive").show();

                    }
                    else {
                        $("#country_" + country_id + " .glyphicon-stop").addClass('hide');
                        $("#country_" + country_id + " .glyphicon-play").removeClass('hide');
                        $("#country_" + country_id + " .cActive").show();
                        $("#country_" + country_id + " .cInactive").hide();

                    }
                }

            });
        }

        function activate(id) {
            disable_country(id,0);
        }

        function inactivate(id) {
            disable_country(id,1);
        }
    </script>
    <?php $__env->stopSection(); ?>
    </div>
    </div>



