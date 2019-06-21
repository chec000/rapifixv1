{!! PageBuilder::section('head') !!}
<script type='text/javascript' src="{{ asset('cms/jquery/jquery.min.js') }}"></script>

{!! PageBuilder::section('loader') !!}

<div class="cart fullsteps">
    <nav class="tabs-static">
        <div class="wrapper">
            <!--registro barra pasos-->
            <ul class="list-nostyle tabs-static__list">
                <li class="tabs-static__item">{!! trans('shopping::shippingAddress.tag_shipping_address') !!}</li>
                <li class="tabs-static__item">{!! trans('shopping::shippingAddress.tag_way_to_pay') !!}</li>
                <li class="tabs-static__item active">{!! trans('shopping::shippingAddress.tag_confirm') !!}</li>
            </ul>
        </div>
    </nav>
    <div class="cart__main">
        <div class="wrapper">
            {{--<input type="hidden" name="test" value="{{ json_encode($response) }}">--}}
            @if (!empty($response) && $response['status'] == false && isset($response['messages']) && sizeof($response['messages']) > 0)
                <div class="error__box">
                    <span class="error__single"><img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">{{ trans("shopping::checkout.payment.errors.default") }}:</span>
                    <ul>
                        @foreach ($response['messages'] as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>

                    @if (isset($response['err']))
                        <a href="#" class="detail-err-open" style="font-size: 12px;color: #F44336;text-decoration: underline;">{{ trans('cms::errors.modal.more') }}</a>
                        <input type="hidden" id="detail-err-info" value="{{ json_encode($response['err']) }}">
                    @endif
                </div>
            @endif

            @include('shopping::frontend.shopping.includes.'.strtolower(session()->get('portal.main.country_corbiz').'.payment.confirmation.confirmation_'.$type), $order)
        </div>
    </div>
</div>

{!! PageBuilder::section('footer') !!}
