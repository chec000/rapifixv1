<div id="addMIModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::menusCMS.add_menu_item') !!}:</h3>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('menu_item', trans('admin::menusCMS.pages').':', ['class' => 'control-label']) !!}
                    {!! Form::select('menu_item', $options, null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::menusCMS.buttons.cancel') !!}</button>
                <button class="btn btn-primary add" data-dismiss="modal"><i class="fa fa-plus"></i> &nbsp; {!! trans('admin::menusCMS.buttons.add') !!}</button>
            </div>
        </div>
    </div>
</div>

