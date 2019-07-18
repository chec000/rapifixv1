<div class="shopping-cart float-lg-right d-flex justify-content-start" id="shopping-cart">
    <div class="cart-icon">
        <a href="cart.html"><img src="assets/images/icon-topcart.png" class="img-fluid" alt=""></a>
    </div>
    <div class="cart-content" id="shopping-cart">
        <h2><span class="fa fa-shopping-cart" onmouseover="showCart()"> <span>
                @if($cart['items']!=null)
            <span id="cartStatus" style="display: none;">
                (Empty)

                @endif
        </span>
    </span>
                </a>
</h2>
    </div>


    <div class="cart-floating-box" id="cart-floating-box">
        <div class="cart-items">
            @if($cart['items']!=null)
                @foreach($cart['items'] as $p)
                    <div data-id="{{$p['id']}}" class="cart-float-single-item d-flex">
                        <span class="remove-item" onclick="ShoppingCart.remove_all_from_item({{$p['id']}})"><i class="fa fa-trash"></i></span>
                        <div class="cart-float-single-item-image">
                            <img src="{{$p['image']}}" class="img-fluid" alt="">

                        </div>
                        <div class="cart-float-single-item-desc item-id-{{$p['id']}}">
                            <span class="product-title">
                                <span class="count">{{$p['quantity']}}
                                X
                                 {{$p['name']}}   
                            </span>
                            </span>
                            <input class="form-control" style="width: 34px" type="text" value="{{$p['quantity']}}" name="product-{{$p['id']}}"onkeypress="return isNumeric(event)" 
                            >

                            <p class="size"> <a href="shop-left-sidebar.html"></a></p>
                            <p class="price" >{{$p['price']}}</p>
                        </div>
                    </div>


                @endforeach

            @endif

        </div>

            <div class="cart-calculation d-flex">
                <div class="calculation-details">
                   <!--
                    <p class="shipping">Shipping <span>$2</span></p>
                   -->
                    <p class="total">Total <span id="subtotal">${{$cart['subtotal']}}</span></p>
                </div>
                <div class="checkout-button">
                    <a href="{{route('cart.list')}}">Checkout</a>
                </div>
            </div>
        </div>

        <!-- end of shopping cart -->
    </div>
</div>
