<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.warehouses.index.title') }}</h1>
    </div>
    @if (Auth::action('warehouses.create'))
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.warehouses.create') }}" class="btn btn-warning addButton">
            <i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.warehouses.index.form-add-button') }}
        </a>
    </div>
    @endif
    <div class="col-md-12">
        @if(session('msg'))
            <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
        @elseif(session('errors') != null)
            <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
        @endif
    </div>
</div>

<div class="table">
    <table id="warehouses" class="table table-striped">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.warehouses.index.thead-name') }}</th>
                <th>{{ trans('admin::shopping.warehouses.index.thead-country') }}</th>
                <th class="text-center">{{ trans('admin::shopping.warehouses.index.thead-active') }}</th>
                <th class="text-center">{{ trans('admin::shopping.warehouses.index.thead-actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($warehouse as $w)
            <tr>
                <td>{!! $w->warehouse !!}</td>
                <td>
                    @foreach($w->country as $c)
                        <span class="label label-default">{{ $c }}</span>
                    @endforeach
                </td>
                <td class="text-center">
                    @if($w->active == 1)
                        <span class="label label-success">@lang('admin::shopping.warehouses.index.active')</span>
                    @else
                        <span class="label label-warning">@lang('admin::shopping.warehouses.index.inactive')</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            @if($w->active == 1)
                                @if (Auth::action('warehouses.changeStatus'))
                                    <form name="formOff_{{ $w->id }}" method="POST" action="{{ route('admin.warehouses.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $w['warehouse'] }}"/>
                                        <input type="hidden" name="type" value="deactivate"/>
                                        <i class="fa fa-pause itemTooltip" aria-hidden="true" style="color: red"
                                           onclick="document.forms['formOff_{{ $w->id }}'].submit();"
                                           title="{{ trans('admin::shopping.warehouses.index.disable') }}"></i>
                                    </form>
                                @endif
                            @else
                                @if (Auth::action('warehouses.changeStatus'))
                                    <form name="formOn_{{ $w->id }}" method="POST" action="{{ route('admin.warehouses.changeStatus') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="code" value="{{ $w->warehouse }}"/>
                                        <input type="hidden" name="type" value="activate"/>
                                        <i class="fa fa-play itemTooltip" aria-hidden="true" style="color: green"
                                           onclick="document.forms['formOn_{{ $w->id }}'].submit();"
                                           title="{{ trans('admin::shopping.warehouses.index.enable') }}"></i>
                                    </form>
                                @endif
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('warehouses.edit'))
                                <a class="fa fa-pencil itemTooltip" href="{{ route('admin.warehouses.edit', ['id' => $w->id ]) }}"
                                   title="{{ trans('admin::shopping.warehouses.index.edit') }}" style="color: black"></a>
                            @endif
                        </div>
                        <div class="col-xs-4 text-center">
                            @if (Auth::action('warehouses.delete'))
                                <form name="formDel_{{ $w->id }}" method="POST" action="{{ route('admin.warehouses.destroy', ['code' => $w->warehouse ]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="code" value="{{ $w->warehouse }}"/>
                                    <i class="fa fa-trash itemTooltip" aria-hidden="true" data-id="{{ $w->id }}" data-element="{{ $w->warehouse }}" onclick="deleteElement(this)" title="{{ trans('admin::shopping.warehouses.index.delete') }}"></i>
                                </form>
                            @endif
                        </div>
                    </div>
                </td>
                {{-- @if ($can_edit || $can_delete) --}}
                {{--<td data-lid="{!! $oe->id !!}">
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
                </td>--}}
                {{-- @endif --}}

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">

    $('#warehouses').DataTable({
    "responsive": true,
            "ordering": false, "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
    });
    function deleteElement(element) {
        var id = $(element).data('id');
        var name = $(element).data('element');

        $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

        $('#confirm-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).one('click', '#delete', function(e) {
            document.forms['formDel_'+id].submit();
        });
    }
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

</script>
@stop