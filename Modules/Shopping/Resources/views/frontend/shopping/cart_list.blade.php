<div class="cart-floating-box" id="cart-floating-box">
    <div class="cart-items">
        @if($cart['items']!=null)
            @foreach($cart['items'] as $p)
                <div class="cart-float-single-item d-flex" data.id='{{$p->id}}'>
                    <span class="remove-item" onclick="ShoppingCart.remove_one({{$p->id}})"><i class="fa fa-trash"></i></span>
                    <div class="cart-float-single-item-image">
                        <img src="{{$p['image']}}" class="img-fluid" alt="">

                    </div>
                    <div class="cart-float-single-item-desc">
                        <p class="product-title"><span class="count">{{$p['quantity']}}X</span>
                            <a href="single-product-variable.html">
                                {{$p['name']}}
                            </a></p>
                        <p class="size"> <a href="shop-left-sidebar.html">
                            
                        </a></p>
                        <p class="price" id="subtotal">{{$p['price']}}</p>
                    </div>
                </div>


            @endforeach

        @endif

    </div>

    <div class="cart-calculation d-flex">
        <div class="calculation-details">
           
             <p class="shipping">SubTotal <span id="subtotal">$2</span></p>
            
            <p class="total">Total <span id="total">${{$cart['subtotal']}}</span></p>
        </div>
        <div class="checkout-button">
            <a href="checkout.html">Checkout</a>
        </div>
    </div>
</div>
