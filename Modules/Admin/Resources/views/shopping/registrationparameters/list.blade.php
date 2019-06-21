<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.registrationparameters.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.registrationparameters.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.registrationparameters.index.add_new_registrationparameters') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_registrationparameters">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.registrationparameters.index.country') }}</th>
                <th>{{ trans('admin::shopping.registrationparameters.index.min_age') }}</th>
                <th>{{ trans('admin::shopping.registrationparameters.index.max_age') }}</th>
                <th>{{ trans('admin::shopping.registrationparameters.index.has_documents') }}</th>
                <th>{{ trans('admin::shopping.registrationparameters.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.registrationparameters.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($registrationparameters as $rp)

            <tr id="lang_{!! $rp->id !!}">
                <td>{!! $rp->country->name !!}</td>
                <td>{{$rp->min_age}}</td>
                <td>{{$rp->max_age}}</td>
                <td style="text-align: center">
                    @if($rp->has_documents == 1)
                        <i class="fa fa-2x fa-check text-success"></i>
                    @else
                        <i class="fa fa-2x fa-times text-danger"></i>

                    @endif

                </td>

                <td><span id="status{{$rp->id}}"  class="label  {{$rp->active ? 'label-success' : 'label-default'}} ">{!! $rp->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $rp->id !!}">
                    <span onclick="disableRegistrationParameters({{$rp->id}})" id='activeRegistrationParameters{{$rp->id}}' class="{{$rp->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.registrationparameters.index.enable') }}"></i>
                    </span>
                    <span onclick="disableRegistrationParameters({{$rp->id}})" id='inactiveRegistrationParameters{{$rp->id}}' class="{{$rp->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.registrationparameters.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.registrationparameters.edit', ['oe_id' => $rp->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>

                        <span onclick="deleteRegistrationParameters({{$rp->id}})" id='deleteRegistrationParameters{{$rp->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.registrationparameters.index.delete') }}"></i>
                     </span>
                    </td>
                @endif

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">

    $('#tbl_registrationparameters').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
    });
    function disableRegistrationParameters(registration_parameters_id) {
        $.ajax({
            url: route('admin.registrationparameters.active'),
            type: 'POST',
            data: {registration_parameters_id: registration_parameters_id},
            success: function (data) {
                var label = $("#status" + registration_parameters_id);
                var iconActive = $("#activeRegistrationParameters" + registration_parameters_id);
                var iconInactive = $("#inactiveRegistrationParameters" + registration_parameters_id);
                if (data.status === 0) {
                    iconActive.removeClass('hide');
                    iconInactive.addClass('hide');
                    label.removeClass('label-success').addClass('label-default');
                    label.text(data.message);
                }
                else {
                    iconActive.addClass('hide');
                    iconInactive.removeClass('hide');
                    label.removeClass('label-default').addClass('label-success');
                    label.text(data.message);
                }
            }
        });
    }

    function deleteRegistrationParameters(registration_parameters_id) {
        $.ajax({
            url: route('admin.registrationparameters.delete'),
            type: 'POST',
            data: {registration_parameters_id: registration_parameters_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

</script>
@stop