@if (isset($shoppingCart) && sizeof($shoppingCart) > 0)
    @foreach ($shoppingCart as $item)
        <li data-id="{{ $item['id'] }}" class="cart-product__item item-id-{{ $item['id'] }}">
            <figure class="cart-product__img"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></figure>
            <div class="cart-product__content">
                <div class="cart-product__top">
                    <div class="cart-product__title">{{ $item['name'] }}</div>
                    <div class="cart-product__code">@lang('shopping::checkout.quotation.resume_cart.code'): {{ $item['sku'] }}</div>
                    @if(!(isset($item['promo']) && $item['promo']))
                        @if(!(isset($item['is_special']) && $item['is_special']))
                    <div class="bin">
                        <figure class="icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="Eliminar"
                           onclick="removeResumeCartItem('input{{ $item['sku'] }}')"></figure>
                    </div>
                        @endif
                    @endif
                </div>
                <div class="cart-product__bottom">
                    <div class="form-group numeric">
                        <input id="input{{ $item['sku'] }}" class="form-control" {{ ((isset($item['promo']) && $item['promo']) || (isset($item['is_special']) && $item['is_special'])) ? 'readonly' : '' }}
                        type="numeric" name="qty#{val}" value="{{ $item['quantity'] }}" onchange="changeQtyResumeCart(this)">
                    </div>
                    <div class="cart-product__nums">
                        <div class="cart-product__pts">{{ $item['points'] }} @lang('shopping::checkout.quotation.resume_cart.pts')</div>
                        @if(isset($item['price']))
                            <div class="cart-product__price">x {{ currency_format($item['price'], $currency) }}</div>
                        @elseif(isset($item['listPrice']))
                            <div class="cart-product__price">x {{ currency_format($item['discPrice'], $currency) }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@else
    <li id="cart-empty" style="text-align: center; margin-top: 50px;" class="cart-empty">@lang('shopping::checkout.quotation.resume_cart.no_items')</li>
@endif
