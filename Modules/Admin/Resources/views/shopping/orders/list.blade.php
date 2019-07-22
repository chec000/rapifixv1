<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.orders.index.list_orders') }}</h1>
    </div>


</div>


    <p id="message_activated" role="alert">

    </p>



<div class="table">

    <table class="table table-striped table-hover dt-responsive" id="tbl_order">
        <thead>
            <tr>
                <th class="select-filter">{{ trans('admin::shopping.orders.index.countries') }}</th>
                <th class="select-filter">{{ trans('admin::shopping.orders.index.order_number') }}</th>                             
               
                <th>{{ trans('admin::shopping.orders.index.date_created') }}</th>

                @if ($can_edit || $can_delete)
                    <th>{{ trans('admin::shopping.orders.index.actions') }}</th>
                @endif
            </tr>


        </thead>
        <tbody>


        @foreach ($orders as $or)
            <tr id="lang_{!! $or->id !!}">
                <td>{!! $or->country->name !!}</td>
                <td>{!! $or->order_number !!}</td>
                <td>{!! $or->created_at !!}</td>


                @if ($can_edit)

                    <td data-lid="{!! $or->id !!}">
                        <a class="glyphicon glyphicon-eye-open itemTooltip" href="{{ route('admin.orders.detail', ['oe_id' => $or->id]) }}" title="{{ trans('admin::shopping.orders.index.detail') }}"></a>
                               <span onclick="changeOrderStatus({{$or->id}})" id='activeOrderEstatus{{$or->id}}'>
                            <i class="glyphicon glyphicon-check itemTooltip" style="color:green;" title="{{ trans('admin::shopping.orders.index.activate') }}"></i>
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

    /* $('#tbl_order').DataTable({
    "responsive": true,
     "ordering": true

    }); */

    var translations  = {
            0:           '{{ trans("admin::shopping.orders.detail.chooseoption.0") }}',
            1:           '{{ trans("admin::shopping.orders.detail.chooseoption.1") }}',
            2:           '{{ trans("admin::shopping.orders.detail.chooseoption.2") }}',
            3:           '{{ trans("admin::shopping.orders.detail.chooseoption.3") }}',
            4:           '{{ trans("admin::shopping.orders.detail.chooseoption.4") }}',
            5:           '{{ trans("admin::shopping.orders.detail.chooseoption.5") }}',
            6:           '{{ trans("admin::shopping.orders.detail.chooseoption.6") }}',
    }


    $(document).ready(function() {

        $('#tbl_order').DataTable( {
            "responsive": true,
            "ordering" : true,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }





                initComplete: function () {
                this.api().columns('.select-filter').every( function (index) {
                    var pos  = index;
                    var column = this;

                    console.log(translations[0]);
                    var select = $('<select><option value="">'+translations[pos]+'</option></select>')
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
    } );


    function changeOrderStatus(order_id) {
        $.ajax({
            url: route('admin.orders.active'),
            type: 'POST',
            data: {order_id: order_id},
            success: function (data) {

                if(data.status){
                    $("#message_activated").addClass('alert alert-success');
                    $("#message_activated").html(data.message);
                    setTimeout(function(){ location.reload(); }, 1000);
                }else{
                    $("#message_activated").addClass('alert alert-danger');
                    $("#message_activated").html(data.message);
                }

            }
        });
    }



</script>
@stop