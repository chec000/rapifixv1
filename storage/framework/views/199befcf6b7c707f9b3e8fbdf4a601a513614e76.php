<div id="listpages" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo trans('admin::pages.modal_history_title'); ?></h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped dataTable no-footer" id="list_table_pages" role="grid" aria-describedby="statsBlocksTable_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.brand'); ?></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.country'); ?></th>
                                  <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.language'); ?></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.name'); ?></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.url'); ?></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"><?php echo trans('admin::pages.status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($pages)): ?>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr role="row" class="odd">
                                <td><?php echo $p->marcas; ?></td>
                                <td><?php echo $p->countries; ?></td>
                                <td><?php echo $p-> language; ?></td>
                                <td><?php echo $p->nombre; ?></td>
                                <td><?php echo $p->url; ?></td>
                                <td>

                                    <?php switch($p->status):
                                    case (1): ?>
                                    <span class="label type_link"><?php echo trans('admin::pages.link_document'); ?></span>
                                    <?php break; ?>
                                    <?php case (2): ?>
                                    <span class="label type_group"><?php echo trans('admin::pages.group_page'); ?></span>
                                    <?php break; ?>
                                    <?php case (3): ?>
                                    <span class="label type_hidden"><?php echo trans('admin::pages.not_live'); ?></span>
                                    <?php break; ?>
                                    <?php case (4): ?>
                                    <span class="label type_normal_dark"><?php echo trans('admin::pages.normal_page'); ?></span>
                                    <?php break; ?>
                                    <?php endswitch; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>


                        </tbody>
                    </table>


                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; <?php echo trans('admin::pages.close'); ?></button>
            </div>
        </div>
    </div>
</div>
