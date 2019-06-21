<div class="row textbox">
    <div class="col-sm-6">
        <h1>{!! trans('admin::userTranslations.user_list.usr_lst') !!}</h1>
    </div>
    <div class="col-sm-6 text-right">
        @if ($can_add == true)
            <a href="{{ route('admin.users.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                {!! trans('admin::userTranslations.form_add.add_user') !!}</a>
        @endif
    </div>
</div>
<div class="table">
    <table class="table table-striped" id="usersListDataTable">
        <thead>
        <tr>
            <th>{!! trans('admin::userTranslations.user_list.user') !!}</th>
            <th>{!! trans('admin::userTranslations.user_list.name') !!}</th>
            <th>{!! trans('admin::userTranslations.user_list.role') !!}</th>
            <th>{!! trans('admin::userTranslations.user_list.brands') !!}</th>
            <th style="width: 150px">{!! trans('admin::userTranslations.user_list.countries') !!}</th>
            <th>{!! trans('admin::userTranslations.user_list.active') !!}</th>
            @if ($can_edit || $can_delete)
                <th>{!! trans('admin::userTranslations.user_list.actions') !!}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr id="user_{!! $user->id !!}">
                <td>{!! $user->email !!}</td>
                <td>{!! $user->name !!}</td>
                <td>{!! $user->role->name !!}</td>
                <td>@foreach($user->userBrands as $brand)                
                    <span class="label label-default">{!! $brand->brand->name !!}</span>
                    @endforeach
                </td>
                <td>@foreach($user->userCountries as $country)
                        <span class="label label-default">{!! $country->country->name !!}</span>
                    @endforeach
                </td>
                <td>
                    <span class="label label-success userActive" style="display:{{ ($user->active == 1) ? '' : 'none' }}">{!! trans('admin::userTranslations.user_list.active') !!}</span>
                    <span class="label label-default userInactive" style="display:{{ ($user->active == 0) ? '' : 'none' }}">{!! trans('admin::userTranslations.user_list.disabled') !!}</span>
                </td>
                @if ($can_edit || $can_delete || $can_remove)
                    <td data-uid="{!! $user->id !!}">
                        @if ($can_edit)
                            <?php $enable = ($user->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($user->active == 0) ? ' hide' : null; ?>
                            @if ( $user->id != Auth::user()->id)
                                <i onclick="inactivate({!! $user->id !!})" class="glyphicon glyphicon-stop itemTooltip{!! $enable !!}" title="{!! trans('admin::userTranslations.user_list.enable_user') !!}"></i>
                                <i onclick="activate({!! $user->id !!})" class="glyphicon glyphicon-play itemTooltip{!! $disable !!}" title="{!! trans('admin::userTranslations.user_list.disable_user') !!}"></i>
                            @endif
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.users.edit', ['userId' => $user->id]) }}" title="{!! trans('admin::userTranslations.user_list.edit_user') !!}"></a>
                        @endif
                        @if ($can_remove)
                            <form id="delete-user-form-{{ $user->id }}" action="{{ route('admin.users.remove', $user) }}", method="POST" style="display: inline">
                                {{ csrf_field() }}
                                <a onclick="deleteElement(this)" data-code="{{ $user->id }}" id="delete-{{ $user->id }}" class="glyphicon glyphicon-trash itemTooltip" href="#" title="{{ trans('admin::userTranslations.user_list.delete_user') }}"></a>
                            </form>
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

</div>

@section('scripts')

    <script type="text/javascript">
        function deleteElement(element) {
            var code = $(element).data('code');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                $('#delete-user-form-'+code).submit();
            });
        }

        function disable_user(user_id, active) {
            if (user_id == {{ Auth::user()->id }}) {
                cms_alert('danger', "{!! trans('admin::userTranslations.user_list.msg_cant_disabled_own_account')  !!}");
            }
            else {
                $.ajax({
                    url: route('admin.users.edit', {userId: user_id, action: 'status'}),
                    type: 'POST',
                    data: {set: active},
                    success: function (r) {
                        if (r == 1) {
                            if (active == 0) {
                                $("#user_" + user_id + " .glyphicon-play").addClass('hide');
                                $("#user_" + user_id + " .glyphicon-stop").removeClass('hide');
                                $("#user_" + user_id + " .userActive").hide();
                                $("#user_" + user_id + " .userInactive").show();
                            }
                            else {
                                $("#user_" + user_id + " .glyphicon-stop").addClass('hide');
                                $("#user_" + user_id + " .glyphicon-play").removeClass('hide');
                                $("#user_" + user_id + " .userActive").show();
                                $("#user_" + user_id + " .userInactive").hide();
                            }
                        }
                        else {
                            cms_alert('danger', "{!! trans('admin::userTranslations.user_list.msg_cant_disabled_user')  !!}");
                        }
                    }
                });
            }
        }

        function activate(id) {
            disable_user(id,0);
        }

        function inactivate(id) {
            disable_user(id,1);
        }

        $(document).ready(function () {
            watch_for_delete('.glyphicon-remove', 'user', function (el) {
                var user_id = el.parent().attr('data-uid');
                if (user_id == {!! Auth::user()->id !!}) {
                    alert("{!! trans('admin::userTranslations.user_list.msg_cant_delete_own_account')  !!}");
                    return false;
                } else {
                    return 'user_' + user_id;
                }
            });

        
        });
       $('#usersListDataTable').DataTable({
                    "responsive": true,
                    "ordering": false,
                    "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }       
        }                                                
            );   
    </script>
@stop