@php
    $style = (isset($shoppingCart) && sizeof($shoppingCart) > 0) ? '' : 'display: none';
@endphp

<!-- cart preview-->
<div class="cart-preview aside">
    <div class="cart-preview__head">
        <p>@lang('cms::cart_aside.head')</p>
        <button class="icon-btn icon-cross close" type="button"></button>
        <p id="cart-remove-all" class="remove-all js-empty-cart" style="{{ $style }}"><a onclick="ShoppingCart.remove_all()" href="javascript:;">@lang('cms::cart_aside.remove_all')</a></p>
    </div>

    <div class="cart-preview__content">
        @if (session()->exists('delete-items'))
            <div class="error__box theme__transparent" style="display: inline-block; font-size: 0.85em; padding: 10px; margin: 0 auto;width: 100%;text-align: center;border: 2px solid #fcb219;">
                <ul style="list-style: none; padding: 0px;">
                    <li>{{ session()->get('delete-items') }}</li>
                </ul>
            </div>
        @endif



        <div id="cart-resume" style="{{ $style }}" class="cart-preview__resume list-nostyle js-empty-cart">
            <li id="subtotal" class="subtotal_checkout">@lang('cms::cart_aside.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
            <li id="points" class="points_checkout">@lang('cms::cart_aside.points'): {{ isset($points) ? $points : '0000' }}</li>
            <li id="total" class="total total_checkout">@lang('cms::cart_aside.total'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
        </div>

        <footer class="cart-preview__footer">
            <a id="cart-finish" class="js-empty-cart" style="{{ $style }}" href="{{ route('checkout.index') }}"><button class="button default" type="button">@lang('cms::cart_aside.checkout_button')</button></a>
            <a href="{{session()->get('portal.main.brand.domain')}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}"><button class="button transparent" type="button">@lang('cms::cart_aside.continue_shopping')</button></a>
        </footer>
    </div>
</div>
<!-- end cart preview-->