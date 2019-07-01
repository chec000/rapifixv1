<div id="confirm-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo e(trans('admin::distributorsPool.general.are_sure')); ?>

            </div>
            <div class="modal-footer">
                <button id="cancel-confirm" type="button" data-dismiss="modal" class="btn"><?php echo e(trans('admin::distributorsPool.general.cancel')); ?></button>
                <button id="accept-confirm" type="button" data-dismiss="modal" class="btn btn-primary" id="delete"><?php echo e(trans('admin::distributorsPool.general.delete')); ?></button>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->