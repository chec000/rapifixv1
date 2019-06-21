<div class="row">

    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title" >{{trans('admin::shopping.customer.index.detail')}} </h3>
        </div>
        <p id="message_activated" role="alert">

        </p>
        <div class="box-body">
            <section class="invoice">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-shopping-cart"></i>
                            #{!! $customer['id'] !!}

                            <small class="pull-right"> {{trans('admin::shopping.customer.detail.ord_date')}}: {{ $customer['created_at'] }} </small>
                        </h2>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong><i class="fa fa-user"></i> {{ $customer['ca_number'] }}</strong><br>
                            <strong>{{trans('admin::shopping.customer.detail.phone')}}</strong>: {{ $customer['telephone'] }}<br>
                            <strong>{{trans('admin::shopping.customer.detail.cellphone')}}</strong>: {{ $customer['cell_number'] }}<br>
                            <strong>{{trans('admin::shopping.customer.detail.email')}}</strong>: {{ $customer['email'] }}<br>
                            <strong>{{trans('admin::shopping.customer.detail.birth')}}</strong>{{ $customer['birthdate'] }}<br>
                            <strong>{{trans('admin::shopping.customer.detail.gender')}}</strong>{{ $customer['gender'] }}<br>

                            
                            <div>
                            
                                <b>{{trans('admin::shopping.customer.detail.sponsor')}}:</b> {{ $customer['sponsor'] }} {{--$customer[''sponsor'] or ''--}}<br>
                                <b>{{trans('admin::shopping.customer.detail.sponsor_name')}} Name:</b> {{ $customer['sponsor_name'] }} {{--$customer[''sponsor_name'] or ''--}}<br>
                            </div>
                           
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong>
                                <i class="fa fa-home"></i>  {{ $customer['address'] }}, {{ $customer['number'] }}(<small> {{ $customer['complement'] }} </small>)<br>
                            <strong>{{trans('admin::shopping.customer.detail.suburb')}}</strong>{{ $customer['suburb'] }}, <strong>{{trans('admin::shopping.customer.detail.zip')}}</strong> {{ $customer['zip_code'] }}<br>
                            <strong>{{trans('admin::shopping.customer.detail.city')}}</strong>{{ $customer['city_name'] }}  ({{ $customer['city'] }})<br>
                            <strong>{{trans('admin::shopping.customer.detail.state')}}</strong>{{ $customer['state'] }} ({{ $customer->country->name}})<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">


                        <b>{{trans('admin::shopping.customer.detail.corbiz_transaction')}}:</b> {{ $customer['corbiz_transaction'] }} {{--$customer[''corbiz_transaction']--}} <br />
                        <b>{{trans('admin::shopping.customer.index.status')}}:</b> {{ $customer['status'] }} {{--$customer[''corbiz_transaction']--}} <br />

                    </div>
                    <!-- /.col -->
                </div>

               

              

              

                <!--Final modal log estatus-->
                <a class="btn btn-info btn-sm pull-right" style="color:#ffffff; text-decoration: none;" href="{{ route('admin.customers.list') }}"><i class="fa-arrow-circle-left fa"></i> {{trans('admin::shopping.customer.detail.go_back')}}</a></button>



            </section>
        </div>
        <div class="box-footer no-padding"></div>
    </div>



</div>









@section('scripts')
<script type="text/javascript">

</script>
@stop