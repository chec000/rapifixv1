<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.orderestatus.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.orderestatus.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.orderestatus.index.add_new_orderestatus') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_orderestatus">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.orderestatus.index.key_estatus') }}</th>
                <th>{{ trans('admin::shopping.orderestatus.index.countries') }}</th>
                <th>{{ trans('admin::shopping.orderestatus.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.orderestatus.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($orderestatus as $oe)
            <tr id="lang_{!! $oe->id !!}">
                <td>{!! $oe->key_estatus !!}</td>



                <td>@foreach($oe->orderEstatusCountry as $ocountry)<span class="label label-default" style="margin-right: .25em;">{!! $ocountry->country->name !!}</span>@endforeach</td>
                <td><span id="status{{$oe->id}}"  class="label  {{$oe->active ? 'label-success' : 'label-default'}} ">{!! $oe->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $oe->id !!}">
                    <span onclick="disableOrderEstatus({{$oe->id}})" id='activeOrderEstatus{{$oe->id}}' class="{{$oe->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.orderestatus.index.enable') }}"></i>
                    </span>
                    <span onclick="disableOrderEstatus({{$oe->id}})" id='inactiveOrderEstatus{{$oe->id}}' class="{{$oe->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.orderestatus.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.orderestatus.editOe', ['oe_id' => $oe->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>
                     <span onclick="deleteOrderEstatus({{$oe->id}})" id='deleteOrderEstatus{{$oe->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.orderestatus.index.delete') }}"></i>
                     </span>
                     <span onclick="getCountries({{$oe->id}})">
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
            <form action="{{ route('admin.orderestatus.updatecountries') }}" id="countriesSelection" method="post">

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

    $('#tbl_orderestatus').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
    });
    function disableOrderEstatus(order_estatus_id) {
        $.ajax({
            url: route('admin.orderestatus.active'),
            type: 'POST',
            data: {order_estatus_id: order_estatus_id},
            success: function (data) {
                var label = $("#status" + order_estatus_id);
                var iconActive = $("#activeOrderEstatus" + order_estatus_id);
                var iconInactive = $("#inactiveOrderEstatus" + order_estatus_id);
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

    function deleteOrderEstatus(order_estatus_id) {
        $.ajax({
            url: route('admin.orderestatus.delete'),
            type: 'POST',
            data: {order_estatus_id: order_estatus_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }

    function getCountries(oe_id) {


        $.ajax({
            url: route('admin.orderestatus.countries'),
            type: 'POST',
            data: {oe_id: oe_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function (i, item) {
                        console.log(i, item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name[' + i + ']" type="checkbox" value="' + parseInt(item.estatus) + '" ' + check + '>' + item.name + '</label></div>');

                    });

                    $("#bodyCountries").append('<input name="reference_identifier" type="hidden" value="' + oe_id + '">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });
    }

</script>
@stop