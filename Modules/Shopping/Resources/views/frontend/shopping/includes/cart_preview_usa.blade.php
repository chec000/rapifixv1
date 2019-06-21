<div id="cart-preview" class="cart-preview fade-in-down cart__right">
    <div class="cart-preview__head">
        <p>@lang('cms::cart_aside.purchase_summary')</p>
        <button class="icon-btn icon-cross close" type="button"></button>
        <p id="cart-remove-all" class="remove-all js-empty-cart" style="display: inline-block"><a onclick="ResumeCart.remove_all()" href="javascript:;">@lang('shopping::checkout.quotation.resume_cart.remove_all')</a></p>
    </div>

    <div class="cart-preview__content">
        @if (session()->exists('delete-items'))
            <div class="error__box theme__transparent" style="display: inline-block; font-size: 0.85em; padding: 10px; margin: 0 auto;width: 100%;text-align: center;border: 2px solid #fcb219;">
                <ul style="list-style: none; padding: 0px;">
                    <li>{{ session()->get('delete-items') }}</li>
                </ul>
            </div>
        @endif
        @if (session()->exists('message-error-sw'))
            <div class="error__box">
                <span class="error__single">
                    <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                </span>
                <ul style="list-style: none; padding: 0px;">
                    <li>{{ session()->get('message-error-sw') }}</li>
                </ul>
            </div>
        @endif

        <ul id="cart-list" class="cart-product__list list-nostyle cart-list">
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
        </ul>
    </div>
    <div id="cart-resume" class="cart-preview__resume list-nostyle js-empty-cart">
        <li id="subtotal" class="subtotal_checkout">@lang('shopping::checkout.quotation.resume_cart.subtotal'): {{ isset($subtotal) ? $subtotal : '$00.00' }}</li>
        <li id="points" class="points_checkout">@lang('shopping::checkout.quotation.resume_cart.points'): {{ isset($points) ? $points : '0000' }}</li>
        @if(isset($handle))
            <li id="manage"class="manage_checkout">@lang('shopping::checkout.quotation.resume_cart.handling'): {{ isset($handle) ? $handle : '--' }} </li>
        @endif
        @if(isset($taxes))
            <li id="taxes" class="taxes_checkout">@lang('shopping::checkout.quotation.resume_cart.taxes'): {{ isset($taxes) ? $taxes : '--' }}</li>
        @endif
        <li id="total" class="total total_checkout">@lang('shopping::checkout.quotation.resume_cart.total'): {{ isset($total) ? $total : $subtotal }}</li>

        @if (isset($show_period_change) && $show_period_change)
            <div class="form-group violet__box" id="change_period_step1">
            <span>
                <b>@lang('shopping::checkout.quotation.change_period')  </b>
            </span>
                <label>@lang('shopping::checkout.quotation.change_period_yes')
                    <input type="radio" id="address'+value.folio+'" class="btnchangePeriodQuotation" name="change_period_quotation" value="1"
                            {{ $change_period == 1 ? 'checked=checked' : ''  }}>
                </label>
                <label>@lang('shopping::checkout.quotation.change_period_no')
                    <input type="radio" id="address'+value.folio+'" class="btnchangePeriodQuotation" name="change_period_quotation" value="0"
                            {{ $change_period != 1 ? 'checked=checked' : ''  }}>
                </label>
            </div>
        @endif
    </div>




</div>