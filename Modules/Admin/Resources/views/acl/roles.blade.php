<div class="row textbox" id="form_crud_roles">
    @if (!empty(Session::get('result')))
        <div class="alert alert-{{!empty(Session::get('result.type_alert')) ? Session::get('result.type_alert') : ''}} alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{!empty(Session::get('result.message_alert')) ? Session::get('result.message_alert') : ''}}
        </div>
    @endif
    <div class="col-lg-4 col-md-4 col-sm-6">
        <h1>{!! trans('admin::roles.view_roles.roles') !!}</h1>
        <div class="form-inline">
            <div class="form-group">
                {!! Form::label('role_select', trans('admin::roles.view_roles.view_role'), ['class' => 'control-label']) !!} &nbsp;

                <select id="role" name="role_select" class="form-control long-select">
                    @foreach($roles as $index => $rol_select)
                        <option value="{{ $index}}" data-active="{{ $rol_select['active'] }}">{{ $rol_select['name']}}</option>
                    @endforeach
                </select>
                <!-- {!! Form::select('role_select', $roles, null, ['id' => 'role', 'class' => 'form-control long-select']) !!} -->
                &nbsp; <i id="loading_icon" class="fa fa-cog fa-spin"></i> &nbsp;
                <span id="loading_text">{!! trans('admin::roles.view_roles.loading') !!}</span>
                <span id="saving_text" style="display: none;">{!! trans('admin::roles.view_roles.saving') !!}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-5 col-sm-6 text-right">
        @if(Auth::action('roles/active'))
            <button type="button" class="btn btn-success addButton" id="activeRole" style="display: none;"><i class="fa fa-check"></i> &nbsp;{!! trans('admin::roles.buttons.active_role') !!}</button>
        @endif
        @if(Auth::action('roles/delete'))
                <button type="button" class="btn btn-danger addButton" id="deleteRole" style="display: none;"><i class="fa fa-minus"></i> &nbsp;{!! trans('admin::roles.buttons.disabled_role') !!} </button>
        @endif
        @if(Auth::action('roles/edit'))
                <button role="button" class="btn btn-info addButton" id="editRole" ><i class="fa fa-check"></i> &nbsp;{!! trans('admin::roles.buttons.edit_role') !!}</button>
        @endif

    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 text-right">
        @if(Auth::action('roles/add'))
            <button type="button" class="btn btn-warning addButton" id="addRole"><i class="fa fa-plus"></i> &nbsp; {!! trans('admin::roles.buttons.add_role') !!}</button>
        @endif
    </div>
</div>

<div id="actions">
    {!! $actions !!}
</div>

<div id="editPanel">
    @section('contentEditModal')

    @show
</div>

