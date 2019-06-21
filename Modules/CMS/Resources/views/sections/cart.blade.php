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
        <ul id="cart-list" class="cart-product__list list-nostyle">
            @if (isset($shoppingCart) && sizeof($shoppingCart) > 0)
                @foreach ($shoppingCart as $item)
                    <li data-id="{{ $item['id'] }}" class="cart-product__item">
                        <figure class="cart-product__img"><img src="{{ $item['image'] }}" alt=""></figure>
                        <div class="cart-product__content">
                            <div class="cart-product__top">
                                <div class="cart-product__title">{{ $item['name'] }}</div>
                                <div class="cart-product__code">@lang('cms::cart_aside.code'): {{ $item['sku'] }}</div>
                                <div class="bin">
                                    <figure class="icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="Eliminar"></figure>
                                </div>
                            </div>
                            <div class="cart-product__bottom">
                                <div class="form-group numeric">
                                <span class="minus s r">
                                    <svg height="14" width="14">
                                        <line x1="0" y1="8" x2="14" y2="8"></line>
                                    </svg>
                                </span>
                                    <input class="form-control" type="numeric" name="qty#{val}" value="{{ $item['quantity'] }}">
                                    <span class="plus s r">
                                    <svg height="14" width="14">
                                        <line x1="0" y1="7" x2="14" y2="7"></line>
                                        <line x1="7" y1="0" x2="7" y2="14"></line>
                                    </svg>
                                </span>
                                </div>
                                <div class="cart-product__nums">
                                    <div class="cart-product__pts">{{ $item['points'] }} @lang('cms::cart_aside.pts')</div>
                                    <div class="cart-product__price">x {{ currency_format($item['price'], $currency) }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            @else
                <li id="cart-empty" style="text-align: center; margin-top: 50px;">No se han agregado productos al carrito</li>
            @endif
        </ul>

        <div id="cart-resume" style="{{ $style }}" class="cart-preview__resume list-nostyle js-empty-cart">
            <li id="subtotal">@lang('cms::cart_aside.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
            <li id="points">@lang('cms::cart_aside.points'): {{ isset($points) ? $points : '0000' }}</li>
            <li id="total" class="total">@lang('cms::cart_aside.total'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
        </div>

        <footer class="cart-preview__footer">
            <a id="cart-finish" class="js-empty-cart" style="{{ $style }}" href="carrito.html"><button class="button default" type="button">@lang('cms::cart_aside.checkout_button')</button></a>
            <a href="detalle.html"><button class="button transparent" type="button">@lang('cms::cart_aside.continue_shopping')</button></a>
        </footer>
    </div>
</div>
<!-- end cart preview-->