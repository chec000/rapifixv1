{!! PageBuilder::section('head', ['title' => trans('shopping::register.title')]) !!}
<script type='text/javascript' src="{{ asset('cms/jquery/jquery.min.js') }}"></script>

{!! PageBuilder::section('loader') !!}

<div class="cart fullsteps">
    <nav class="tabs-static">
        <div class="wrapper">
            <!--registro barra pasos-->
            <ul class="list-nostyle tabs-static__list">
                <li class="tabs-static__item tabs-static__item_step1">
                    <span class="desk">@lang('shopping::register.tabs.account.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.account.mobile')</span>
                </li>
                <li class=" tabs-static__item tabs-static__item_step2">
                    <span class="desk">@lang('shopping::register.tabs.info.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.info.mobile')</span>
                </li>
                <li class="tabs-static__item tabs-static__item_step3">
                    <span class="desk">@lang('shopping::register.tabs.kit.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.kit.mobile')</span>
                </li>
                <li class="tabs-static__item tabs-static__item active">
                    <span class="desk">@lang('shopping::register.tabs.confirm.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.confirm.mobile')</span>
                </li>
            </ul>
        </div>
    </nav>
    <div class="cart__main">
        <div class="wrapper">

            @if (!empty($response) && $response['status'] == false && isset($response['messages']) && sizeof($response['messages']) > 0)
                <div class="error__box">
                    <span class="error__single"><img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">{{ trans("shopping::checkout.payment.errors.default") }}:</span>
                    <ul>

                        @foreach ($response['messages'] as $message)
                            @if(isset($message['messUser']))
                                <li>{{ $message['messUser'] }}</li>

                            @else
                                    <li>{{ $message }}</li>
                            @endif
                        @endforeach
                    </ul>

                    @if (isset($response['err']))
                        <a href="#" class="detail-err-open" style="font-size: 12px;color: #F44336;text-decoration: underline;">{{ trans('cms::errors.modal.more') }}</a>
                        <input type="hidden" id="detail-err-info" value="{{ json_encode($response['err']) }}">
                    @endif
                </div>
            @endif


            @include('shopping::frontend.register.includes.usa.payment.confirmation.confirmation_'.$type, $order)
        </div>
    </div>
</div>

{!! PageBuilder::section('footer') !!}
