<div class="step step4 fade-in-down active cart__confirm" id="step4">
    <header class="cart__confirm-head">
        <p>@lang('shopping::checkout.confirmation.success.thank_you')</p>
    </header>

    @if (isset($banners))
        @foreach ($banners as $banner)
            @if (!empty($banner->link))<a target="_blank" href="{{ $banner->link }}">@endif

                <img src="{{ asset($banner->image) }}" alt="">

                @if (!empty($banner->link))</a>@endif
        @endforeach
    @endif

    <p>@lang('shopping::checkout.confirmation.no_order.info')</p>

    <h3>@lang('shopping::checkout.confirmation.success.message_inscription')</h3>
    <p>@lang('shopping::checkout.confirmation.success.Eonumber'):<strong> {{ $shipping->eo_number }} </strong></p>
    <p>@lang('shopping::checkout.confirmation.success.secretquestion'): <strong> {{ $question}} </strong></p>
    <p>@lang('shopping::checkout.confirmation.success.password'): <strong> {{ $password}} </strong></p>
    {{--<p>Tu pedido llegará en 10 días hábiles.</p>--}}
    <div class="cart__confirm-info">
        <p>@lang('shopping::checkout.confirmation.success.order_number'): <strong> {{ $order->order_number }} </strong></p>
        <p>@lang('shopping::checkout.confirmation.success.pay_with_'.strtolower($order->payment_brand))</p>
        <p>@lang('shopping::checkout.confirmation.success.pay_auth'): <strong> {{ $order->bank_authorization }} </strong></p>
        <p class="bold">@lang('shopping::checkout.confirmation.success.total'): <strong> {{ currency_format($order->total, \App\Helpers\SessionHdl::getCurrencyKey()) }} </strong></p>
        <p>@lang('shopping::checkout.confirmation.success.send_to') <strong> {{ "{$shipping->address}, {$shipping->suburb}. {$shipping->city_name}, {$shipping->state}" }} </strong></p>
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

</div>