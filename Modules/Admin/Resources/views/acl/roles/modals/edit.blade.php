<div id="editRoleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::roles.modal_edit.edit_role') !!}:<span class="roleName"></span></h3>
            </div>
            {!! Form::open(['url' => route('admin.roles.editRole')]) !!}
            <div class="modal-body">
                <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
                <p class="text-danger" style="font-style: italic;">{{ trans('admin::roles.modal_edit.lang_disclaimer') }}</p>
                @if (!empty(Session::get('msg_modal_edit_role')))
                    <div class="alert alert-{{!empty(Session::get('msg_modal_edit_role.type_alert')) ? Session::get('msg_modal_edit_role.type_alert') : ''}} alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{!empty(Session::get('msg_modal_edit_role.message_alert')) ? Session::get('msg_modal_edit_role.message_alert') : ''}}
                    </div>
                @endif
                <input type="hidden" name="id_rol_edit" value="{{ !empty(Session::get('id_rol_disable')) ? Session::get('id_rol_disable') : '' }}">

                @foreach ($languages as $i=> $lan)
                    <div role="panel-group" id="edit-accordion-{{$lan['id'] }}">
                        <div class="panel panel-default">
                            <div role="tab" class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#edit-accordion-{{$lan['id'] }}" href="#rol-edit-language-{{$lan['id'] }}">{{trans('admin::roles.modal_edit.country-language-title') . $lan['language'] }}</a>
                                </h4>
                            </div>
                            <div role="tabpanel" data-parent="#edit-accordion-{{$lan['id'] }}" id="rol-edit-language-{{$lan['id'] }}"
                                 class="panel-collapse {{($errors->has('role_data['.$lan['id'].'][name]')) ? 'in' : 'collapse'}}" >
                                <div class="panel-body">
                                    <h3>{!! $lan['language']!!}</h3>
                                    <div class="form-group">
                                        <div class="form-group row {!! FormMessage::getErrorClass('role_data['.$lan['id'].'][name]') !!}">
                                            <div class="col-sm-3">
                                                {!! Form::label('role_data['.$lan['id'].'][name]', trans('admin::roles.modal_add.role_name').':', ['class' => 'control-label text-left', 'required']) !!}
                                            </div>
                                            <div class="col-sm-9">
                                                {!! Form::text('role_data['.$lan['id'].'][name]', null, ['class' => 'form-control']) !!}
                                                <span class="help-block">{!! FormMessage::getErrorMessage('role_data['.$lan['id'].'][name]') !!}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <div class="col-sm-3">
                                                {!! Form::label('role_data['.$lan['id'].'][description]', trans('admin::roles.modal_add.description').':', ['class' => 'control-label text-left']) !!}
                                            </div>
                                            <div class="col-sm-9">
                                                {!! Form::textArea('role_data['.$lan['id'].'][description]', null, ['class' => 'form-control', 'size' => '30x3']) !!}
                                            </div>
                                            <input type="hidden" name="{{'role_data['.$lan['id'].'][user_role_id]'}}" value="0">
                                            <input type="hidden" name="{{'role_data['.$lan['id'].'][locale]'}}" value="{!! $lan['locale_key'] !!}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::roles.buttons.cancel') !!}</button>
                @if(Auth::action('roles/edit'))
                    <button type="submit" class="btn btn-success add"><i class="fa fa-pencil"></i> &nbsp; {!! trans('admin::roles.buttons.edit_role') !!}</button>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>