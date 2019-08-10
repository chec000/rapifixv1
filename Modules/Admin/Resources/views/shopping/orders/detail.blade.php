<div class="row">

    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title" >@lang('admin::shopping.orders.index.list_orders_detail')</h3>
        </div>
        <p id="message_activated" role="alert">

        </p>
        <div class="box-body">
            <section class="invoice">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-shopping-cart"></i>
                            #{{$order['order_number']}}

                            @if(strtoupper($order['shop_type']) == 'INSCRIPTION')
                                <span>@lang('admin::shopping.orders.index.inscription')</span>
                            @endif
                            <small class="pull-right">@lang('admin::shopping.orders.detail.ord_date'): {{$order['created_at']}}</small>
                        </h2>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address>
                            <strong><i class="fa fa-user"></i> {{$order['distributor_number']}}</strong><br>
                            <strong>@lang('admin::shopping.orders.detail.phone')</strong>: {{$shipping_address['telephone']}}<br>
                            <strong>@lang('admin::shopping.orders.detail.cellphone')</strong>: {{$shipping_address['cellphone']}}<br>
                            <strong>@lang('admin::shopping.orders.detail.email')</strong>: {{$shipping_address['email']}}<br>
                            
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <address>                                                      
                            <i class="fa fa-home"></i>  {{$shipping_address['address']}}, {{$shipping_address['number']}}(<small>{{$shipping_address['complement']}}</small>)<br>
                            <strong>@lang('admin::shopping.orders.detail.suburb')</strong> {{$shipping_address['suburb']}}, <strong>@lang('admin::shopping.orders.detail.zip')</strong> {{$shipping_address['zip_code']}}<br>
                            <strong>@lang('admin::shopping.orders.detail.city')</strong> {{$shipping_address['city_name']}} ({{$shipping_address['city']}})<br>
                            <strong>@lang('admin::shopping.orders.detail.state')</strong> {{$shipping_address['state']}} ({{$order->country->name}})<br>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>@lang('admin::shopping.orders.detail.order') : #{{$order['order_number']}}</b><br>
                        <!-- <br> -->

                        <b>@lang('admin::shopping.orders.detail.oid'):</b> {{$order['id']}}{{--$order[''id_order']--}}<br>
                        
                        <b>@lang('admin::shopping.orders.detail.points'):</b> {{$order['points']}}{{--$order[''points']--}}<br />
                        
                    @if(!empty($order['bank_transaction']))
                        <b>@lang('admin::shopping.orders.detail.bank_transaction'):</b> {{$order['bank_transaction']}}{{--$order[''bank_transaction']--}}
                    @endif
                    @if(!empty($order['bank_authorization']))
                        <b>@lang('admin::shopping.orders.detail.bank_auth'):</b> {{$order['bank_authorization']}}{{--$order[''bank_transaction']--}}
                    @endif
                    </div>
                    <!-- /.col -->
                </div>

                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>@lang('admin::shopping.orders.detail.qty')</th>
                                <th>@lang('admin::shopping.orders.detail.product')</th>
                                <th>@lang('admin::shopping.orders.detail.sku')</th>
                                <th>@lang('admin::shopping.orders.detail.description')</th>
                                <th>@lang('admin::shopping.orders.detail.points')</th>
                                <th>@lang('admin::shopping.orders.detail.subtotal')</th>
                                <th>@lang('admin::shopping.orders.detail.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderdetail as $od)

                                @php
                                    $active = $od->active;
                                        switch ($active){
                                                case 1 :
                                                //caso de producto normal sin cambios
                                                    $visibledel = 'display:block';
                                                    $visiblerea = 'display:none';
                                                    $color = '';
                                                break;
                                                case -1 :
                                                //caso de producto eliminado
                                                    $visibledel = 'display:none';
                                                    $visiblerea = 'display:block';
                                                    $color = 'alert alert-danger';
                                                break;
                                                case 2 :
                                                //caso de producto nuevo
                                                    $visibledel = 'display:block';
                                                    $visiblerea = 'display:none';
                                                    $color = 'alert alert-success';
                                                break;
                                                default :
                                                    $visibledel = 'display:block';
                                                    $visiblerea = 'display:none';
                                                    $color = '';
                                        }
                                @endphp

                                <tr class="row_{{$od->id}} {{$color}}">
                                    <td>{{$od->quantity}}</td>
                                    @if($od->is_promo == 1 && $od->promo_prod_id != 0)
                                        <td>{{$od->productSkuPromo->name}}</td>
                                        <td>{{$od->productSkuPromo->clv_producto}}</td>
                                        <td>{{$od->productSkuPromo->description}}</td>
                                    @elseif(($od->is_promo == 1 && $od->promo_prod_id == 0) || $od->is_special == 1)
                                        <td>{{$od->product_name}}</td>
                                        <td>{{$od->product_code}}</td>
                                        <td>{{$od->product_name}}</td>
                                    @else
                                        <td>{{!empty($od->countryProduct->name) ? $od->countryProduct->name : $od->products->global_name}}</td>
                                        <td>{{!empty($od->countryProduct->name) ? $od->countryProduct->product->sku : $od->products->sku}}</td>
                                        <td>{{!empty($od->countryProduct->name) ? $od->countryProduct->description : $od->products->global_name}}</td>
                                    @endif
                                    <td>{{$od->points}}</td>
                                    <td>${{number_format($od->final_price,2)}}</td>
                                    @if($can_delete)
                                    <td>
                                        <span class="label label-success" id="item_{{$od->id}}" style="display: none;">@lang('admin::shopping.orders.detail.added')</span>
                                          <button id="del_{{$od->id}}" type="button" class="btn btn-danger" style="padding: 0 5px; {{$visibledel}}" onclick="removeProductList('{{$od->order_id}}','{{$od->id}}')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>

                                            <button id="act_{{$od->id}}" type="button" class="btn btn-warning" style="padding: 0 5px; {{$visiblerea}}" onclick="restoreProductList('{{$od->order_id}}','{{$od->id}}')">
                                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                            </button>

                                    </td>
                                    @endif
                                </tr>
                           
                            @endforeach


                            </tbody>
                        </table>
                      
                    </div>
                </div>

                <div class="row">
                    <!-- accepted payments column -->
    
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody><tr>
                                    <th style="width:50%">@lang('admin::shopping.orders.detail.subtotal'):</th>
                                    <td>${{number_format($order['total'] - $order['total_taxes'],2)}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('admin::shopping.orders.detail.tax')</th>
                                    <td>${{number_format($order['total_taxes'],2)}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('admin::shopping.orders.detail.points'):</th>
                                    <td>{{$order['points']}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('admin::shopping.orders.detail.total'):</th>
                                    <td>${{number_format($order['total'],2)}}</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>

                <!--Modal log estatus-->

                <div class="modal" tabindex="-1" role="dialog" id="logsModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">


                                <div class="modal-header">

                                    <h2>@lang('admin::shopping.orders.detail.logs')</h2>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h2 class="page-header">
                                                <i class="fa fa-shopping-cart"></i>
                                                #{{$order['order_number']}}
                                                @if($order['shop_type'] == 'INSCRIPTION')
                                                    <span>(Inscription)</span>
                                                @endif
                                                <small class="pull-right">@lang('admin::shopping.orders.detail.ord_date'): {{$order['created_at']}}</small>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" id="log">


                                    <section class="invoice">

                                        <div class="row">
                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>@lang('admin::shopping.orders.detail.id')</th>
                                                        <th>@lang('admin::shopping.orders.detail.log_date')</th>
                                                        <th>@lang('admin::shopping.orders.detail.status')</th>
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

                                 </section>


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >@lang('admin::shopping.registrationreferences.index.close')</button>


                                </div>

                        </div>
                    </div>
                </div>

                <!--Final modal log estatus-->
                <a class="btn btn-info btn-sm pull-right" style="color:#ffffff; text-decoration: none;" href="{{route('admin.orders.list')}}"><i class="fa-arrow-circle-left fa"></i> @lang('admin::shopping.orders.detail.go_back')</a></button>



            </section>
        </div>
        <div class="box-footer no-padding"></div>
    </div>



</div>









@section('scripts')
<script type="text/javascript">

    $("#showlog").click(function () {
        $("#logsModal").modal('show');
    })


    var translations = {
        errorQuantity:                  '{{trans("admin::shopping.orders.detail.empty-qty")}}',
        errorProd:                      '{{trans("admin::shopping.orders.detail.empty-prod")}}',
        productSaved:                   '{{trans("admin::shopping.orders.detail.product-saved")}}',
        errorSavingProduct:             '{{trans("admin::shopping.orders.detail.product-error-saving")}}',

    }





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

    function removeProductList(order_id,id_item){

        $.ajax({
            url: route('admin.orders.remove'),
            type: 'POST',
            data: {order_id: order_id,item:id_item},
            success: function (data) {

                if(data.status){
                    $("#del_"+id_item).hide();
                    $("#act_"+id_item).show();
                    $(".row_"+id_item).addClass("alert alert-danger !important");
                    $(".row_"+id_item).css("text-decoration","line-through");
                }else{
                    $("#message_activated").addClass('alert alert-danger');
                    $("#message_activated").html(data.message);
                }

            }
        });









    }


    function restoreProductList(order_id,id_item){


        $.ajax({
            url: route('admin.orders.remove'),
            type: 'POST',
            data: {order_id: order_id,item:id_item},
            success: function (data) {

                if(data.status){
                    $("#del_"+id_item).show();
                    $("#act_"+id_item).hide();
                    $(".row_"+id_item).removeClass("alert alert-danger !important");
                    $(".row_"+id_item).css("text-decoration","none");
                }else{
                    $("#message_activated").addClass('alert alert-danger');
                    $("#message_activated").html(data.message);
                }

            }
        });







    }



    function addListProduct(allProduct){
        var idProd = $("#prod_sel").val();
        var qty = parseInt($("#cant_prod").val());
        var price = parseFloat($("#price_"+idProd).html());
        var subtotal = qty * price;
        var points = parseInt($("#points_"+idProd).html());

        //var subtotal = parseFloat();
        //console.log(idProd);
        if(qty > 0){
            if(idProd != ""){

                // Se oculta el producto seleccionado del select
                $("#opt_"+idProd).hide();
                // Se cambia el de elemento el select
                $("#prod_sel").val("");
                // Se muestra en la tabla el producto agregado
                $("#prods_added_"+idProd).show();
                // Se guarda el producto agregado en el json.
                //se coloca la cantidad seleccionada
                $("#quantity_"+idProd).html(qty);

                $("#subtotal_"+idProd).html('$'+subtotal.toFixed(2));
                this.saveProduct(idProd,allProduct,qty,subtotal,points);
            }else {
                // Se muestra mensaje de error
                bootbox.alert(translations.errorProd);

            }
        }
        else {
            // Se muestra mensaje de error
            bootbox.alert(translations.errorQuantity);

        }


    }

    function saveProduct(idProd,allProduct,qty,subtotal,points)
    {

        var prodSelect = "#productsnew";

        // Se recorre el array para guardar el producto seleccionado
        allProduct.forEach(function(element) {

            var ar = [];

            if(element.product_id == idProd){
                // Se optiene la informacion del input
                var prodJson = $(prodSelect).val();
                // Se valida que no este vacio para agregar los elementos al array
                if(prodJson != ""){
                    var obj = jQuery.parseJSON(prodJson);
                    ar = obj;
                }
                // se crea el objecto para agregarlo al array
                var productAdd = new Object();
                productAdd.product_id = element.product_id;
                productAdd.qty = qty;
                productAdd.price = subtotal;
                productAdd.points = points;



                // Se agrega el producto al arrays
                ar.push(productAdd);
                // Se inserta en el input para su envio
                $(prodSelect).val(JSON.stringify(ar));

            }
        });


        activeButton();





    }

    function delProduct(idProd)
    {
        var prodSelect = "#productsnew";
        var obj = jQuery.parseJSON($(prodSelect).val());

        obj.forEach(function(element, index) {
            if(element.product_id == idProd){
                obj.splice(index,1);
            }
        });
        if(obj.length == 0){
            $(prodSelect).val("")
        }else {
            $(prodSelect).val(JSON.stringify(obj))
        }
        $("#prods_added_"+idProd).hide();
        $("#opt_"+idProd).show();
        activeButton();
    }

    function activeButton(){
        var products = $("#productsnew").val();

        if(products){
            $("#actOrdBtn").removeAttr('disabled');
        }else{
            $("#actOrdBtn").attr('disabled','disabled');
        }


    }

    function saveChanges(){
        var products = $("#productsnew").val();
        if(products){
            var jsonProduct        = {};
            jsonProduct.id         = $("#orderid").val();
            jsonProduct.products  =  products;
            $.ajax({
                type: "POST",
                url: "{{ route('admin.orders.savenew') }}",
                data: jsonProduct,
                success: function (data){
                   bootbox.alert({
                        message: translations.productSaved,
                        callback: function(){
                            location.reload();
                        }
                    });

                },
                error:function(data){
                    bootbox.alert(translations.errorSavingProduct);
                },
            });
        }
    }



</script>
@stop