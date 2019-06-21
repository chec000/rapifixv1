<div class="row">

    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title" >{{trans('admin::shopping.orders.index.list_orders_logs')}} </h3>
        </div>
        <p id="message_activated" role="alert">

        </p>
        <div class="box-body">
            <section class="invoice">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-shopping-cart"></i>
                            #{!! $order['order_number'] !!}
                            @if($order['shop_type'] == 'INSCRIPTION')
                                <span>(Inscription)</span>
                            @endif
                            <small class="pull-right"> {{trans('admin::shopping.orders.detail.ord_date')}}: {{ $order['created_at'] }} </small>
                        </h2>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong><i class="fa fa-user"></i> {{ $order['distributor_number'] }}</strong><br>
                            <strong>{{trans('admin::shopping.orders.detail.phone')}}</strong>: {{ $shipping_address['telephone'] }}<br>
                            <strong>{{trans('admin::shopping.orders.detail.email')}}</strong>: {{ $shipping_address['email'] }}<br>
                            @if($order['shop_type'] == 'INSCRIPTION')
                            <div>
                                @if($order->country->corbiz_key == "BRA")
                                CPF: {{ $shipping_address['cpf'] }} {{--$order[''cpf'] or ''--}}<br><br>
                                @endif
                                <b>{{trans('admin::shopping.orders.detail.sponsor')}}:</b> {{ $shipping_address['sponsor'] }} {{--$order[''sponsor'] or ''--}}<br>
                                <b>{{trans('admin::shopping.orders.detail.sponsor_name')}} Name:</b> {{ $shipping_address['sponsor_name'] }} {{--$order[''sponsor_name'] or ''--}}<br>
                            </div>
                            @endif
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>
                            <i class="fa fa-truck"></i> {{ $shipping_address['type_address'] }}</strong><br>
                            <i class="fa fa-home"></i>  {{ $shipping_address['address'] }}, {{ $shipping_address['number'] }}(<small> {{ $shipping_address['complement'] }} </small>)<br>
                            <strong>{{trans('admin::shopping.orders.detail.suburb')}}</strong>{{ $shipping_address['suburb'] }}, <strong>{{trans('admin::shopping.orders.detail.zip')}}</strong> {{ $shipping_address['zip_code'] }}<br>
                            <strong>{{trans('admin::shopping.orders.detail.city')}}</strong>{{ $shipping_address['city_name'] }}  ({{ $shipping_address['city'] }})<br>
                            <strong>{{trans('admin::shopping.orders.detail.state')}}</strong>{{ $shipping_address['state'] }} ({{ $order->country->name}})<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>{{trans('admin::shopping.orders.detail.corbiz_order')}}#{{ $order['corbiz_order'] }} {{--$order[''corbiz_order']--}}</b><br>
                        <!-- <br> -->

                        <b>{{trans('admin::shopping.orders.detail.oid')}}:</b> {{ $order['id'] }} {{--$order[''id_order']--}}<br>
                        <b>{{trans('admin::shopping.orders.detail.status')}}:</b> {{ $order->estatus->name }} {{--$order[''estatus']--}}<br>
                        <b>{{trans('admin::shopping.orders.detail.points')}}:</b> {{ $order['points'] }} {{--$order[''points']--}}<br />
                        <b>{{trans('admin::shopping.orders.detail.corbiz_transaction')}}:</b> {{ $order['corbiz_transaction'] }} {{--$order[''corbiz_transaction']--}} <br />
                        @if(!empty($order['bank_transaction']))
                        <b>{{trans('admin::shopping.orders.detail.bank_transaction')}}:</b> {{ $order['bank_transaction'] }} {{--$order[''bank_transaction']--}}
                        @endif
                        @if(!empty($order['bank_authorization']))
                        <b>{{trans('admin::shopping.orders.detail.bank_auth')}}:</b> {{ $order['bank_authorization'] }} {{--$order[''bank_transaction']--}}
                        @endif
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{trans('admin::shopping.orders.detail.id')}}</th>
                                <th>{{trans('admin::shopping.orders.detail.log_date')}}</th>
                                <th>{{trans('admin::shopping.orders.detail.status')}}</th>

                            </tr>
                            </thead>
                            <tbody>

                               @foreach($history as $oh)
                                   <tr>
                                       <td>{{$oh->id}}</td>
                                       <td>{{$oh->created_at}}</td>
                                       <td>{{$oh->estatus->name}}</td>
                                   </tr>


                                @endforeach




                            </tbody>
                        </table>
                    </div>
                </div>




                <a class="btn btn-info btn-sm pull-right" style="color:#ffffff; text-decoration: none;" href="{{ url()->previous() }}"><i class="fa-arrow-circle-left fa"></i> {{trans('admin::shopping.orders.detail.go_back')}}</a></button>



            </section>
        </div>
        <div class="box-footer no-padding"></div>
    </div>



</div>









@section('scripts')
<script type="text/javascript">

    /* $('#tbl_order').DataTable({
    "responsive": true,
     "ordering": true

    }); */


    $(document).ready(function() {

    } );





</script>
@stop