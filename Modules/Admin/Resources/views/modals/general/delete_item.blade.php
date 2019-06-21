<div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::menusCMS.remove') !!} <span class='itemTypeC'></span>: <span class='itemName'></span></h3>
            </div>
            <div class="modal-body">
                <p>{!! trans('admin::menusCMS.msg_confirmation_remove') !!}<span class='itemType'></span> '<span class='itemName'></span>' ?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn no" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::menusCMS.buttons.no') !!}</button>
                <button class="btn btn-primary yes" data-dismiss="modal"><i class="fa fa-check"></i> &nbsp; {!! trans('admin::menusCMS.buttons.yes') !!}</button>
            </div>
        </div>
    </div>
</div>
