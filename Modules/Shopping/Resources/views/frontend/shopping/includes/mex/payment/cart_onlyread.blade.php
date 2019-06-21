<div id="cart-preview" class="cart-preview fade-in-down cart__right">
    <div class="cart-preview__head">
        <p>{{ trans('shopping::checkout.payment.resume_payment') }}</p>
        <button onclick="closeCart()" class="icon-btn icon-cross close" type="button"></button>
    </div>
    <div class="cart-preview__content">
        <div id="divResumeQuotationErrors" style="width: 100%">
            @include("shopping::frontend.shopping.includes.resume_quotation_errors")
        </div>

        <ul class="cart-product__list list-nostyle ps ps--active-y">
            @if (isset($sessionCart['items']))
                @forelse ($sessionCart['items'] as $i => $item)
                    <li class="cart-product__item">
                        <figure class="cart-product__img">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        </figure>
                        <div class="cart-product__content">
                            <div class="cart-product__top">
                                <div class="cart-product__title">{{ $item['name'] }}</div>
                                <div class="cart-product__code">@lang('cms::cart_aside.code'): {{ $item['sku'] }}</div>
                            </div>
                            <div class="cart-product__bottom">
                                <div class="form-group numeric">
                                    <input disabled="disabled" class="form-control" type="numeric" name="qty#{val}" value="{{ $item['quantity'] }}">
                                </div>
                                <div class="cart-product__nums">
                                    <div class="cart-product__pts">{{ $item['points'] }} @lang('cms::cart_aside.pts')</div>
                                    <div class="cart-product__price">x {{ currency_format($item['listPrice'], \App\Helpers\SessionHdl::getCurrencyKey()) }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <p>{{ trans('shopping::checkout.payment.no_items') }}</p>
                @endforelse
            @endif
        </ul>
        <div class="cart-preview__resume list-nostyle">
            <li>{{ trans('shopping::checkout.quotation.resume_cart.discount') }}: {{ isset($sessionCart['discount']) ? $sessionCart['discount'].'%' : '0%' }}</li>
            <li>{{ trans('cms::cart_aside.subtotal') }}: {{ isset($sessionCart['subtotal']) ?  currency_format($sessionCart['subtotal'], \App\Helpers\SessionHdl::getCurrencyKey()) : '$00.00' }}</li>
            <li>{{ trans('cms::cart_aside.points') }}: {{ isset($sessionCart['points']) ? $sessionCart['points'] : '0000' }}</li>
            <li>{{ trans('shopping::checkout.payment.handling') }}: {{ isset($sessionCart['handling']) ? currency_format($sessionCart['handling'], \App\Helpers\SessionHdl::getCurrencyKey()) : '$00.00' }}</li>
            <li>{{ trans('shopping::checkout.payment.taxes') }}: {{ isset($sessionCart['taxes']) ? currency_format($sessionCart['taxes'], \App\Helpers\SessionHdl::getCurrencyKey()) : '$00.00' }}</li>
            @php $total = 0;
                if (isset($sessionCart['subtotal']) && isset($sessionCart['taxes']) && isset($sessionCart['handling'])) {
                    $total = (((float)$sessionCart['subtotal']) + ((float)$sessionCart['taxes']) + ((float)$sessionCart['handling']));
                }
            @endphp
            <li class="total">@lang('cms::cart_aside.total'): {{ currency_format($total, \App\Helpers\SessionHdl::getCurrencyKey()) }}</li>
        </div>
    </div>
</div>