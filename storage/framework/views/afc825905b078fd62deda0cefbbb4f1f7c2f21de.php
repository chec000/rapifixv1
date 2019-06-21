<div id="statsMenusModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3><?php echo trans('admin::menusCMS.records_history_menus'); ?></h3>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped" id="statsMenusTable">
                        <thead>
                        <tr>
                            <th><?php echo trans('admin::pages.brand'); ?></th>
                            <th><?php echo trans('admin::pages.country'); ?></th>
                            <th><?php echo trans('admin::pages.language'); ?></th>
                            <th><?php echo trans('admin::menusCMS.main_menu'); ?></th>
                            <th><?php echo trans('admin::menusCMS.footer'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($dataStatsMenus)): ?>
                            <?php $__currentLoopData = $dataStatsMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statsMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo $statsMenu->brand; ?></td>
                                        <td><?php echo $statsMenu->country; ?></td>
                                        <td><?php echo $statsMenu->language; ?></td>
                                        <td> <?php echo trans('admin::pages.pages'); ?>: &nbsp;<?php echo $statsMenu->main_menu->total; ?></td>
                                        <td> <?php echo trans('admin::pages.pages'); ?>: &nbsp;<?php echo $statsMenu->footer->total; ?></td>
                                    </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; <?php echo trans('admin::menusCMS.buttons.close'); ?></button>
            </div>
        </div>
    </div>
</div>