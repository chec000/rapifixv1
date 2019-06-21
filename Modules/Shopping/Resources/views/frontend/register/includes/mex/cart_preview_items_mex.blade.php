
@foreach ($shoppingCart as $item)
    <li data-id="{{ $item['id'] }}" class="cart-product__item item-id-{{ $item['id'] }}">
        <figure class="cart-product__img"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></figure>
        <div class="cart-product__content">
            <div class="cart-product__top">
                <div class="cart-product__title">{{ $item['name'] }}</div>
                <div class="cart-product__code">@lang('shopping::checkout.quotation.resume_cart.code'): {{ $item['sku'] }}</div>
                @if(!(isset($item['promo']) && $item['promo']))
                    @if(!(isset($item['is_special']) && $item['is_special']))
                        @if(!(isset($item['iskit']) && $item['iskit']))
                            <div class="bin">
                                <figure class="icon-btn icon-bin"><img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="Eliminar"></figure>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="cart-product__bottom">
                <div class="form-group numeric">
                    <input class="form-control" {{ ((isset($item['promo']) && $item['promo']) || (isset($item['is_special']) && $item['is_special']) || (isset($item['iskit']) && $item['iskit'])) ? 'readonly' : '' }}
                    type="numeric" name="qty#{val}" value="{{ $item['quantity'] }}" min="0" max="9999" onkeypress="return esNumero(event)">
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

