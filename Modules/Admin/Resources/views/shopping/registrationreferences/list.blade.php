<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.registrationreferences.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.registrationreferences.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.registrationreferences.index.add_new_registrationreferences') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_registrationreferences">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.registrationreferences.index.key_estatus') }}</th>
                <th>{{ trans('admin::shopping.registrationreferences.index.countries') }}</th>
                <th>{{ trans('admin::shopping.registrationreferences.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.registrationreferences.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($registrationreferences as $rr)
            <tr id="lang_{!! $rr->id !!}">
                <td>{!! $rr->key_reference !!}</td>

                <td>@foreach($rr->registrationReferencesCountry as $ocountry)<span class="label label-default" style="margin-right: .25em;">{!! $ocountry->country->name !!}</span>@endforeach</td>
                <td><span id="status{{$rr->id}}"  class="label  {{$rr->active ? 'label-success' : 'label-default'}} ">{!! $rr->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $rr->id !!}">
                    <span onclick="disableRegistrationReferences({{$rr->id}})" id='activeRegistrationReferences{{$rr->id}}' class="{{$rr->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.registrationreferences.index.enable') }}"></i>
                    </span>
                    <span onclick="disableRegistrationReferences({{$rr->id}})" id='inactiveRegistrationReferences{{$rr->id}}' class="{{$rr->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.registrationreferences.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.registrationreferences.edit', ['oe_id' => $rr->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>

                        <span onclick="deleteRegistrationReferences({{$rr->id}})" id='deleteRegistrationReferences{{$rr->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.registrationreferences.index.delete') }}"></i>
                     </span>
                        <span onclick="getCountries({{$rr->id}})">
                        <i class="glyphicon glyphicon-globe itemTooltip " title="{{ trans('admin::shopping.banks.index.countries') }}"></i>
                     </span>
                    </td>
                @endif

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" role="dialog" id="countriesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.registrationreferences.updatecountries') }}" id="countriesSelection" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="modal-header">

                    <p>{{ trans('admin::shopping.banks.index.instructions') }}</p>
                </div>
                <div class="modal-body" id="bodyCountries">





                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >{{trans('admin::shopping.registrationreferences.index.close')}}</button>
                    <button type="submit" class="btn btn-primary" id="saveCountries">{{trans('admin::shopping.registrationreferences.index.save')}}</button>

                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
<script type="text/javascript">

    $('#tbl_registrationreferences').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
    });
    function disableRegistrationReferences(registration_references_id) {
        $.ajax({
            url: route('admin.registrationreferences.active'),
            type: 'POST',
            data: {registration_references_id: registration_references_id},
            success: function (data) {
                var label = $("#status" + registration_references_id);
                var iconActive = $("#activeRegistrationReferences" + registration_references_id);
                var iconInactive = $("#inactiveRegistrationReferences" + registration_references_id);
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

    function deleteRegistrationReferences(registration_references_id) {
        $.ajax({
            url: route('admin.registrationreferences.delete'),
            type: 'POST',
            data: {registration_references_id: registration_references_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

    function getCountries(registration_id) {


        $.ajax({
            url: route('admin.registrationreferences.countries'),
            type: 'POST',
            data: {registration_id: registration_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function (i, item) {
                        console.log(i, item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name[' + i + ']" type="checkbox" value="' + parseInt(item.estatus) + '" ' + check + '>' + item.name + '</label></div>');

                    });

                    $("#bodyCountries").append('<input name="reference_identifier" type="hidden" value="' + registration_id + '">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });
    }

</script>
@stop