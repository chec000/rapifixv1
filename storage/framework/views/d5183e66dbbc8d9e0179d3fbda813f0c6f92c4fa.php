<div class="row textbox">
    <div class="col-sm-6">
        <h1><?php echo trans('admin::userTranslations.user_list.usr_lst'); ?></h1>
    </div>
    <div class="col-sm-6 text-right">
        <?php if($can_add == true): ?>
            <a href="<?php echo e(route('admin.users.add')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                <?php echo trans('admin::userTranslations.form_add.add_user'); ?></a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="usersListDataTable">
        <thead>
        <tr>
            <th><?php echo trans('admin::userTranslations.user_list.user'); ?></th>
            <th><?php echo trans('admin::userTranslations.user_list.name'); ?></th>
            <th><?php echo trans('admin::userTranslations.user_list.role'); ?></th>
            <th><?php echo trans('admin::userTranslations.user_list.brands'); ?></th>
            <th style="width: 150px"><?php echo trans('admin::userTranslations.user_list.countries'); ?></th>
            <th><?php echo trans('admin::userTranslations.user_list.active'); ?></th>
            <?php if($can_edit || $can_delete): ?>
                <th><?php echo trans('admin::userTranslations.user_list.actions'); ?></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="user_<?php echo $user->id; ?>">
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->role->name; ?></td>
                <td><?php $__currentLoopData = $user->userBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                
                    <span class="label label-default"><?php echo $brand->brand->name; ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td><?php $__currentLoopData = $user->userCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default"><?php echo $country->country->name; ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                    <span class="label label-success userActive" style="display:<?php echo e(($user->active == 1) ? '' : 'none'); ?>"><?php echo trans('admin::userTranslations.user_list.active'); ?></span>
                    <span class="label label-default userInactive" style="display:<?php echo e(($user->active == 0) ? '' : 'none'); ?>"><?php echo trans('admin::userTranslations.user_list.disabled'); ?></span>
                </td>
                <?php if($can_edit || $can_delete || $can_remove): ?>
                    <td data-uid="<?php echo $user->id; ?>">
                        <?php if($can_edit): ?>
                            <?php $enable = ($user->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($user->active == 0) ? ' hide' : null; ?>
                            <?php if( $user->id != Auth::user()->id): ?>
                                <i onclick="inactivate(<?php echo $user->id; ?>)" class="glyphicon glyphicon-stop itemTooltip<?php echo $enable; ?>" title="<?php echo trans('admin::userTranslations.user_list.enable_user'); ?>"></i>
                                <i onclick="activate(<?php echo $user->id; ?>)" class="glyphicon glyphicon-play itemTooltip<?php echo $disable; ?>" title="<?php echo trans('admin::userTranslations.user_list.disable_user'); ?>"></i>
                            <?php endif; ?>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.users.edit', ['userId' => $user->id])); ?>" title="<?php echo trans('admin::userTranslations.user_list.edit_user'); ?>"></a>
                        <?php endif; ?>
                        <?php if($can_remove): ?>
                            <form id="delete-user-form-<?php echo e($user->id); ?>" action="<?php echo e(route('admin.users.remove', $user)); ?>", method="POST" style="display: inline">
                                <?php echo e(csrf_field()); ?>

                                <a onclick="deleteElement(this)" data-code="<?php echo e($user->id); ?>" id="delete-<?php echo e($user->id); ?>" class="glyphicon glyphicon-trash itemTooltip" href="#" title="<?php echo e(trans('admin::userTranslations.user_list.delete_user')); ?>"></a>
                            </form>
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
        function deleteElement(element) {
            var code = $(element).data('code');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                $('#delete-user-form-'+code).submit();
            });
        }

        function disable_user(user_id, active) {
            if (user_id == <?php echo e(Auth::user()->id); ?>) {
                cms_alert('danger', "<?php echo trans('admin::userTranslations.user_list.msg_cant_disabled_own_account'); ?>");
            }
            else {
                $.ajax({
                    url: route('admin.users.edit', {userId: user_id, action: 'status'}),
                    type: 'POST',
                    data: {set: active},
                    success: function (r) {
                        if (r == 1) {
                            if (active == 0) {
                                $("#user_" + user_id + " .glyphicon-play").addClass('hide');
                                $("#user_" + user_id + " .glyphicon-stop").removeClass('hide');
                                $("#user_" + user_id + " .userActive").hide();
                                $("#user_" + user_id + " .userInactive").show();
                            }
                            else {
                                $("#user_" + user_id + " .glyphicon-stop").addClass('hide');
                                $("#user_" + user_id + " .glyphicon-play").removeClass('hide');
                                $("#user_" + user_id + " .userActive").show();
                                $("#user_" + user_id + " .userInactive").hide();
                            }
                        }
                        else {
                            cms_alert('danger', "<?php echo trans('admin::userTranslations.user_list.msg_cant_disabled_user'); ?>");
                        }
                    }
                });
            }
        }

        function activate(id) {
            disable_user(id,0);
        }

        function inactivate(id) {
            disable_user(id,1);
        }

        $(document).ready(function () {
            watch_for_delete('.glyphicon-remove', 'user', function (el) {
                var user_id = el.parent().attr('data-uid');
                if (user_id == <?php echo Auth::user()->id; ?>) {
                    alert("<?php echo trans('admin::userTranslations.user_list.msg_cant_delete_own_account'); ?>");
                    return false;
                } else {
                    return 'user_' + user_id;
                }
            });

        
        });
       $('#usersListDataTable').DataTable({
                    "responsive": true,
                    "ordering": false,
                    "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }       
        }                                                
            );   
    </script>
<?php $__env->stopSection(); ?>