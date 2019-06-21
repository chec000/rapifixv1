<div id="confirm-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                {{ trans('admin::distributorsPool.general.are_sure') }}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">{{ trans('admin::distributorsPool.general.cancel') }}</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">{{ trans('admin::distributorsPool.general.delete') }}</button>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->