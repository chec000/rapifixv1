<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.customer.index.list_orders') }}</h1>
    </div>


</div>


    <p id="message_activated" role="alert">

    </p>



<div class="table">


    <table class="table table-striped table-hover dt-responsive" id="tbl_customer">
        <thead>
            <tr>

                <th class="select-filter">{{ trans('admin::shopping.customer.index.country') }}</th>
                <th class="select-filter">{{ trans('admin::shopping.customer.index.sponsor') }}</th>
                <th >{{ trans('admin::shopping.customer.index.sponsor_name') }}</th>
                <th >{{ trans('admin::shopping.customer.index.customer_code') }}</th>
                <th>{{ trans('admin::shopping.customer.index.name') }}</th>
                <th>{{ trans('admin::shopping.customer.index.status') }}</th>
                <th>{{ trans('admin::shopping.customer.index.date_created') }}</th>
                <th>{{ trans('admin::shopping.customer.index.actions') }}</th>

            </tr>
        </thead>
        <tbody>
        @foreach ($customers as $cm)
            <tr id="lang_{!! $cm->id !!}">

                <td>{!! $cm->country->name !!}</td>
                <td>{!! $cm->sponsor !!}</td>
                <td>{!! $cm->sponsor_name !!}</td>
                <td>{!! $cm->ca_number !!}</td>
                <td>{!! $cm->ca_name !!}{{$cm->ca_lastname}}</td>
                <td>{!! $cm->status !!}</td>
                <td>{!! $cm->created_at !!}</td>
                <td><a class="glyphicon glyphicon-eye-open itemTooltip" href="{{ route('admin.customers.detail', ['cm_id' => $cm->id]) }}" title="{{ trans('admin::shopping.orders.index.detail') }}"></a></td>



            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>

            <th class="select-filter">{{ trans('admin::shopping.customer.index.country') }}</th>
            <th class="select-filter">{{ trans('admin::shopping.customer.index.sponsor') }}</th>
            <th>{{ trans('admin::shopping.customer.index.sponsor_name') }}</th>
            <th>{{ trans('admin::shopping.customer.index.customer_code') }}</th>
            <th>{{ trans('admin::shopping.customer.index.name') }}</th>
            <th>{{ trans('admin::shopping.customer.index.status') }}</th>
            <th>{{ trans('admin::shopping.customer.index.date_created') }}</th>
            <th>{{ trans('admin::shopping.customer.index.actions') }}</th>
        </tr>

        </tfoot>


    </table>
</div>
@section('scripts')
<script type="text/javascript">
        $('#tbl_customer').DataTable( {
            "responsive": true,
            "ordering" : true,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }, 
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



    var translations  = {
        0:           '{{ trans("admin::shopping.customer.detail.chooseoption.0") }}',
        1:           '{{ trans("admin::shopping.customer.detail.chooseoption.1") }}',
        2:           '{{ trans("admin::shopping.customer.detail.chooseoption.2") }}',
        3:           '{{ trans("admin::shopping.customer.detail.chooseoption.3") }}',
    }


    $(document).ready(function() {

    } );


    function changeOrderStatus(order_id) {
        $.ajax({
            url: route('admin.customer.active'),
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