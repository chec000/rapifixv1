<div id="subLevelMIModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::menusCMS.sublevel_menu_item_title') !!}:</h3>
            </div>
            <div class="modal-body form-horizontal">
                {!! trans('admin::menusCMS.page_currently_has') !!}
                <br/>
                <div class="form-group">
                    <div class="col-sm-3">
                        {!! Form::label('sublevels', trans('admin::menusCMS.shown_levels').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('sublevels', range(0,9), 1, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::menusCMS.buttons.cancel') !!}</button>
                <button class="btn btn-primary change" data-dismiss="modal"><i class="fa fa-check"></i> &nbsp; {!! trans('admin::menusCMS.buttons.change') !!}
                </button>
            </div>
        </div>
    </div>
</div>