@section('scripts')

    <script type='text/javascript'>

        var delete_item, save_timer, load_timer;

        function enableDisabledButtons(){
            if($( "#role option:selected" ).data('active') == 1){
                $("#activeRole").hide();
                $("#deleteRole").fadeIn();
                $("#editRole").fadeIn();
            } else {
                $("#deleteRole").hide();
                $("#editRole").hide();
                $("#activeRole").fadeIn();

            }
        };


        function update_checkboxes(role_id) {
            var user_role = parseInt({{ Auth::user()->role->id }});
            clearTimeout(load_timer);
            $('#loading_icon').show();
            $('#loading_text').show();
            $('#page_permissions').attr('href', route('admin.roles.pages', {roleId: $('#role').val()}));
            $.ajax({
                url: route('admin.roles.actions', {roleId: role_id}),
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#actions input[type=checkbox]").prop('checked', false);
                    $.each(data, function (k, v) {
                        $("#actions input[name=" + k + "]").prop('checked', true);
                    });
                    if (role_id == user_role) {
                        $("#actions input.controller-roles").attr('disabled', 'disabled');
                    } else {
                        $("#actions input.controller-roles").removeAttr("disabled");
                    }
                    load_timer = setTimeout(function () {
                        $('#loading_icon').hide();
                        $('#loading_text').hide();
                    }, 500);
                }
            });
        }

        $(document).ready(function () {

            @if (!empty(Session::get('showModalAdd')) && Session::get('showModalAdd') == 1)
                @if (!empty(Session::get('arrayValidPost')))
                        $("div[id*='rol-language-']").removeClass('in').removeClass('collapse').addClass('collapse');
                        @foreach(Session::get('arrayValidPost') as $avp)
                            $('#rol-language-{{$avp}}').addClass('in').css('height', 'auto');
                        @endforeach
                @endif
                $('#addRoleModal').modal('show');
            @endif

            @if (!empty(Session::get('showModalDelete')) && Session::get('showModalDelete') == 1)
                $( "#role" ).val({{ Session::get('id_rol_disable') }}).trigger("selectmenuselect");
                $('#deleteModal .roleName').html($('#role option:selected').text());
                $("#deleteModal").modal('show');
            @endif

            @if (!empty(Session::get('id_rol_edit')) && Session::get('id_rol_edit') != null)
                $( "#role" ).val({{ Session::get('id_rol_edit') }}).trigger("selectmenuselect");
            @endif
            @if (!empty(Session::get('showModalEdit')) && Session::get('showModalEdit') == 1)
                $('#editRoleModal .roleName').html($('#role option:selected').text());
                @if (!empty(Session::get('arrayValidPost')))
                    $('#editRoleModal').find("div[id*='rol-edit-language-']").removeClass('in').removeClass('collapse').addClass('collapse');
                    @foreach(Session::get('arrayValidPost') as $avp)
                        $('#editRoleModal').find('#rol-edit-language-{{$avp}}').addClass('in').css('height', 'auto');
                    @endforeach
                @endif
                $("#editRoleModal").modal('show');
            @endif


            enableDisabledButtons();

            update_checkboxes($('#role').val());
            $('#role').change(function () {
                update_checkboxes($(this).val());
                enableDisabledButtons();
            });
            $('#addRole').click(function () {
                $('#addRoleModal').modal('show');
            });
            $("#actions input[type=checkbox]").click(function () {
                clearTimeout(save_timer);
                $('#loading_icon').show();
                $('#saving_text').show();
                $.ajax({
                    url: route('admin.roles.edit'),
                    type: 'POST',
                    data: {action: $(this).attr('name'), role: $('#role').val(), value: $(this).prop('checked')},
                    success: function (r) {
                        if (r === '1') {
                            save_timer = setTimeout(function () {
                                $('#loading_icon').hide();
                                $('#saving_text').hide();
                            }, 500);
                        }
                    }
                });
            });
            /* $('#addRoleModal .add').click(function () {
                if ($('#role_name').val() == "") {
                    $('#role_name').parent().parent().addClass('has-error');
                } else {


                    var arrayRole = [];

                    $('input[name^="role_name"]').each(function() {
                        var description = $(this).closest('.tab-pane').find('[name^=role_description]').val();
                        var id_lang_rol = $(this).closest('.tab-pane').find('[name^=id_lang_rol]').val();
                        var locale_lang = $(this).closest('.tab-pane').find('[name^=locale_lang]').val();

                        if($(this).val() !== "") {
                            var JSONObject = [
                                {
                                    "id_lang": id_lang_rol,
                                    "role": $(this).val(),
                                    "desc": description
                                }
                            ];

                            arrayRole.push(JSON.stringify(JSONObject));
                        }

                    });
                    $.ajax({
                        url: route('admin.roles.add'),
                        type: 'POST',
                        contentType: 'application/x-www-form-urlencoded',
                        //data: {name: $('#role_name').val(), copy: $('#role_copy').val()},
                        data: {
                                'role_name' : arrayRole,
                                'role_copy' : $('#role_copy').val()
                            },
                        success: function (data) {
                            $('#addRoleModal').modal('hide');
                            var last = 0;
                            $.each(data, function (k, v) {
                                $('#role').append('<option value="' + k + '">' + v + '</option>');
                                $('#role_copy').append('<option value="' + k + '">' + v + '</option>');
                                $('#new_role').append('<option value="' + k + '">' + v + '</option>');
                                last = k;
                            });
                            $('#role').val(last);
                            update_checkboxes(last);
                        }
                    });
                    $('#role_name').parent().parent().removeClass('has-error');
                    $('#role_name').val('');
                    $('#role_copy').val(0);
                }
            });*/

            $('#deleteRole').click(function () {
                delete_item = $('#role').val();
                $('#deleteModal .roleName').html($('#role option:selected').text());
                $('#new_role').parent().parent().removeClass('has-error');
                $('#new_role_help').html('');
                $('#deleteModal').modal('show');
                $('input[name=id_rol_disable]').val(delete_item);
            });

            $('#activeRole').click(function () {
                var activeRole = $('#role').val();
                $('#activeRolModal .roleName').html($('#role option:selected').text());
                $('#activeRolModal').modal('show');
                $('#activeRolModal input[name=id_rol_active]').val(activeRole);
            });

            $('#editRole').click(function () {

                var edit_role = $('#role').val();
                console.log($('#role').val());

                $('#editRoleModal').find('input[name*="][name]"]').val('');
                $('#editRoleModal').find('[name*="][description]"]').text('');
                $('#editRoleModal').find('input[name*="][user_role_id]"]').val('');
                $('#editRoleModal').find("div[id^='rol-edit-language-']").removeClass('in').removeClass('collapse').addClass('collapse');


                $.ajax({
                    url: route('admin.roles.edit.translates', {roleId: edit_role}),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $.each( data, function( key, value ) {
                            console.log( key + ": " + value.locale );
                            $('#editRoleModal').find('input[name=id_rol_edit]').val(edit_role);
                            $('#editRoleModal').find('input[name="role_data['+value.lang_id+'][name]"]').val(value.name);
                            $('#editRoleModal').find('[name="role_data['+value.lang_id+'][description]"]').text(value.description);
                            $('#editRoleModal').find('input[name="role_data['+value.lang_id+'][user_role_id]"]').val(value.user_role_id);
                            //$('#editRoleModal').find('input[name="role_data['+value.lang_id+'][locale]"]').val(value.locale);

                            $('#editRoleModal').find("#rol-edit-language-"+value.lang_id).removeClass('collapse').addClass('in').css('height', 'auto');
                            $('#editRoleModal .roleName').html($('#role option:selected').text());

                        });
                        //$('#editPanel').empty().append($(data));
                    },
                    error: function (jqXHR, timeout, message) {
                        var contentType = jqXHR.getResponseHeader("Content-Type");
                        if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                            window.location.reload();
                        }
                    }
                })
                    .done(function() {
                        $('#editRoleModal').modal('show');
                    });
            });

            /*$('#deleteModal .delete').click(function () {
                if ($('#new_role').val() == delete_item) {
                    $('#new_role').parent().parent().addClass('has-error');
                    $('#new_role_help').html('must select a different role');
                }
                else {
                    $('#deleteModal').modal('hide');
                    $.ajax({
                        url: route('admin.roles.delete'),
                        type: 'POST',
                        data: {role: delete_item, new_role: $('#new_role').val()},
                        success: function (r) {
                            $("body").html(r);
                            //location.reload();
                            /*$('#role option[value=' + delete_item + ']').remove();
                            $('#new_role option[value=' + delete_item + ']').remove();
                            $('#role_copy option[value=' + delete_item + ']').remove();
                            update_checkboxes($('#role').val());
                        }
                    });
                }
            });*/
        });



        $('.collapse_tbl_group').click(function () {
            $(this).find('.glyphicon').toggleClass("glyphicon-chevron-down").toggleClass("glyphicon-chevron-up");
        });

    </script>
@stop
