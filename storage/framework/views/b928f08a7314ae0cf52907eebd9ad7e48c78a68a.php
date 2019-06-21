<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo e(trans('admin::shopping.registrationreferences.index.list_estatus')); ?></h1>
    </div>
    <?php if($can_add): ?>
    <div class="col-sm-6 text-right">     
        <a href="<?php echo e(route('admin.registrationreferences.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            <?php echo e(trans('admin::shopping.registrationreferences.index.add_new_registrationreferences')); ?></a>
    </div>
    <?php endif; ?>

</div>
<?php if(Session::has('info')): ?>

    <p class="alert <?php echo e(Session::get('info')['alertclass']); ?>" role="alert">
        <?php echo e(Session::get('info')['message']); ?>

    </p>

<?php endif; ?>
<div class="table">


    <table class="table table-striped" id="tbl_registrationreferences">
        <thead>
            <tr>
                <th><?php echo e(trans('admin::shopping.registrationreferences.index.key_estatus')); ?></th>
                <th><?php echo e(trans('admin::shopping.registrationreferences.index.countries')); ?></th>
                <th><?php echo e(trans('admin::shopping.registrationreferences.index.status')); ?></th>
                <?php if($can_edit || $can_delete): ?>
                <th><?php echo e(trans('admin::shopping.registrationreferences.index.actions')); ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $registrationreferences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="lang_<?php echo $rr->id; ?>">
                <td><?php echo $rr->key_reference; ?></td>

                <td><?php $__currentLoopData = $rr->registrationReferencesCountry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><span class="label label-default" style="margin-right: .25em;"><?php echo $ocountry->country->name; ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                <td><span id="status<?php echo e($rr->id); ?>"  class="label  <?php echo e($rr->active ? 'label-success' : 'label-default'); ?> "><?php echo $rr->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active'); ?></span></td>
                <?php if($can_edit || $can_delete): ?>
                    <td data-lid="<?php echo $rr->id; ?>">
                    <span onclick="disableRegistrationReferences(<?php echo e($rr->id); ?>)" id='activeRegistrationReferences<?php echo e($rr->id); ?>' class="<?php echo e($rr->active ? 'hide' : ''); ?>">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="<?php echo e(trans('admin::shopping.registrationreferences.index.enable')); ?>"></i>
                    </span>
                    <span onclick="disableRegistrationReferences(<?php echo e($rr->id); ?>)" id='inactiveRegistrationReferences<?php echo e($rr->id); ?>' class="<?php echo e($rr->active ? '' : 'hide'); ?>">
                        <i class="glyphicon glyphicon-play itemTooltip " title="<?php echo e(trans('admin::shopping.registrationreferences.index.disable')); ?>"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.registrationreferences.edit', ['oe_id' => $rr->id])); ?>" title="<?php echo e(trans('admin::language.lang_list_edit')); ?>"></a>

                        <span onclick="deleteRegistrationReferences(<?php echo e($rr->id); ?>)" id='deleteRegistrationReferences<?php echo e($rr->id); ?>'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="<?php echo e(trans('admin::shopping.registrationreferences.index.delete')); ?>"></i>
                     </span>
                        <span onclick="getCountries(<?php echo e($rr->id); ?>)">
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
            <form action="<?php echo e(route('admin.registrationreferences.updatecountries')); ?>" id="countriesSelection" method="post">

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

    $('#tbl_registrationreferences').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }
    });
    function disableRegistrationReferences(registration_references_id) {
        $.ajax({
            url: route('admin.registrationreferences.active'),
            type: 'POST',
            data: {registration_references_id: registration_references_id},
            success: function (data) {
                var label = $("#status" + registration_references_id);
                var iconActive = $("#activeRegistrationReferences" + registration_references_id);
                var iconInactive = $("#inactiveRegistrationReferences" + registration_references_id);
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

    function deleteRegistrationReferences(registration_references_id) {
        $.ajax({
            url: route('admin.registrationreferences.delete'),
            type: 'POST',
            data: {registration_references_id: registration_references_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

    function getCountries(registration_id) {


        $.ajax({
            url: route('admin.registrationreferences.countries'),
            type: 'POST',
            data: {registration_id: registration_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function (i, item) {
                        console.log(i, item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name[' + i + ']" type="checkbox" value="' + parseInt(item.estatus) + '" ' + check + '>' + item.name + '</label></div>');

                    });

                    $("#bodyCountries").append('<input name="reference_identifier" type="hidden" value="' + registration_id + '">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });
    }

</script>
<?php $__env->stopSection(); ?>