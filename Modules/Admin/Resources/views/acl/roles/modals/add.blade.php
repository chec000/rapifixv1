<div id="addRoleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::roles.modal_add.add_role') !!}</h3>
            </div>
            {!! Form::open(['url' => route('admin.roles.add')]) !!}
            <div class="modal-body form-horizontal">
                <div class="form-group {!! FormMessage::getErrorClass('role_copy') !!}">
                    <div class="col-sm-3">
                        {!! Form::label('role_copy', trans('admin::roles.modal_add.copy_of').':', ['class' => 'control-label']) !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('role_copy', $roles, null, ['class' => 'form-control']) !!}
                        <span class="help-block control-label">{!! FormMessage::getErrorMessage('role_copy') !!}</span>
                    </div>
                </div>
                <div>
                    <h3>{{ trans('admin::language.lang_add_trans') }}</h3>
                    <p class="text-danger" style="font-style: italic;">{{ trans('admin::roles.modal_add.lang_disclaimer') }}</p>
                    @if (!empty(Session::get('msg_modal_add_role')))
                        <div class="alert alert-{{!empty(Session::get('msg_modal_add_role.type_alert')) ? Session::get('msg_modal_add_role.type_alert') : ''}} alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{!empty(Session::get('msg_modal_add_role.message_alert')) ? Session::get('msg_modal_add_role.message_alert') : ''}}
                        </div>
                    @endif

                    @foreach ($languages as $i=> $lan)
                        <div role="panel-group" id="accordion-{{$lan['id'] }}">
                            <div class="panel panel-default">
                                <div role="tab" class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{{$lan['id'] }}" href="#rol-language-{{$lan['id'] }}">{{trans('admin::roles.modal_add.country-language-title') . $lan['language'] }}</a>
                                    </h4>
                                </div>
                                <div role="tabpanel" data-parent="#accordion-{{$lan['id'] }}" id="rol-language-{{$lan['id'] }}"
                                     class="panel-collapse {{($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'}}" >
                                    <div class="panel-body">
                                        <h3>{!! $lan->language!!}</h3>
                                        <div class="form-group">
                                            <div class="form-group row {!! FormMessage::getErrorClass('role_data['.$lan->id.'][name]') !!}">
                                                <div class="col-sm-3">
                                                    {!! Form::label('role_data['.$lan->id.'][name]', trans('admin::roles.modal_add.role_name').':', ['class' => 'control-label text-left', 'required']) !!}
                                                </div>
                                                <div class="col-sm-9">
                                                    {!! Form::text('role_data['.$lan->id.'][name]', null, ['class' => 'form-control']) !!}
                                                    <span class="help-block">{!! FormMessage::getErrorMessage('role_data['.$lan->id.'][name]') !!}</span>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <div class="col-sm-3">
                                                    {!! Form::label('role_data['.$lan->id.'][description]', trans('admin::roles.modal_add.description').':', ['class' => 'control-label text-left']) !!}
                                                </div>
                                                <div class="col-sm-9">
                                                    {!! Form::textArea('role_data['.$lan->id.'][description]', null, ['class' => 'form-control', 'size' => '30x3']) !!}
                                                </div>
                                                <input type="hidden" name="{{'role_data['.$lan->id.'][locale]'}}" value="{!! $lan->locale_key !!}">
                                                <input type="hidden" name="id_lang_rol[]" value="{!! $lan->id !!}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::roles.buttons.cancel') !!}</button>
                @if(Auth::action('roles/add'))
                    <button type="submit" class="btn btn-success add"><i class="fa fa-plus"></i> &nbsp; {!! trans('admin::roles.buttons.add_role') !!}</button>
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>