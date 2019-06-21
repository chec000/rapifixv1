<div class="cart-preview fade-in-down cart__right cart__right" id="cart-preview">
    <button class="icon-btn icon-cross close_cross" type="button"></button>

    <div class="cart-preview__head">
    <!-- p>@lang('shopping::register.kit.bill.resume')</p -->
    </div>
    <img class="bag_cart hide_cart_icon" src="{{asset('/themes/omnilife2018/images/shopping-icon-pre.svg')}}" alt="" style="max-width:30%;margin:0 auto;padding-top:.5em;">

    <div class="cart-preview__content hide hidden">
        <div id="divResumeQuotationErrors" style="width: 100%">
            @include("shopping::frontend.register.includes.resume_quotation_errors")
        </div>
        <ul id="cart-list" class="cart-product__list list-nostyle  cart-list">

        </ul>
    </div>
    <div id="cart-resume" class="cart-preview__resume list-nostyle js-empty-cart hide hidden">
        <li id="subtotal" class="subtotal_checkout">@lang('cms::cart_aside.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
        <li id="points" class="points_checkout">@lang('cms::cart_aside.points'): {{ isset($points) ? $points : '0000' }}</li>
        <li id="total" class="total total_checkout">@lang('cms::cart_aside.total'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
    </div>
</div>

<div class="cart-preview-mov z_onclose" id="cart-preview-mov">
    <div class="cart-preview__head">
        <p>@lang('shopping::register.kit.bill.shopping_cart')</p>
    </div>
    <div class="cart-preview__resume list-nostyle">
        <li class="points_mov">@lang('shopping::register.kit.bill.points'): 0000</li>
        <li class="total_mov">@lang('shopping::register.kit.bill.total'): $00.00</li>
    </div>
</div>
