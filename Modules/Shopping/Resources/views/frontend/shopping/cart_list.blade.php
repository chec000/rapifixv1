
{!! PageBuilder::section('head', [
'categories' => $categories,
'cart'=>$cart
]) !!}

<div class="page-content mt-50 mb-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h2>Carrito</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-40">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Imagen</th>
                                    <th class="pro-title">Producto</th>
                                    <th class="pro-price">Precio</th>
                                    <th class="pro-quantity">Cantidad</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cart['items']!=null)
                                @foreach($cart['items'] as $p)
                                <tr>
                                    <td class="pro-thumbnail">
                                        <img class="img-fluid" src="{{$p['image']}}" alt="Product"></td>
                                        <td class="pro-title">{{$p['name']}}
                                        </td>

                                        <td class="pro-price"><span>${{$p['price']}}</span></td>
                                        <td class="pro-quantity">
                                                          <!--
                                                            <span class="pro-qty-cart counter"><a href="#" class="dec qty-btn-cart"><i class="fa fa-minus"></i></a><input type="text" value="{{$p['quantity']}}" class="mr-5">
                                                            -->
                                                            <span>{{$p['quantity']}}</span>
                                                        <!--
                                                                <a href="#" class="inc qty-btn-cart"><i class="fa fa-plus"></i></a></span>
                                                            -->
                                                        </td>
                                                        <td class="pro-subtotal"><span>${{$p['price']*$p['quantity']}}</span></td>
                                                        <td class="pro-remove">
                                                            <span onclick="ShoppingCart.remove_all_from_item({{$p['id']}})">

                                                                <i class="fa fa-trash-o"></i>
                                                            </span>


                                                        </td>
                                                    </tr>

                                                    @endforeach
                                                    @endif                                            
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>

                                    <div class="row">

                                        <div class="col-lg-6 col-12 mb-15">
                                            <!-- Calculate Shipping -->
                                            <div class="calculate-shipping">
                                                <h4>Calculate Shipping</h4>
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <select class="nice-select">
                                                                <option>Bangladesh</option>
                                                                <option>China</option>
                                                                <option>country</option>
                                                                <option>India</option>
                                                                <option>Japan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <select class="nice-select">
                                                                <option>Dhaka</option>
                                                                <option>Barisal</option>
                                                                <option>Khulna</option>
                                                                <option>Comilla</option>
                                                                <option>Chittagong</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <input type="text" placeholder="Postcode / Zip">
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <input type="submit" value="Estimate">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Discount Coupon -->
                                            <div class="discount-coupon">
                                                <h4>Discount Coupon Code</h4>
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <input type="text" placeholder="Coupon Code">
                                                        </div>
                                                        <div class="col-md-6 col-12 mb-25">
                                                            <input type="submit" value="Apply Code">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Cart Summary -->
                                        <div class="col-lg-6 col-12 mb-40 d-flex">
                                            <div class="cart-summary">
                                                <div class="cart-summary-wrap">
                                                    <h4>Resumen de compra</h4>
                                                    <p>Sub Total <span>${{$cart['subtotal']}}</span></p>

                                                    <h2>Total 
                                                        <span>${{$cart['subtotal']}}</span></h2>
                                                    </div>
                                                    <div class="cart-summary-button">

                                                        <a href="{{route('cart.report')}}" >
                                                            <button class="checkout-btn">Imprimir</button>

                                                        </a>

                                                        <button class="update-btn">Update Cart</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>




                        {!! PageBuilder::section('footer',[
                        'categories' => $categories
                        ]) !!}
