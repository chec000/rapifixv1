<div class="step step3 fade-in-down active cart__confirm" id="step3">
    <header class="cart__confirm-head">
        <p>@lang('shopping::checkout.confirmation.success.thank_you')</p>
        <h5>@lang('shopping::checkout.confirmation.success.success_pay')</h5>
    </header>
    <div class="cart__confirm-icon"></div>
    {{--<p>Tu pedido llegará en 10 días hábiles.</p>--}}
    <div class="cart__confirm-info">
        <p>@lang('shopping::checkout.confirmation.success.order_number'): <b>{{ $order->order_number }}</b></p>
        <p>@lang('shopping::checkout.confirmation.success.corbiz_order'): <b>{{ $order->corbiz_order_number }}</b></p>
        <p>@lang('shopping::checkout.confirmation.success.pay_with_'.strtolower($order->payment_brand))</p>
        <p>@lang('shopping::checkout.confirmation.success.pay_auth'): <b>{{ $order->bank_authorization }}</b></p>
        <p class="bold">@lang('shopping::checkout.confirmation.success.total'): <b>{{ currency_format($order->total, \App\Helpers\SessionHdl::getCurrencyKey()) }}</b></p>
        <p>@lang('shopping::checkout.confirmation.success.send_to') {{ "{$shipping->address}, {$shipping->suburb}. {$shipping->city_name}, {$shipping->state}" }}</p>
    </div>
    <ul class="cart__confirm-items list-nostyle mul">

        @if (isset($items))
            @foreach ($items as $item)
                <li class="cart__confirm-item">
                    <span class="cart__confirm-item__qty">{{ $item->quantity }}</span>
                    <span class="cart__confirm-item__name">{{ $item->name }}</span>
                    <span class="cart__confirm-item__code">{{ $item->sku }}</span>
                    <span class="cart__confirm-item__pts">{{ $item->points }} @lang('shopping::checkout.confirmation.success.points')</span>
                    <span class="cart__confirm-item__price">{{ currency_format($item->final_price, \App\Helpers\SessionHdl::getCurrencyKey()) }}</span>
                </li>
            @endforeach
        @endif
    </ul>
    <div class="cart__confirm-banners">
        @if (isset($banners) && !empty($banners))
            @foreach ($banners as $banner)
                @if (!empty($banner->link))<a target="_blank" href="{{ $banner->link }}">@endif
                    <figure class="cart__confirm-banner">
                        <img src="{{ asset($banner->image) }}" alt="">
                    </figure>
                    @if (!empty($banner->link))</a>@endif
            @endforeach
        @endif
    </div>
</div>