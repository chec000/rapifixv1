<div id="cart-preview" class="cart-preview fade-in-down cart__right">
    <button class="icon-btn icon-cross close close_cross" type="button"></button>
    <div class="cart-preview__head">
        <p>@lang('cms::cart_aside.purchase_summary')</p>
    </div>

    <div class="cart-preview__content">
        <div id="divResumeQuotationErrors" style="width: 100%">
            @include("shopping::frontend.shopping.includes.resume_quotation_errors")
        </div>

        <ul id="cart-list" class="cart-product__list list-nostyle cart-list">
            @if (isset($shoppingCart) && sizeof($shoppingCart) > 0)
                @foreach ($shoppingCart as $item)
                    <li data-id="{{ $item['id'] }}" class="cart-product__item item-id-{{ $item['id'] }}">
                        <figure class="cart-product__img"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></figure>
                        <div class="cart-product__content">
                            <div class="cart-product__top">
                                <div class="cart-product__title">{{ $item['name'] }}</div>
                                <div class="cart-product__code">@lang('shopping::checkout.quotation.resume_cart.code'): {{ $item['sku'] }}</div>
                            </div>
                            <div class="cart-product__bottom">
                                <div class="form-group numeric">
                                    <input id="input{{ $item['sku'] }}" class="form-control number" maxlength="4" disabled="disabled"
                                    type="numeric" name="qty#{val}" value="{{ $item['quantity'] }}">
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
                <li id="cart-empty-default" style="text-align: center; margin-top: 50px;" class="cart-empty">@lang('shopping::checkout.quotation.resume_cart.no_items')
                <br><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}"><button class="button secondary small" type="button">@lang('shopping::checkout.keep_buying')</button></a>
                </li>
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

<div class="cart-preview-mov" id="cart-preview-mov">
    <div class="cart-preview__head">
        <p>@lang('shopping::register.kit.bill.shopping_cart')</p>
    </div>
    <div class="cart-preview__resume list-nostyle">
        <li class="points_mov">@lang('shopping::register.kit.bill.points'): 0000</li>
        <li class="total_mov">@lang('shopping::register.kit.bill.total'): $00.00</li>
    </div>
</div>