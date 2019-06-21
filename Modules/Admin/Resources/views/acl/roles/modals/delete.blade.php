<div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::roles.modal_disable.disable_role') !!}:<span class="roleName"></span></h3>
            </div>
            <div class="modal-body form-horizontal">
                {!! Form::open(['url' => route('admin.roles.delete')]) !!}
                <p>{!! trans('admin::roles.modal_disable.msg_assigned_another_role') !!}</p>
                <br/>
                <div class="form-group {!! FormMessage::getErrorClass('new_role') !!}">
                    <div class="col-sm-3">
                        {!! Form::label('new_role', trans('admin::roles.modal_disable.new_role').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9 new_role_container">
                        {!! Form::select('new_role', $roles, null, ['class' => 'form-control']) !!}
                        <span id="new_role_help" class="help-block"></span>
                        <span class="help-block">{!! FormMessage::getErrorMessage('new_role') !!}</span>
                    </div>
                    <input type="hidden" name="id_rol_disable" value="{{ !empty(Session::get('id_rol_disable')) ? Session::get('id_rol_disable') : '' }}">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i>{!! trans('admin::roles.buttons.cancel') !!}</button>
                @if(Auth::action('roles/delete'))
                    <button type="submit" class="btn btn-primary delete"><i class="fa fa-trash"></i> {!! trans('admin::roles.buttons.disable') !!}</button>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div id="activeRolModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(['url' => route('admin.roles.active')]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::roles.modal_active.active_role') !!}: <span class="roleName"></span></h3>
            </div>
            <div class="modal-body form-horizontal">
                <p>{!! trans('admin::roles.modal_active.msg_active_role') !!}</p>
                <input type="hidden" name="id_rol_active" value="{{ !empty(Session::get('id_rol_disable')) ? Session::get('id_rol_disable') : '' }}">
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::roles.buttons.cancel') !!}</button>
                @if(Auth::action('roles/active'))
                    <button type="submit" class="btn btn-success delete"><i class="fa fa-check"></i> &nbsp; {!! trans('admin::roles.buttons.active') !!}</button>
                @endif
            </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>
