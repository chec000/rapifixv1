{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' - ' . trans('shopping::register.title')]) !!}

@include('themes.omnilife2018.sections.loader')
@include('shopping::partial_views.exit_register')

@section('styles')
    <style>
        .ui-datepicker-title select{
            color: black;
        }
    </style>
@endsection



<!--registro-->
<div class="register fullsteps" id="tabs_register">
    <nav class="tabs-static">
        <div class="wrapper">
            <!--registro barra pasos-->
            <ul class="list-nostyle tabs-static__list">
                <li id="tab__step1" class="tabs-static__item tabs-static__item_step1 active">
                    <span class="desk">@lang('shopping::register.tabs.account.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.account.mobile')</span>
                </li>
                <li id="tab__step2" class=" tabs-static__item tabs-static__item_step2">
                    <span class="desk">@lang('shopping::register.tabs.info.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.info.mobile')</span>
                </li>
                <li id="tab__step3" class="tabs-static__item tabs-static__item_step3">
                    <span class="desk">@lang('shopping::register.tabs.kit.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.kit.mobile')</span>
                </li>
                <li id="tab__step4" class="tabs-static__item tabs-static__item">
                    <span class="desk">@lang('shopping::register.tabs.confirm.desktop')</span>
                    <span class="mov">@lang('shopping::register.tabs.confirm.mobile')</span>
                </li>
            </ul>
        </div>
    </nav>
    <div class="cart__main">
        <form id="formRegister" name="formRegister" method="POST" action="">
            <!-- registro paso 1-->

            <div class="register__step step step1 fade-in-down active" id="step1">
                <input type="hidden" name="distributor_code" id="distributor_code">
                <input type="hidden" name="distributor_name" id="distributor_name">
                <input type="hidden" name="distributor_email" id="distributor_email">
                <div class="error__box hidden" id="error_step1">
                    <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                    <ul id="error__box_ul_step1">

                    </ul>
                </div>
                <input type="hidden" id="current_lang" value="{{Session::get('portal.main.app_locale')}}">
                <input type="hidden" id="current_country" value="{{Session::get('portal.main.country_corbiz')}}">
                <!-- div class="form-group">


                    <div class="form-label">@lang('shopping::register.account.country.label'):</div>
                    <div class="col-right">
                        <div class="select">
                            <select class="form-control" name="country" id="country">
                                <option value="">@lang('shopping::register.account.country.default')</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                            @if ($country->id == Session::get('portal.register.country_id'))
                                            selected="selected"
                                            @endif
                                    >{{ $country->name }}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                </div -->
                <div class="form-group radioEo">
                    <div class="form-label mov">@lang('shopping::register.account.invited.label.desktop'):</div>
                    <div class="form-label desk">@lang('shopping::register.account.invited.label.mobile'):</div>
                    <div class="col-right">
                        <div class="form-radio inline"><span class="radio-label">@lang('shopping::register.account.invited.answer.yes')</span>
                            <input type="radio" id="invited1" name="invited" value="1">
                            <label class="radio-fake" for="invited1"></label>
                        </div>
                        <div class="form-radio inline"><span class="radio-label">@lang('shopping::register.account.invited.answer.no')</span>
                            <input type="radio" id="invited2" name="invited" value="0">
                            <label class="radio-fake" for="invited2"></label>
                        </div>
                        <div class="error-msg error-validation" id="div_invited"></div>
                        <input type="hidden" value="{{ !empty($numEo) ? 0 : '' }}" id="ispool" name="ispool">
                    </div>
                </div>
                <div class="form-group hidden" id="invited-yes">



                        <div class="sponsored form-label {{ !empty($numEo)  ? '' : 'hide hidden' }}">@lang('shopping::register.account.businessman_code.label_sponsored'):</div>
                        <div class="normal form-label {{ !empty($numEo)  ? 'hide hidden' : '' }}">@lang('shopping::register.account.businessman_code.label'):</div>


                    <div class="col-right">
                        <input rel="{{ isset($codEo)  ? $codEo : '' }}" class="form-control" type="text" id="register-code" name="register-code" placeholder="@lang('shopping::register.account.businessman_code.placeholder')*" value="{{ $numEo }}">
                        <div class="" id="valid-eo"></div>
                        <div class="error-msg error-validation" id="div_distributor_code"></div>
                        <div class="error-msg error-validation" id="div_distributor_name"></div>
                    </div>
                    <input type="hidden" value="INSCRIPTION" id="inscription_type" name="inscription_type"/>
                </div>
                <div class="form-group hidden" id="invited-no">
                    <div class="form-label">@lang('shopping::register.account.meet_us.label'):</div>
                    <div class="col-right">
                        <div class="select">
                            <select class="form-control" name="references" id="references">
                                <option value="">@lang('shopping::register.account.meet_us.default')</option>
                            </select>
                            <div class="error-msg" id="error-msg-references"></div>
                            <div class="error-msg" id="error-msg-pool"></div>
                            <div class="error-msg error-validation"></div>
                        </div>
                        <div class="error-msg" id="div_references"></div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="form-label">@lang('shopping::register.account.email.label'):</div>
                    <div class="col-right">
                        <input class="form-control" type="text" id="email" name="email" placeholder="@lang('shopping::register.account.email.placeholder')*">
                        <div class="error-msg error-validation" id="div_email"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">@lang('shopping::register.account.confirm_email.label'):</div>
                    <div class="col-right">
                        <input class="form-control" type="text" id="confirm-email" name="confirm-email" placeholder="@lang('shopping::register.account.confirm_email.placeholder')*">
                        <div class="error-msg error-validation" id="div_confirm-email"></div>
                    </div>
                </div>

                <div class="form-group{{Config::get('shopping.register.validate_form.' . Session::get('portal.register.country_corbiz') . '.tel') ? '' : ' hidden'}}">
                    <div class="form-label">@lang('shopping::register.account.phone.label'):</div>
                    <div class="col-right">
                        <input class="form-control" type="text" id="tel" name="tel" placeholder="@lang('shopping::register.account.phone.placeholder')*">
                        <div class="error-msg error-validation" id="div_tel"></div>
                    </div>
                </div>

                <div class="form-group{{Config::get('shopping.register.validate_form.' . Session::get('portal.register.country_corbiz') . '.cel') ? '' : ' hidden'}}">
                    <div class="form-label">@lang('shopping::register.account.cel.label'):</div>
                    <div class="col-right">
                        <input class="form-control" type="text" id="cel" name="cel" placeholder="@lang('shopping::register.account.cel.placeholder')*">
                        <div class="error-msg error-validation" id="div_cel"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">@lang('shopping::register.account.secret_question.label'):</div>
                    <div class="col-right">
                        <div class="select">
                            <select class="form-control" name="secret-question" id="secret-question">
                                <option value="">@lang('shopping::register.account.secret_question.default')</option>

                            </select>
                            <div class="error-msg" id="error-msg-questions"></div>
                            <div class="error-msg error-validation" id="div_secret-question"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">@lang('shopping::register.account.secret_answer.label'):</div>
                    <div class="col-right">
                        <input class="form-control" type="text" id="response-question" name="response-question" placeholder="@lang('shopping::register.account.secret_answer.placeholder')*">
                        <div class="error-msg error-validation" id="div_response-question"></div>
                    </div>
                </div>
                <div class="buttons-container">
                    <button class="button secondary" type="button" id="backStep1">@lang('shopping::register.prev_button')</button>
                    <button class="button" type="button" id="btnContinueStep1">@lang('shopping::register.next_button')</button>
                </div>
            </div>

            <!-- registro paso 2-->
            <div class="register__step step step2 fade-in-down" id="step2">
                <div class="error__box hidden" id="error_step2">
                    <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                    <ul id="error__box_ul_step2">
                    </ul>
                </div>
                <div class="form-row">
                    <div class="form-label block">@lang('shopping::register.info.full_name.label')</div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="name" name="name" placeholder="@lang('shopping::register.info.full_name.placeholders.name')*">
                        <div class="error-msg" id="div_name"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="lastname" name="lastname" placeholder="@lang('shopping::register.info.full_name.placeholders.last_name')">
                        <div class="error-msg" id="div_lastname"></div>
                    </div>
                    <div class="form-group medium">
                        <input class="form-control" type="text" id="lastname2" name="lastname2" placeholder="@lang('shopping::register.info.full_name.placeholders.last_name2')">
                        <div class="error-msg" id="div_lastname2"></div>
                    </div>
                    <div class="form-group medium">
                        <div class="form-label mov">@lang('shopping::register_customer.account.sex.label'):</div>
                        <div class="form-label desk">@lang('shopping::register_customer.account.sex.label'):</div>

                        <div class="col-right">
                            <div class="form-radio inline">
                                <span class="radio-label">@lang('shopping::register_customer.account.sex.male')</span>
                                <input type="radio" id="sex1" name="sex" value="M" checked>
                                <label class="radio-fake" for="sex1"></label>
                            </div>
                            <div class="form-radio inline">
                                <span class="radio-label">@lang('shopping::register_customer.account.sex.female')</span>
                                <input type="radio" id="sex2" name="sex" value="F">
                                <label class="radio-fake" for="sex2"></label>
                            </div>


                        </div>
                        <div class="error-msg" id="div_sex"></div>
                    </div>
                </div>
                <div class="form-row left">
                    <div class="error-msg" id="error-msg-parameters"></div>
                    <div class="form-label block">@lang('shopping::register.info.birth_date.label')</div>
                    <div class="form-group select small">
                        <select class="form-control" name="day" id="day">
                            <option value="">@lang('shopping::register.info.birth_date.defaults.day')*</option>
                            @for($i=1;$i<=31;$i++)
                                <?php $day = strlen($i) == 1 ? "0".$i : $i ?>
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endfor
                        </select>
                        <div class="error-msg" id="div_day"></div>
                    </div>
                    <div class="form-group select small">
                        <select class="form-control" name="month" id="month">
                            <option value="">@lang('shopping::register.info.birth_date.defaults.month')*</option>
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}">@lang($month)</option>
                            @endforeach

                        </select>
                        <div class="error-msg" id="div_month"></div>
                    </div>
                    <div class="form-group select small">
                        <select class="form-control" name="year" id="year">
                            <option value="">@lang('shopping::register.info.birth_date.defaults.year')*</option>

                        </select>
                        <div class="error-msg" id="div_year"></div>
                    </div>

                    <div class="error-msg" id="div_borndate"></div>

                </div>
                <div class="form-row" id="documents" style="display:none;">
                    <div class="form-label block">@lang('shopping::register.info.id.label')</div>
                    <div class="form-group select mediumx">
                        <select class="form-control" name="id_type" id="id_type">
                            <option value="">@lang('shopping::register.info.id.defaults.type')</option>
                        </select>
                        <div class="error-msg" id="div_id_type"></div>
                    </div>
                    <div class="form-group mediumx">
                        <input class="form-control" type="text" id="id_num" name="id_num" placeholder="@lang('shopping::register.info.id.placeholders.number')*">
                        <div class="error-msg" id="div_id_num"></div>
                    </div>
                </div>

                <!--Fragmento de includes dependiendo de la configuración de los inputs por pais-->
                <div class="form-row" id="form_included">

                </div>
                <!--Fin include inpiuts por país-->
                <div class="form-row">
                    <div class="form-group form-checkbox contract_option">
                        <input type="checkbox" id="terms1" name="terms1">
                        <label class="checkbox-fake" for="terms1"></label><span class="checkbox-label">@lang('shopping::register.info.terms_contract.text') <a id="triggermodal" href="#modalTerms" data-modal="true">@lang('shopping::register.info.terms_contract.link')</a>.</span>
                        <div class="error-msg" id="div_terms1"></div>
                    </div>

                    <div class="form-group form-checkbox transfer">
                        <input type="checkbox" id="terms2" name="terms2">
                        <label class="checkbox-fake" for="terms2"></label><span class="checkbox-label">@lang('shopping::register.info.terms_payment.text') @lang('shopping::register.info.terms_payment.link').</span>
                        <div class="error-msg" id="div_terms2"></div>
                    </div>



                    <div class="form-group form-checkbox information">
                        <input type="checkbox" id="terms3" name="terms3">
                        <label class="checkbox-fake" for="terms3"></label><span class="checkbox-label">@lang('shopping::register.info.terms_information.text') @lang('shopping::register.info.terms_information.link').</span>
                        <div class="error-msg" id="div_terms3"></div>
                    </div>


                </div>
                <div class="buttons-container">
                    <button class="button secondary" type="button" id="backStep2">@lang('shopping::register.prev_button')</button>
                    <button class="button" type="button" id="btnContinueStep2">@lang('shopping::register.next_button')</button>
                </div>
            </div>
            <!-- registro paso 3-->
            <div class="register__step step step3 fade-in-down" id="step3">
                <div class="error__box hidden" id="error_step3" style="margin:0 auto;max-width:720px;overflow:hidden;">
                    <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                    <ul id="error__box_ul_step3">

                    </ul>

                </div>
                <div id="generic_error" style="margin:0 auto;max-width:720px !important;overflow:hidden;">

                </div>

                <div class="wrapper">
                    <!--Inicio kits,shipping company,payment type-->
                    <div class="cart__register">
                        <div class="cart__left">
                            <div class="cart__main-title">@lang('shopping::register.kit.types')</div>
                            <div class="error-msg" id="error-msg-kits"></div>
                            <div class="error-msg" id="div_kit"></div>
                            <div class="form-group" id="kits">



                            </div>

                            <div class="error-msg" id="error-msg-shipping"></div>
                            <div class="error-msg" id="div_shipping_way"></div>
                            <div class="form-label">@lang('shopping::register.kit.shipping')</div>

                            <div class="form-group" id="shipping_companies">



                            </div>

                            <div class="error-msg" id="error-msg-banks"></div>
                            <div class="error-msg" id="div_payment"></div>
                            <div class="" id="choose" style="color:red;display:none">@lang('shopping::register.kit.choose')</div>
                            <div class="form-label">@lang('shopping::register.kit.payment')</div>
                            <div class="form-group hide hidden" id="banks">



                            </div>
                            @php $banks = \Modules\Shopping\Entities\Bank::whereHas('banksCountry', function ($q) { $q->where('country_id', \App\Helpers\SessionHdl::getCountryID()); })->get(); @endphp

                            @foreach ($banks as $bank)
                                @if ($bank->bank_key == 'PAYPAL_PLUS')
                                    <div id="divppplus" style="display: none; text-align: center;">
                                        <h3 style="border-top-style: solid;border-bottom-style: solid;border-top-width: 1px;border-bottom-width: 1px;border-top-color: rgba(0,0,0,0.1);border-bottom-color: rgba(0,0,0,0.1);font-weight: lighter;padding: 5px 0;">@lang('shopping::checkout.payment.card_pplus')</h3>
                                        <div id="ppplus" style="border:none; margin: 0 auto;"></div>
                                        <div id="ppplusmini"></div>

                                        <input type="hidden" id="approvalUrl" name="approvalUrl" value="">
                                        <input type="hidden" id="payerEmail" name="payerEmail" value="">
                                        <input type="hidden" id="payerFirstName" name="payerFirstName" value="">

                                        <div style="margin: 0 auto;">
                                            <button type="button" id="paypal-plus-button-cancel" class="button small" style="display: inline-block">Cancelar</button>
                                            <button type="button" id="paypal-plus-button-pay" class="button small" style="display: inline-block; background: #9a2e9b;" onclick="ppp.doContinue(); return false;">Pagar</button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <input type="hidden" id="warehouse" name="warehouse" value="" />
                            <input type="hidden" id="distCenter" name="distCenter" value="" />


                        </div>


                        <!-- cart preview-->
                            @if(View::exists("shopping::frontend.register.includes.".strtolower(session()->get('portal.main.country_corbiz')).".cart_preview_".strtolower(session()->get('portal.main.country_corbiz'))))
                                @include("shopping::frontend.register.includes.".strtolower(session()->get('portal.main.country_corbiz')).".cart_preview_".strtolower(session()->get('portal.main.country_corbiz')))
                            @endif
                        <!-- end cart preview-->



                    </div>


                </div>
                <div id="isback" value="0"></div>
                <div id="hasQuotation" value="0"></div>
                <div id="is_validated" value="0"></div>
                <div class="buttons-container">
                    <button class="button secondary" type="button" id="backStep3">@lang('shopping::register.prev_button')</button>
                    @foreach ($banks as $bank)
                        @if ($bank->bank_key == 'PAYPAL')
                            <div class="payment-container paypal" style="display: none;">
                                <div id="paypal-button" style="width: 200px; height: 36px;"></div>
                            </div>
                        @elseif ($bank->bank_key == 'PAYPAL_PLUS')
                            <div class="payment-container paypal-plus" style="display: none;">
                                <button type="button" id="paypal-plus-button" class="button small">@lang('shopping::checkout.payment.pay_pplus')</button>
                            </div>
                        @endif
                    @endforeach

                </div>



            </div>
            <input type="hidden" name="order" id="order" />
            <input type="hidden" name="type" id="type_action" value="register" />
        </form>
        <form id="f_ejecuta_pago" method="POST" action="{{ route('paypalplus.process') }}">
            <input type="hidden" id="i_pay_id" name="paymentID" value="">
            <input type="hidden" id="i_payerId" name="payerID" value="">
            <input type="hidden" id="i_token" name="token" value="">
            <input type="hidden" id="i_term" name="term" value="">
            <input type="hidden" name="type" value="register" />
        </form>
        <!-- registro bienvenido-->
        <!-- div class="register__step step step4 register__welcome" id="step4">
            <h3>@lang('shopping::register.confirm.email')</h3>
            <p>@lang('shopping::register.confirm.businessman_code'): 001-123-RPT</p>
        </div -->
    </div>
</div>
<!-- modal cargando-->
<div class="modal modal-loading" id="realizando-pago">
    <div class="modal__inner ps-container">
        <header class="modal__body">
            <p class="text-top">@lang('shopping::checkout.payment.modal.loader.title')</p>
            <div class="loading">
                <figure class="icon-loading">
                    <img src="{{ asset('themes/omnilife2018/images/icons/loading_'.\App\Helpers\SessionHdl::getLocale().'.svg') }}" alt="OMNILIFE - loading">
                </figure>
            </div>
            <p class="highlight">@lang('shopping::checkout.payment.modal.loader.p1')</p>
            <p>@lang('shopping::checkout.payment.modal.loader.p2')</p>
        </header>
    </div>
</div>


@include('shopping::partial_views.terms')
<!-- modal terminos y condiciones-->
<div class="modal" id="terminos-y-condiciones-contrato">
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title">Al dar clic en “Aceptar”, confirmas estar de acuerdo con nuestros Términos y condiciones.</h5>
        </header>
        <div class="modal__body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ultricies pharetra ipsum, sed vehicula neque. Nullam fermentum est tellus, vel viverra neque laoreet et. Nulla ut urna eget lacus facilisis auctor non nec quam. Nam ut mi sit amet
                metus ultrices pellentesque ac nec felis. Maecenas et malesuada felis, nec rhoncus metus. Aenean vitae ex a orci semper tincidunt. Suspendisse in lacus porttitor, tempus eros vitae, aliquet magna.</p>
            <p>Phasellus lobortis vitae ipsum quis sollicitudin. Duis tristique rhoncus malesuada. Morbi quis turpis elementum, elementum lectus eget, vestibulum purus. Cras a vestibulum ante. Integer eget nibh id magna ullamcorper aliquet. Nulla facilisi. Curabitur
                eu ultricies tortor. Praesent tincidunt nulla sed leo faucibus dignissim. Nulla efficitur auctor mi ac elementum.</p>
            <p>Quisque porttitor condimentum lacus. Morbi consequat finibus accumsan. Integer blandit eros urna, eget hendrerit nisi auctor sit amet. Duis vitae lectus nec arcu venenatis luctus sed at ipsum. Nunc ac velit dictum, cursus magna vitae, scelerisque
                est. Duis ornare lectus at elit venenatis, eget semper tellus elementum. Quisque vestibulum nibh tortor, ut maximus velit ornare ut. Morbi neque sem, convallis vitae sollicitudin vitae, tincidunt quis justo. Donec cursus mauris vel metus rhoncus
                mollis. Suspendisse rutrum, quam at rutrum lobortis, tortor urna congue sem, in tincidunt lacus urna eget tellus. Ut orci elit, pulvinar ut elit varius, aliquam hendrerit justo. Maecenas sed metus at augue aliquam egestas eu in nulla. Phasellus
                vitae malesuada dui. Quisque ultrices est ut nisi imperdiet gravida. Quisque tincidunt iaculis est, in sollicitudin nibh.</p>
            <p>Nunc id eleifend lectus, non mollis purus. Quisque eu tincidunt ante. Donec enim felis, convallis sodales imperdiet quis, interdum eu sapien. Nulla vitae augue a nisl aliquet fringilla. Phasellus lectus felis, ornare vel varius eu, ultricies ac
                ligula. Donec ullamcorper odio rhoncus, placerat urna vitae, efficitur quam. Aliquam justo arcu, varius vel diam et, mollis posuere ex. Mauris a quam vitae orci convallis blandit vel ac ligula.</p>
            <p>Morbi tempus eros ut sem gravida auctor. Proin non ipsum bibendum, mollis eros a, mattis quam. Morbi tincidunt at nunc vel venenatis. Sed ac mattis mi, at feugiat neque. Phasellus eget condimentum turpis. Vestibulum ante ipsum primis in faucibus
                orci luctus et ultrices posuere cubilia Curae; Donec eget dui molestie ex rutrum tristique. Ut blandit tempor odio, eget varius turpis maximus non. Maecenas quis purus arcu. Praesent varius mauris eu nunc maximus faucibus. Curabitur tincidunt
                magna dui, at ullamcorper justo varius in. Ut fringilla, leo in congue tincidunt, orci urna vulputate mauris, sit amet pulvinar sapien quam non sapien. Morbi fermentum tellus sed sapien luctus tincidunt. Vivamus semper nulla a orci interdum,
                id malesuada nunc faucibus. Vivamus a odio commodo, efficitur leo nec, condimentum elit. Morbi vel quam porta, placerat arcu non, sodales tellus.</p>
        </div>

    </div>
</div>


<button id="btnExitModalRegister" data-modal="true" style="display: none;" href="#exitModalRegister"></button>


{!! PageBuilder::section('footer', ['isInShoppingView' => true,'isRegister' => true]) !!}
@include("shopping::frontend.shopping.includes.promotions.modal_promo")


<!-- jQuery Autocomplete -->
<script type='text/javascript' src="{{ asset('cms/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/cms/jquery-ui/jquery-ui.js') }}"></script>
<script type='text/javascript' src="{{ asset('/js/jquery.autocomplete.js') }}"></script>
<script src="{{ PageBuilder::js('resume_cart_register_old_browsers') }}"></script>
<script type='text/javascript' src="{{ asset('/js/redirect.js')}}"></script>

<script type="text/javascript">


    var hrefExit            = '';
    var typeExit            = '';
    var currentCountryId    = '';
    var newCountryId        = '';
    var currentLangId       = '';
    var newLangId           = '';
    var hasSession          = true;
    @if(session('modalExit'))
    var zipCodeSession      = null;
    @else
    var zipCodeSession      = '{{session()->get('portal.main.zipCode')}}';
    @endif
    var translations = {
        errorEmptyShippingCompanies:  '{{ trans("shopping::register.kit.shippingCompanies_empty") }}',
        errorStreetCorbiz:              '{{trans("shopping::register_customer.fields.street_corbiz")}}',

    };

    var country =  '{{\App\Helpers\SessionRegisterHdl::getCountryID()}}';
    var countryCorbiz = '{{\App\Helpers\SessionRegisterHdl::getCorbizCountryKey()}}';
    var lang = '';

    $( document ).ready(function() {


        var lang = $("#current_lang").val();


        $('#btnCloseLoginSection').click(function() {
            $('.overlay').hide();
        });

        var shopping_cart = {!! ShoppingCart::sessionToJson(session()->get('portal.main.country_corbiz')) !!};
            if (shopping_cart.constructor === Array && shopping_cart.length == 0) {
                shopping_cart = {};
            }
            document.shopping_cart = shopping_cart;


        ResumeCart.update_items();

        $('#zip').blur(function() {
            zipCodeSession = null;
        });




        /* Registro Inconcluso - Al cambiar de país, cambiar lenguaje o click en login */
        $('a').on({
            click: function(e) {
                if (hasSession == true) {
                    var tagClass = $(this).attr('class');
                    var attrId = $(this).attr('id');

                    if (tagClass == 'change_country_header') {
                        e.stopPropagation();
                        currentCountryId = $(this).data('countryidcurrent');
                        newCountryId = $(this).data('countryid');
                        typeExit = 'refresh_country';

                        if (currentCountryId != newCountryId) {
                            $('#btnExitModalRegister').click();
                        }
                    }
                    else if (tagClass == 'change_language_header') {
                        e.stopPropagation();
                        currentLangId = $(this).data('langidcurrent');
                        newLangId = $(this).data('langid');
                        typeExit = 'refresh_lang';

                        if (currentLangId != newLangId) {
                            $('#btnExitModalRegister').click();
                        }
                    }
                    else if (attrId == 'login-btn') {
                        e.stopPropagation();
                        e.preventDefault();
                        $('.login').removeClass('active');
                        $('#btnExitModalRegister').click();
                        typeExit = 'section';
                        hrefExit = '.login';
                    }
                }
            }
        });

        /* Registro Inconcluso - Alerta al hacer click en el icono de login */
        $('.icon-btn').on({
            click: function() {
                if (hasSession == true) {
                    if (!$(this).hasClass('icon-bin')) {
                        var attrId = $(this).attr('id');
                        typeExit = 'section';

                        if (attrId == 'iuser') {
                            $('.login').removeClass('active');
                            hrefExit = '.login';
                            $('#btnExitModalRegister').click();
                        }
                        else if (attrId == 'icart') {
                            $('.cart-preview').removeClass('active');
                            typeExit = 'change_url';
                            hrefExit = "{{session()->get('portal.main.brand.domain')}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}";
                            $('#btnExitModalRegister').click();
                        }
                    }
                }
            }
        });

        $('.cerrarModal').on({
                click: function(){
                    $("#modalTerms").removeClass('active');
                    $(".overlay").hide();
                    if($("#terms1").is(':checked')){
                        $("#terms1").prop('checked',false);
                    }

                }
        });




        //Actualiza los campos del fomulario ysesion cuando se cambia de país para volver a llenar los valores en base al país
       /*  $("#country").change(function () {
            //Actualizar valore de la sesion
            updateSession($(this).val());
            //Limpiar los campos del formulario que se definen por el paíes e idioma
            $("#register-code").val("");
            $("#response-question").val("");
            $("#distributor_code").val("");
            $("#distributor_name").val("");
            $("#distributor_email").val("");
            $("#secret-question").children('option:not(:first)').remove();
            $("#references").children('option:not(:first)').remove();
            $("#id_type").children('option:not(:first)').remove();
            $("#state").children('option:not(:first)').remove();
            $("#city").children('option:not(:first)').remove();
            $("#error-msg-referneces").html("");
            //$("#invited1").click();
            $("#invited-no").addClass('hide hidden');
            $("#invited-yes").addClass('hide hidden');
            $("#invited1").prop('checked',false);
            $("#invited2").prop('checked',false);
            $("#id_num").val("");
            $("#terms1").prop('checked',false);
            $("#terms2").prop('checked',false);
            $("#terms3").prop('checked',false);
            $(".error__box").hide();
            $("#register-code").removeClass("has-error");
            $("#valid-eo").removeClass('alert-businessman alert-success');
            $("#valid-eo").html("");
            $(".radioEo").removeClass('hidden hide');
            $("#register-code").prop('readonly',false);
            country = $(this).val();
        }); */


        //Se obtienes las preguntas con el pais e idioma inicial
        loadView(countryCorbiz);
        getQuestions(country);
        getParameters(country);

        getLegalDocuments(country);
        getBanks(country);
        getKits(country);

        //Se obtienen las referencias y el pool de empresario asl seccionar que no fuiste invitado
        $("#invited2").click(function(){
            $("#invited-no").removeClass('hide hidden');
            $("#invited-yes").addClass('hide hidden');
            $("#valid-eo").removeClass('alert-businessman alert-success');
            $("#valid-eo").html("");
            $("#ispool").val(1);
            //Llamado registration references
            $.ajax({
                type: "POST",
                url: "{{ route('register.references') }}",
                data: {'country':country, _token: '{{csrf_token()}}'},
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                success: function (result){

                    if(result.success){
                        $("#error_step1").hide();
                        $("#error__box_ul_step1").html("");
                        $("#references").children('option:not(:first)').remove();
                        $("#error-msg-referneces").html("");
                        $("#btnContinueStep1").prop('disabled',false);
                        $.each(result.data, function (i, item) {

                            $('#references').append($('<option>', {
                                value: item.id,
                                text : item.name
                            }));
                        });

                        @if(session('modalExit'))
                            var dataExit    = jQuery.parseJSON('{!!session('dataUnfinished')!!}');

                            $.each(dataExit, function(key, value) {
                                if (key == 'references') {
                                    $('#references').val(value);
                                }
                            });
                        @endif


                    }else{
                        $("#error-msg-referneces").html(result.message);
                        $("#error_step1").hide();
                        $("#error__box_ul_step1").html("");
                    }


                },
                error:function(result){

                    $("#error-msg-referneces").html(result.message);
                },
                beforeSend: function () {
                    $("#references").children('option:not(:first)').remove();
                    $("#error_step1").hide();
                    $("#error__box_ul_step1").html("");
                    $("#register-code").val("");

                    //$("#save-product-information").prop('disabled', true);
                },
                complete: function () {

                    //$("#save-product-information").prop('disabled', false);
                }
            });

            //llamado pool de empresarios
            $.ajax({
                type: "POST",
                url: "{{ route('register.pool') }}",
                data: {'country':country,'lang':lang, _token: '{{csrf_token()}}'},
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                success: function (result){

                    if(result.success){
                        info = result.data;
                        $("#error-msg-pool").html("");
                        $("#distributor_name").val(info.distributor_name);
                        $("#distributor_code").val(info.distributor_code);
                        $("#distributor_email").val(info.distributor_email);


                    }else{
                        $("#error-msg-pool").html(result.message);
                    }


                },
                error:function(result){

                    $("#error-msg-pool").html(result.message);
                },
                beforeSend: function () {
                    $("#distributor_code").val("");
                    $("#distributor_name").val("");
                    $("#distributor_email").val("");
                    //$("#save-product-information").prop('disabled', true);
                },
                complete: function () {

                    //$("#save-product-information").prop('disabled', false);
                }
            });



        });

        $("#invited1").click(function () {
            $("#invited-yes").removeClass('hide hidden');
            $("#invited-no").addClass('hide hidden');
            $("#references").val("");
            $("#error-msg-pool").html("");
            $("#distributor_name").val("");
            $("#distributor_code").val("");
            $("#distributor_email").val("");
            $("#ispool").val(0);


        });

        //se valida si el empresario ingresado existe
        $("#register-code").blur(function () {
            var sponsor = $("#register-code").val();

            $.ajax({
                type: 'POST',
                url: "{{route('register.validateeo')}}",
                data: {'country': country, 'sponsor': sponsor, 'lang': lang},
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (result){
                    if(result.status){
                        info = result.data;
                        $("#valid-eo").addClass('alert-businessman alert-success');
                        $("#valid-eo").html(info.name_1);
                        $("#distributor_name").val(info.name_1);
                        $("#distributor_code").val(info.dist_id);
                        $("#distributor_email").val(info.email);
                        $("#btnContinueStep1").prop('disabled',false);
                    }
                    else {
                        $("#error_step1").show();
                        $("#register-code").addClass("has-error");

                        $.each(result.messages, function (key, value) {
                            var id_error = (value.idError == '') ? '' : ' (' + value.idError + ')';
                            $('#error__box_ul_step1').append('<li>' + $.trim(value.messUser) + $.trim(id_error) + '</li>');
                        });

                        $("#btnContinueStep1").prop('disabled',true);

                        if (result.details != '') {
                            $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(result.details);
                        }

                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    }
                },
                error: function(result) {
                },
                beforeSend: function() {
                    $('#error_step1').hide();
                    $('#error__box_ul_step1').empty();
                    $('#register-code').removeClass('has-error');
                    $('#valid-eo').removeClass('alert-businessman alert-success');
                    $('#valid-eo').html('');
                    $('#distributor_name').val('');
                    $('#distributor_code').val('');
                    $('#distributor_email').val('');
                },
                complete: function() {
                }
            });
        });

        $('#city').change(function() {
            var selectCity          = document.getElementById('city');
            var selectedOptionCity  = selectCity.options[selectCity.selectedIndex].text;
            var value               = $(this).val();

            $('#city_name').val(selectedOptionCity);

            if (value == 'default') {
                $('#city_hidden').val('');
            }
            else {
                $('#city_hidden').val(value);
            }
        });





        //Validamos los campos obligatorios
        $('#btnContinueStep1').click(function() {
            validateStep1();
        });
        $('#btnContinueStep2').click(function() {
            validateStep2();
        });
        $('#btnContinueStep3').click(function() {
            validateStep3();
        });
        $('#backStep1').click(function() {
            backStep1();
        });
        $('#backStep2').click(function() {
            backStep2();
        });
        $('#backStep3').click(function() {
            backStep3();
        });



        $(".accept-terms").click(function(){
            $(".overlay").hide();
            $("#modalTerms").removeClass('active');
            $("#terms1").prop('checked',true);
            setHourTerms("terms1",true);
        });

        $("#terms1").click(function(){
            var checkmarked = $(this).is(':checked');
            setHourTerms("terms1",checkmarked);
            $(".overlay").show();
            $("#modalTerms").addClass('active');

        });
        $("#terms2").click(function(){
            var checkmarked = $(this).is(':checked');
            setHourTerms("terms2",checkmarked);
        });
        $("#terms3").click(function(){
            var checkmarked = $(this).is(':checked');
            setHourTerms("terms3",checkmarked);
        });

        $('#btnAcceptModalExitRegister').click(function() {
            if (typeExit == 'section') {
                $('.overlay').show();
                $(hrefExit).addClass('active');
                $('#btnCancelModalExitRegister').click();
            }
            else if (typeExit == 'change_url') {
                var url         = "{{route('register.exit')}}";
                var dataForm    = {
                    name_session:           'register',
                    url_next_exit_register: hrefExit,
                };

                modalUnfinishedRegister(url, dataForm);
            }
            else if (typeExit == 'refresh_lang') {
                $('.loader').removeClass('hide').addClass('show');

                if (currentLangId != newLangId) {
                    change_country_language(newLangId, 'language');
                }
            }
            else if (typeExit == 'refresh_country') {
                $('.loader').removeClass('hide').addClass('show');

                if(currentCountryId != newCountryId) {
                    change_country_language(newCountryId, 'country');
                }
            }
            else {
                var url         = "{{route('register.exit')}}";
                var dataForm    = {
                    name_session:           $('#name_session').val(),
                    url_next_exit_register: $('#url_next_exit_register').val(),
                };

                modalUnfinishedRegister(url, dataForm);
            }
        });

        if($("#register-code").val() != "" && $("#register-code").attr('rel') == 1){
            $("#invited-yes").removeClass('hidden hide');
            $("#register-code").attr('readonly','readonly');
            $(".radioEo").addClass('hidden hide');
            $("#register-code").blur();
            $("#invited1").prop('checked',true);

        }




    });//Final document ready

    $(document).on('change','#state',function () {
        var state = $(this).val();
        var htmlCities = '';
        $("#state_hidden").val($(this).val());
        $.ajax({
            type: "POST",
            url: "{{ route('register.cities') }}",
            data: {'country':country,'state':state, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__box_ul_step2").html("");
                    $("#error_step2").hide();
                    $('#city').removeClass('has-error');
                    htmlCities += '<option value="">@lang("shopping::register.info.address.placeholders.city")</option>';
                    $.each(result.data, function (i, item) {

                        htmlCities += '<option value="'+$.trim(item.id)+'">' + $.trim(item.name) + '</option>';

                    });
                    $("#city").html(htmlCities);



                }else{


                    $("#error_step1").show();
                    $("#error__box_ul_step2").html("");
                    $("#city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__box_ul_step2").append("<li class='text-danger'>"+item+"</li>");
                    });

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');


                }


            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__box_ul_step2").html("");
                $("#error_step2").hide();
                $("#city").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });
    });

    $(document).on('change','#city',function(){
        $("#city_hidden").val($(this).val());
    });


    $(document).on('click','.z_onclose',function(){
       //Cambios en css para cuando se presione el menu de version movil
        $('.main-h').css('z-index',1);
        $('.close_cross').css('z-index',10);
    });
    $(document).on('click','.close_cross',function(){

        //Cambios en css para cuando se presione el menu de version movil
        $('.main-h').css('z-index',100);
        $('.close_cross').css('z-index',0);
        $('#cart-preview').removeClass('active');
    });


    $(document).on('keyup','#street',function(){
        var street = $(this).val();
        var appliesValidation = '{{config('shopping.defaultValidationForm.'.session()->get('portal.register.country_corbiz').'.specialstreet')}}';
        if(appliesValidation){
            $.ajax({
                type: "POST",
                url: "{{ route('register.validatestreet') }}",
                data: {'street':street, _token: '{{csrf_token()}}'},
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                success: function (result){

                    if(result.passes){
                        $("#btnContinueStep2").attr('disabled',false);
                        $("#div_message_street").html('');
                        $("#div_message_street").html(result.message);
                        $("#div_message_street").css('color','black');
                    }else{
                        $("#btnContinueStep2").attr('disabled',true);
                        $("#div_message_street").html('');
                        $("#div_message_street").html(result.message);
                        $("#div_message_street").css('color','red');
                    }



                },
                error:function(result){

                },
                beforeSend: function () {

                },
                complete: function () {
                }
            });
        }

    });


    /**
     * Generar la transacción de inscripcion en corbiz
     * */


    //Lllamdo a cotización
    $(document).on('click','.kitinscription',function (event){
        //Método helper
        event.preventDefault();
        var kitselected = $(this).children('input[name="kit"]').val();
        var kitprice = parseFloat($(this).children('input[name="kitprice"]').val());
        var kitid = parseInt($(this).children('input[name="kitid"]').val());
        var kitname =$(this).children('input[name="kitname"]').val();
        var kitdescription =$(this).children('input[name="kitdescription"]').val();
        var kitimage = $(this).children('input[name="kitimage"]').val();

        $(".markrmv").attr('checked',false);
        $(this).children('input[name="kit"]').attr('checked',true);
        flushRegisterTransaction();

        var showPromotions = false;
        $.ajax({
            type: "POST",
            url: "{{ route('register.kitinitiquotation') }}",
            data: {'kitselected': kitselected,'price':kitprice,'kitid':kitid,'kitname':kitname,'kitdescription':kitdescription,'kitimage':kitimage,'iskit' : 1, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function(result) {

                if (result.status) {
                     var products = {};
                    $.each(result.products, function (i, item) {
                        products[item.id] = item;
                    });
                    document.shopping_cart = products;
                    ShoppingCart.update_items();

                    $("#error__box_ul_step3").html("");
                    $("#error_step3").hide();

                    $('div#cart-preview').find("#divResumeQuotationErrors").css('display','none');
                    $('div#cart-preview').find("#divResumeQuotationErrors").html("");


                    if (result.resultASW && result.resultASW.viewErrors) {
                        $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                        $('div#cart-preview').find("#divResumeQuotationErrors").css('display','inline-block');
                    }

                    if (result.resultASW && result.resultASW.existsPromotions) {
                        showPromotions = true;
                    }

                    getViewCartPreviewQuotation();
                    $("#choose").hide();
                    $("#banks").removeClass('hide hidden');
                    $("#hasQuotation").val(1);


                } else {
                    $('.loader').removeClass('show').addClass('hide');
                    $("#error_step3").show();
                    $("#error__box_ul_step3").html("");
                    $(".markrmv").attr('checked',false);
                    $("#hasQuotation").val(0);

                    $.each(result.messages, function (i, item) {
                            $("#error__box_ul_step3").append("<li class='text-danger'>"+item.messUser+"</li>");
                    });


                    if (result.resultASW.details != null) {
                        $("#banks").addClass('hide hidden');
                        $('#error__box_ul_step3').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.resultASW.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');




                }

            },
            error: function(result) {
                $('.loader').removeClass('show').addClass('hide');
                $(".markrmv").attr('checked',false);
                $('.bag_cart').hide();
                $("#hasQuotation").val(0);
            },
            beforeSend: function() {
                $('.loader').removeClass('hide').addClass('show');
                $('.bag_cart').hide();
                $("#hasQuotation").val(0);

            },
            complete: function() {
                $('.bag_cart').hide();
                if(showPromotions) {
                    getViewModalPromotions('register');
                }
            }
        });


   });


    $(document).on('click','.shipping_comp',function (event) {

        var company = $(this).children().val();
        var applies = $(this).children().attr('rel');
        event.preventDefault();
        $(this).children('input[name="shipping_way"]').prop('checked',true);

        //Guardar en la sesión la compañia seleccionada
        $.ajax({
            type: "POST",
            url: "{{ route('register.setcompany') }}",
            data: {'company':company, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(applies == 1){
                    var kitChecked = $('input[name=kit]:checked').val();

                    if(kitChecked){
                        var idSelected = $('input[name=kit]:checked').attr('id');
                        $('#' + idSelected).click();
                    }
                }



            },
            error:function(result){

            },
            beforeSend: function () {

            },
            complete: function () {
            }
        });



    });

    function getViewCartPreviewQuotation(){
        var url = '{{ route('register.quotation.getCartPreviewQuotation') }}';
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {

                if (result) {
                    $('div#cart-preview').find(".cart-preview__content").removeClass('hide hidden');
                    $('div#cart-preview').find(".cart-preview__resume").removeClass('hide hidden');
                    $('div#cart-preview').find(".cart-product__item").remove();
                    $('div#cart-preview').find(".cart-product__list").append(result.items);
                    $('div#cart-preview').find(".cart-preview__resume").html("");
                    $('div#cart-preview').find(".cart-preview__resume").append(result.totals);
                    $('div#cart-preview').removeClass("active");
                    //$('div#cart-preview').replaceWith(result);

                    /*document.getElementById("cart-preview").classList.add("ps");
                     document.getElementById("cart-preview").classList.add("ps--active-y");
                     */
                    $('div#cart-preview').removeClass("active");
                    $('.total_mov').text($('.cart__right #cart-resume #total').text());
                    $('.points_mov').text($('.cart__right #cart-resume #points').text());
                } else {
                    alert('No se cargo resumen de compra')
                }
            },
            complete: function () {
                $('.loader').removeClass('show').addClass('hide');
            },
            error: function() {
                $('.loader').removeClass('show').addClass('hide');
                $(".overlay").css("display",'none');
                $("#blank-overlay").css("display",'none');
            }
        });
    }




    //Se obtienes la ciudades al momento de cambiar el estado

    /* function updateSession(country){
        zipCodeSession = null;
        $.ajax({
            type: "POST",
            url: "{{ route('register.updatesession') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){
                loadView(result.country_name);

            },
            error:function(result){


            },
            beforeSend: function () {

            },
            complete: function () {
                $("#hasQuotation").val(0);
                $("#isback").val(0);
                $("#is_validated").val(0);
                getQuestions(country);
                getParameters(country);
                getLegalDocuments(country);
                getBanks(country);
                getKits(country);


            }
        });

    } */
    function validateStep1() {
        var url = "{{route('register.validate_step1')}}";
        var form = $('#formRegister');
        var tipo  = 'register';
        var step = 'step1';
        var nextStep = 'step2';

        validateFieldsPortal(url,form,tipo,step,nextStep);
    }
    function validateStep2() {
        var url = "{{route('register.validate_step2')}}";
        var form = $('#formRegister');
        var tipo  = 'register';
        var step = 'step2';
        var nextStep = 'step3';

        validateFieldsPortal(url,form,tipo,step,nextStep);
    }
    function validateStep3() {

        var url = "{{route('register.validate_step3')}}";
        var form = $('#formRegister');
        var tipo  = 'register';
        var step = 'step3';
        var nextStep = '';

        validateFieldsPortal(url,form,tipo,step,nextStep);
    }


    function backStep1(){
        window.history.back();
    }
    function backStep2(){
        var step = 'step2';
        var prevStep = 'step1';

        backStepPortal(step,prevStep);

        $.ajax({
            type: 'POST',
            url: "{{ route('register.backStep2') }}",
            data: {_token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success : function (data) {
            }
        });
    }

    function backStep3(){
        var step = 'step3';
        var prevStep = 'step2';
        //LLamado función ajax para preguntar si ya tiene una sesión de inscripcion si es así se borra para que se genere una transaccion en la bd
        $(".hide_cart_icon").show();
        $(".cart-preview__resume").addClass('hide hidden');
        $(".cart-preview__content").addClass('hide hidden');
        flushRegisterTransaction();
        backStepPortal(step,prevStep);
    }
    function loadView(con){

        $.ajax({
            type: 'POST',
            url: "{{ route('register.changeViews') }}",
            data: {'country':con, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success : function (data) {

                $("#form_included").html(data);

            }
        });
    }

    function flushRegisterTransaction(){

        $.ajax({
            type: 'POST',
            url: "{{ route('register.flushRegisterTransaction') }}",
            data: {_token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success : function (data) {

                $("input:radio[name='payment']").each(function(i) {
                    this.checked = false;
                });

                $(".payment-container").hide();
                $("#divppplus").hide();
                $("#generic_error").hide();


            }
        });
    }



    /* Registro Inconcluso */
    @if(session('modalExit'))
        $('#btnCancelModalExitRegister').click(function() {
        @if(session('stepUnfinished') != null)
        /* Tab Activa */
        $('#tab__step1').removeClass('active');
        $('#step1').removeClass('active');
        $('#tab__step' + '{{session('stepUnfinished')}}').addClass('active');
        $('#step' + '{{session('stepUnfinished')}}').addClass('active');
        @endif

            /* Carga de Datos al Formulario */
            var data    = jQuery.parseJSON('{!!session('dataUnfinished')!!}');
            var city    = '';
            var invited = '';
            var country = $("#current_country").val();

            if (data != null || data != '') {
                $.each(data, function(key, value) {
                    if (key == 'invited') {
                        if (value == 1) {
                            invited = 1;
                            $('#invited1').click();
                        }
                        else if (value == 0) {
                            invited = 0;
                            $('#invited2').click();
                        }
                    }
                    else if (key == 'sex') {
                        if (value == 'M') {
                            $('#sex1').click();
                        }
                        else if (value == 'F') {
                            $('#sex2').click();
                        }
                    }
                    else if (key == 'id_type' || key == 'id_num' || key == 'id_expiration' || key == 'id_type_name') {
                        $.each(value, function(key2, value2) {
                            $('#' + key + key2).val(value2);
                        });
                    }
                    else if (key == 'terms1' || key == 'terms2' || key == 'terms3') {
                        $('#' + key).prop('checked', true);
                    }
                    else {
                        $('#' + key).val(value);
                    }
                });

                getStates(country);
                @if(!isset($codEo) && !isset($numEo))
                    $('#invited-yes').removeClass('hidden hide');
                    $('#register-code').attr('readonly','readonly');
                    $('.radioEo').addClass('hidden hide');
                    $('#register-code').blur();
                    $('#invited1').prop('checked',true);
                    $(".normal").removeClass('hide hidden');
                   $(".sponsored").addClass('hide hidden');
                @else
                    $(".normal").addClass('hide hidden');
                    $(".sponsored").removeClass('hide hidden');
                    if (invited == 1) {
                        $('#register-code').blur();
                    }

                @endif
            }
        });
    @endif

    function getStates(country){
        //Llamado Secret Questions
        var stateHtml = '';
        $.ajax({
            type: "POST",
            url: "{{ route('register.states') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__box_ul_step2").html("");
                    $("#error_step2").hide();
                    $('#state').removeClass('has-error');
                    stateHtml += '<option value="">@lang("shopping::register.info.address.placeholders.state")</option>';

                    $.each(result.data, function (i, item) {
                        stateHtml += '<option value="'+$.trim(item.id)+'">' + $.trim(item.name) + '</option>';


                        /* $('#state').append($('<option>', {
                         value: item.id,
                         text : item.name
                         })); */
                    });
                    $("#state").html(stateHtml);

                    @if(session('modalExit'))
                    /* Carga de Datos al Formulario */
                    var data    = jQuery.parseJSON('{!!session('dataUnfinished')!!}');
                    var city    = '';

                    if (data != null || data != '') {
                        $.each(data, function (key, value) {
                            if (key == 'city_hidden' || key == 'city') {
                                if (value != null || value != '') {
                                    city = value;
                                }
                            }
                            else if (key == 'state_hidden' || key == 'state') {
                                if (value != null || value != '') {
                                    $('#state').val(value);
                                    $('#state_hidden').val(value);
                                }
                            }
                        });

                        getCities($('#state_hidden').val(), city);
                    }
                    @endif

                    if (zipCodeSession != null) {
                        getZipCodeFromCorbiz(zipCodeSession);
                    }


                }else{


                    $("#error_step2").show();
                    $("#error__box_ul_step2").html("");
                    $("#state").addClass("has-error");

                    $.each(result.messages, function(key, message) {
                        var id_error = (message.idError != '') ? ' (' + $.trim(message.idError) + ')' : '';
                        $('#error__box_ul_step2').append('<li>' + $.trim(message.messUser) + id_error + '</li>');
                    });

                    if (result.details != '') {
                        $('#error__box_ul_step2').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');


                }


            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__box_ul_step2").html("");
                $("#error_step2").hide();
                $("#state").children('option:not(:first)').remove();

            },
            complete: function () {

            }
        });
    }

    function getCities(state, city) {

        var htmlCities  = '';

        $.ajax({
            type: 'POST',
            url: "{{route('register.cities')}}",
            data: {'country': country, 'state': state, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function(result) {
                if (result.status) {
                    $("#error__box_ul_step1").html("");
                    $("#error__box_step1").hide();
                    $('#city').removeClass('has-error');

                    htmlCities += '<option value="default">@lang("shopping::register_customer.account.address.placeholders.city")*</option>';

                    $.each(result.data, function(i, item) {
                        htmlCities += '<option value="' + $.trim(item.id) + '">' + $.trim(item.name) + '</option>';
                    });

                    $("#city").html(htmlCities);
                    $('#city').val(city);
                    $('#city_hidden').val(city);

                    var cityText    = $('#city').find('option:selected').text();
                    $('#city_name').val(cityText);

                    getShippingCompanyFromCorbiz(state, city);
                }
                else {
                    $("#error__box_step1").show();
                    $("#error__box_ul_step1").html("");
                    $("#city").addClass("has-error");

                    $.each(result.messages, function (key, value) {
                        var id_error = (value.idError == '') ? '' : ' (' + value.idError + ')';
                        $('#error__box_ul_step1').append('<li>' + $.trim(value.messUser) + $.trim(id_error) + '</li>');
                    });

                    if (result.details != '') {
                        $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            error:function(result) {
            },
            beforeSend: function() {
                $("#error__box_ul_step1").html("");
                $("#error__box_step1").hide();
                $("#city").children('option:not(:first)').remove();
            },
            complete: function() {
            }
        });
    }

    //Se obtienen las preguntas secreteas cuando se cambia de país en el select
    function getQuestions(country){

        //Llamado Secret Questions
        $.ajax({
            type: "POST",
            url: "{{ route('register.questions') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.success){
                    $("#secret-question").children('option:not(:first)').remove();
                    $("#error-msg-questions").html("");
                    $('#secret-question').removeClass('has-error');

                    $.each(result.data, function (i, item) {

                        $('#secret-question').append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                    });


                }else{
                    $("#error-msg-questions").html(result.message);
                    $('#secret-question').addClass('has-error');
                }


            },
            error:function(result){

                $("#error-msg-questions").html(result.message);
            },
            beforeSend: function () {
                $("#secret-question").children('option:not(:first)').remove();
                //$("#save-product-information").prop('disabled', true);
            },
            complete: function () {

                //$("#save-product-information").prop('disabled', false);
            }
        });
    }

    function getParameters(country){
        //Llamado Parametros de Inscripcion
        $.ajax({
            type: "POST",
            url: "{{ route('register.parameters') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.success){
                    var info = result.data;
                    $("#error-msg-parameters").html("");
                    $('#year').removeClass('has-error');
                    for(x= info.fechain;x >= info.fecha_fin; x--){
                        $('#year').append($('<option>', {
                            value: x,
                            text : x
                        }));
                    }

                    if (info.has_documents == 1) {
                        $("#documents").show('fadeIn');
                        //llamado a documentos de corbiz por país
                        getDocumentsFromCorbiz(country);
                    }




                }else{
                    $("#error-msg-parameters").html(result.message);
                    $('#year').addClass('has-error');
                    $('#day').addClass('has-error');
                    $('#month').addClass('has-error');
                    $('#documents').hide();


                }


            },
            error:function(result){

                $("#error-msg-parameters").html(result.message);
            },
            beforeSend: function () {
                $("#error-msg-parameters").html("");

            },
            complete: function () {


            }
        });
    }

    function getLegalDocuments(country){
        $.ajax({
            type: "POST",
            url: "{{ route('register.legals') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){


                if(result.success){
                    var info = result.data;
                    var conf = result.config;

                    if(info.active_contract == 1){
                        $(".contract_option").show();
                        var path = URL_PROJECT + info.contract_html;
                        $("#obj").attr('data',path);
                        $("#downloadterms").attr('href',path);
                    } else{
                        $(".contract_option").hide();
                        $("#divToPrint").html("");
                    }
                    if(conf.active_transfer){
                        $(".transfer").show();
                    }else{
                        $(".transfer").hide();
                    }
                    if(conf.active_information){
                        $(".information").show();
                    }else{
                        $(".information").hide();
                    }







                }
                else{
                    $("#error-msg-parameters").html(result.message);
                    $('#year').addClass('has-error');
                    $('#day').addClass('has-error');
                    $('#month').addClass('has-error');
                    $('#documents').hide();
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');

                }


            },
            error:function(result){

                //$("#error-msg-parameters").html(result.message);
            },
            beforeSend: function () {
                // $("#error-msg-parameters").html("");

            },
            complete: function () {


            }
        });
    }

    function getBanks(country){
        //Llamado Parametros de Inscripcion
        $.ajax({
            type: "POST",
            url: "{{ route('register.banks') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.success){
                    var info = result.data;

                    $.each(info, function (i, item) {
                        $('<div class="form-radio card stack">' +
                            '<input type="radio" id="payment_'+i+'" name="payment" value='+item.id+'>' +
                            '<label class="card__content-wrap" for="payment_'+i+'">'+
                            '<div class="card__content">'+
                            '<label class="radio-fake" for="payment_'+i+'"></label><span class="radio-label">'+
                            item.name + ' <span class="small">'+item.description+'</span></span>'+
                            '</div>'+
                            '</label>'+
                            '</div>').appendTo("#banks");

                    });



                }else{
                    $("#error-msg-banks").html(result.message);


                }


            },
            error:function(result){
                $("#error-msg-banks").html(result.message);

            },
            beforeSend: function () {
                $("#banks").html("");

            },
            complete: function () {


            }
        });
    }

    function getKits(country){
        //Llamado Parametros de Inscripcion
        $.ajax({
            type: "POST",
            url: "{{ route('register.kits') }}",
            data: {'country':country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.success){
                    var info = result.data;


                    $.each(info, function (i, item) {


                        $('<div class="form-radio inline card kitinscription" data-radio="'+i+'">'+
                            ' <input type="radio" id="kit_'+i+'" class="'+item.sku+' markrmv" name="kit" value="'+item.sku+'">'+
                            ' <input type="hidden" id="kitprice_'+i+'" name="kitprice" value="'+item.price+'">'+
                            ' <input type="hidden" id="kitname_'+i+'" name="kitname" value="'+item.name+'">'+
                            ' <input type="hidden" id="kitdescription_'+i+'" name="kitdescription" value="'+item.description+'">'+
                            ' <input type="hidden" id="kitimage_'+i+'" name="kitimage" value="'+item.image+'">'+
                            ' <input type="hidden" id="kitid_'+i+'" name="kitid" value="'+item.id+'">'+
                            '<label class="card__content-wrap container-kit" for="kit_'+i+'">'+
                            '<figure class="card__img kit"><img src="'+item.image+'" alt=""></figure>'+
                            '<div class="card__content kit">'+
                            '<h3 class="card__title">'+item.name+'</h3>'+
                            ' <p class="card__price">$'+item.price+'</p>'+
                            '<label class="radio-fake" for="kit_'+i+'"></label><span class="radio-label">@lang("shopping::register.kit.choose")</span>'+
                            '</div>'+
                            '</label>'+
                            '</div>').appendTo("#kits");

                    });



                }else{
                    $("#error-msg-kits").html(result.message);
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');

                }


            },
            error:function(result){
                $("#error-msg-kits").html(result.message);

            },
            beforeSend: function () {
                $("#kits").html("");

            },
            complete: function () {


            }
        });
    }

    function getDocumentsFromCorbiz(country){
        var html = '';

        $.ajax({
            type: "POST",
            url: "{{ route('register.documents') }}",
            data: {'country': country, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function(result) {

                if (result.status) {
                    for (i = 1; i <= result.numDocs; i ++) {
                        html += '<div class="form-row">';
                        html += '<div class="form-label block">' + '{{trans("shopping::register_customer.account.identification.label")}}' + ' ' + i + '</div>';
                        html += '<div class="form-group select medium">';
                        html += '<select class="form-control" name="id_type[' + i + ']" id="id_type' + i + '" onchange="disableOptionDocument(' + i + ',' + result.numDocs + ')">';
                        html += '<option value="default">{{trans("shopping::register_customer.account.identification.option")}}</option>';
                        html += '<input type="hidden" name="id_type_name[' + i + ']" id="id_type_name' + i + '" value="" />';
                        html += '</select>';
                        html += '<div class="error-msg" id="div_id_type' + i + '"></div>';
                        html += '</div>';
                        html += '<div class="form-group medium">';
                        html += '<input class="form-control" type="text" name="id_num[' + i + ']" id="id_num' + i + '" placeholder="' + '{{trans("shopping::register_customer.account.identification.placeholder")}}' + '*">';
                        html += '<div class="error-msg" id="div_id_num' + i + '"></div>';
                        html += '</div>';
                        if(result.active_expiration){
                            html += '<div class="form-group medium">';
                            html += '<input class="form-control pickers" type="text" onfocus="openPicker(' + i + ')" name="id_expiration[' + i + ']" id="id_expiration' + i + '" placeholder="' + '{{trans("shopping::register_customer.account.expiration.placeholder")}}' + '*">';
                            html += '<div class="error-msg" id="div_id_expiration' + i + '"></div>';
                            html += '</div>';
                        }
                        html += '</div>';
                    }

                    $('#documents').html(html);

                    for (x = 1; x <= result.numDocs; x ++) {
                        $.each(result.data, function(i, item) {
                            $('#id_type' + x).append($('<option>', {
                                value:  item.id,
                                text:   item.name,
                            }));
                        });

                        if (x > 1) {
                            $('#id_type' + x).prop('disabled', true);
                            $('#id_num' + x).prop('readonly', true);
                            $('#id_expiration' + x).prop('readonly', true);
                        }
                    }
                }
                else {
                    $('#error_step2').show();
                    $('#error__box_ul_step2').html('');

                    $.each(result.messages, function (i, item) {
                        $('#error__box_ul_step2').append('<li>' + item + '</li>');
                    });
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            error: function(result) {

            },
            beforeSend: function() {
                $('#error_step2').hide();
                $('#error__box_ul_step2').html('');

            },
            complete: function() {
            }
        });
    }

    function disableOptionDocument(id,numDocs) {
        var typeText    = $('#id_type' + id).find('option:selected').text();
        var newId   = 0;
        $('#id_type_name' + id).val(typeText);
        if (id < numDocs) {
            newId = id + 1;

            for (x = newId; x <= numDocs; x ++) {
                $('#id_num' + id).val('');
                $('#id_num' + x).val('');

                $('#id_type' + x + ' option').each(function () {
                    $(this).removeAttr('disabled').removeClass('optionDisabled');
                });

                $('#id_type' + x).prop('disabled', true);
                $('#id_num' + x).prop('readonly', true);
                $('#id_expiration' + x).prop('readonly', true);
                $('#id_type' + x).children('option[value="default"]').prop('selected', true);

                for (y = 1; y <= id; y ++) {
                    $('#id_type' + x).children('option[value="' + $('#id_type' + y).val() + '"]').prop('disabled', true).addClass('optionDisabled');
                }
            }

            $('#id_type' + newId).prop('disabled', false);
            $('#id_num' + newId).prop('readonly', false);
            $('#id_expiration' + newId).prop('readonly', false);
        }
    }

    function openPicker(id){
        var item = id;

        $( "#id_expiration" + item)
            .datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1
            })
    }

    function getShippingCompanyFromCorbiz(state,city){
        var defaultCompany = '{{config('shopping.defaultValidationForm.'.session()->get('portal.register.country_corbiz').'.shipping_way')}}';

        $.ajax({
            type: "POST",
            url: "{{ route('register.shippingCompanies') }}",
            data: {'state':state,'city':city, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__box_ul_step3").html("");
                    $("#error_step3").hide();
                    $('#id_type').removeClass('has-error');

                    if(!$.trim(result.data)){
                        //validacion compañias de envio vacias
                        $("#error_step3").show();
                        $("#error__box_ul_step3").html("");
                        $("#error__box_ul_step3").append("<li class='text-danger'>"+translations.errorEmptyShippingCompanies+"</li>");
                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    }
                    else{
                        var shipping_way_active = '';

                        @if(session('modalExit'))
                        /* Carga de Datos al Formulario */
                        var data                = jQuery.parseJSON('{!!session('dataUnfinished')!!}');

                        if (data != null || data != '') {
                            $.each(data, function (key, value) {
                                if (key == 'shipping_way') {
                                    shipping_way_active = value;
                                }
                            });
                        }
                        @endif

                        $.each(result.data, function (i, item) {
                                var applyRequotation = item.appliesRequotation ? 1 : 0;
                                var valid = item.id;
                                var itemid = valid.replace(/\s/g, '');

                                if (shipping_way_active == item.id) {
                                    $('<div class="form-radio card shipping_comp ' + itemid + '">' +
                                        '<input name="shipping_way" type="radio" id="shipping_way_' + i + '"  value="' + item.id + '" rel="' + applyRequotation + '" checked>' +
                                        '<label class="card__content-wrap" for="shipping_way_' + i + '">' +
                                        '<div class="card__content">' +
                                        '<label class="radio-fake" for="shipping_way_' + i + '"></label><span class="radio-label">' + item.name + '</span>' +
                                        '</div>' +
                                        '</label>' +
                                        '</div>').appendTo("#shipping_companies");
                                }else {
                                    $('<div class="form-radio card shipping_comp ' + itemid + '">' +
                                        '<input name="shipping_way" type="radio" id="shipping_way_' + i + '"  value="' + item.id + '" rel="' + applyRequotation + '">' +
                                        '<label class="card__content-wrap" for="shipping_way_' + i + '">' +
                                        '<div class="card__content">' +
                                        '<label class="radio-fake" for="shipping_way_' + i + '"></label><span class="radio-label">' + item.name + '</span>' +
                                        '</div>' +
                                        '</label>' +
                                        '</div>').appendTo("#shipping_companies");
                                }

                            });
                    }




                }else{

                    $("#error_step3").show();
                    $("#error__box_ul_step3").html("");

                    $.each(result.messages, function (i, item) {
                        $("#error__box_ul_step3").append("<li class='text-danger'>"+item+"</li>");
                    });

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');


                }


            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__box_ul_step3").html("");
                $("#error_step3").hide();
                $("#shipping_companies").html("");

            },
            complete: function () {

                //si tenemos una compañia default la seleccionamos si no tomamos la primera
                @if(!session('modalExit'))
                /* Carga de Datos al Formulario */
                    if(defaultCompany){
                        $("." +  defaultCompany).click();
                    }else{

                        $("#shipping_way_0").click();
                    }
                @else
                    var data  = jQuery.parseJSON('{!!session('dataUnfinished')!!}');

                    if (data != null || data != '') {
                        $.each(data, function (key, value) {
                            if (key == 'kitselected') {
                               $("." + value).click();
                            }
                        });
                    }

                @endif

            }
        });
    }


    function clear_form_elements() {

        $("#form_included").find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });
    }

    function setHourTerms(id,checkmarked){
        $.ajax({
            type: "POST",
            url: "{{ route('register.checkedterms') }}",
            data: {'id':id,'checkmarked' : checkmarked, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.success){



                }else{

                }


            },
            error:function(result){

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });

    }


    function validateFormCorbiz(){
        $.ajax({
            type: "POST",
            url: "{{ route('register.validateFormCorbiz') }}",
            data: $('#formRegister').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#isback").val(0);
                    $("#error__box_ul_step1").html("");
                    $("#error_step1").hide();
                    $("#error__box_ul_step2").html("");
                    $("#error_step2").hide();
                    $("#error__box_ul_step3").html("");
                    $("#error_step3").hide();
                    $("generic_error").hide();

                    $('#tab__step2').removeClass('active');
                    $('#step2').removeClass('active');
                    $('#tab__step3').addClass('active');
                    $('#step3').addClass('active');
                    $('.tabs-static__item_step2').removeClass('active');
                    $('.tabs-static__item_step3').addClass('active');

                    $("#paypal-button").addClass('hide hidden');

                    //if($("#isback").val() == 0 && $("#hasQuotation").val() == 0) {

                        getShippingCompanyFromCorbiz($("#state").val(), $("#city").val());
                        getBanks(country);
                        getKits(country);
                        $("#banks").addClass('hide hidden');


                    //}




                }
                else{
                    $("#isback").val(1);
                    $("#error_step1").show();
                    $("#error__box_ul_step1").html("");
                    $("#error_step2").show();
                    $("#error__box_ul_step2").html("");
                    $("#error_step3").show();
                    $("#error__box_ul_step3").html("");

                    $.each(result.errors, function (i, message) {

                        $('#error__box_ul_step1').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');
                        $('#error__box_ul_step2').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');
                        $('#error__box_ul_step3').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');


                        if (message.idError == '10026') {
                            $('#street').removeClass('has-error').addClass('has-error');
                            $('#div_street').empty().append(translations.errorStreetCorbiz);
                        }

                    });

                    if (result.details != '') {
                        $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        $('#error__box_ul_step2').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');





                }


            },
            error:function(result){
                $("#isback").val(1);


            },
            beforeSend: function () {
                $("#isback").val(0);


            },
            complete: function () {

            }
        });
    }


    //Promotions

    $(document).on("click", ".close", function (){
        $(".overlay").css("display",'none');
        console.log("closed");
        $(this).closest("div.modal").removeClass("active");
    });




    function getViewModalPromotions(process){


        $.ajax({
            url: '/register/checkout/quotation/getViewModalPromotions/'+process,
            type: 'GET',
            success: function (result) {
                //
                //
                console.log("resultado " + result);
                if (result) {
                   
                    $('div#promo').replaceWith(result);
                    $(".overlay").css("display",'block');
                } else {
                    alert('No se cargo modal de promociones')
                }
            },
            complete: function () {
                $("div#promo").addClass('active');
                //$(".overlay").css("display",'block');
            },
            error: function() {
                $(".loader").removeClass("show");
                $(".overlay").css("display",'none');
            }
        });
    }

    function showHidePromo(idPromo){
        console.log(idPromo);
        var valCollapse = $('.modal__body').find('div#collapsePromo'+idPromo).is(":visible");
        if(valCollapse){
            $('.modal__body').find('div#collapsePromo'+idPromo).fadeOut();
            $('.modal__body').find('a#btnCollapsePromo'+idPromo).addClass('collapsed');
        } else {
            $('.modal__body').find('div#collapsePromo'+idPromo).fadeIn();
            $('.modal__body').find('a#btnCollapsePromo'+idPromo).removeClass('collapsed');
        }
    }

    /* function minusPromoOLD(idPromo, idLine) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
        var required = collapsePromo.find('input.promoRequired').val();

        if (parseInt(input.val()) > 0){
            /*if(parseInt(input.val()) === 1 && parseInt(required) === 1){
             alert("Esta promoción es obligatoria, la cantidad no puede ser menor a 1");
             } else {
            input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
            //}

        }

        $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));

        /*ShoppingCart.remove_one(id);
         if (parseInt(input.val()) === 0) {
         ShoppingCart.remove_item(id);
         }
    } */

    function minusPromo(idPromo, idLine) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
        var required = collapsePromo.find('input.promoRequired').val();

        if (parseInt(input.val()) > 0){
            /*if(parseInt(input.val()) === 1 && parseInt(required) === 1){
             alert("Esta promoción es obligatoria, la cantidad no puede ser menor a 1");
             } else {*/
            input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
            //}

        }

        $('div#collapsePromo'+idPromo).find("div.card").each(function() {
            if($(this).attr("id") === "div#promoLine"+idLine){
                $(this).find(".numeric").find('input').val(parseInt(input.val()));
            } else {
                $(this).find(".numeric").find('input').val(0);
            }
        });
        //$('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));

        /*ShoppingCart.remove_one(id);
         if (parseInt(input.val()) === 0) {
         ShoppingCart.remove_item(id);
         }*/
    }

    /* function plusPromoOLD(idPromo, idLine) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
        var maxQuantity = collapsePromo.find('input.maxQuantity').val();

        if (parseInt(input.val()) < parseInt(maxQuantity)) {
            input.val(parseInt(input.val()) + 1);
        }
        $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));
    } */

    function plusPromo(idPromo, idLine) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine).find(".numeric").find('input');
        var maxQuantity = collapsePromo.find('input.maxQuantity').val();

        if (parseInt(input.val()) < parseInt(maxQuantity)) {
            input.val(parseInt(input.val()) + 1);
        }
        $('div#collapsePromo'+idPromo).find("div.card").each(function() {
            if($(this).attr("id") === "promoLine"+idLine){
                $(this).find(".numeric").find('input').val(parseInt(input.val()));
            } else {
                $(this).find(".numeric").find('input').val(0);
            }
        });
        //$('div#collapsePromo'+idPromo).find("div#promoLine"+idLine).find(".numeric").find('input').val(parseInt(input.val()));
    }

    function minusPromoC(idPromo, idLine, sku) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input');
        var required = collapsePromo.find('input.promoRequired').val();

        if (parseInt(input.val()) > 0){
            input.val(parseInt(input.val()) > 0 ? parseInt(input.val()) - 1 : 0);
        }

        $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input').val(parseInt(input.val()));

        /*ShoppingCart.remove_one(id);
         if (parseInt(input.val()) === 0) {
         ShoppingCart.remove_item(id);
         }*/
    }

    function plusPromoC(idPromo, idLine, sku) {
        var collapsePromo = $('div#collapsePromo'+idPromo);
        var input = collapsePromo.find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input');
        var maxQuantity = collapsePromo.find('input.maxQuantity').val();
        var totalItemsC = 0;

        $('div#collapsePromo'+idPromo).find("div.card").each(function() {
            var valueCardC = $(this).find(".numeric").find('input').val();
            totalItemsC = totalItemsC + valueCardC;
        });

        if (parseInt(totalItemsC) < parseInt(maxQuantity)) {
            input.val(parseInt(input.val()) + 1);
        }
        $('div#collapsePromo'+idPromo).find("div#promoLine"+idLine+"-"+sku).find(".numeric").find('input').val(parseInt(input.val()));
    }

    $(document).on('click','#btnValidatePromos',function () {
        var process = $(this).closest(".modal-promos").find("input.process").val();
        validatePromos(process);
    });

    function validatePromos(process) {
        var url = "/register/checkout/quotation/validateQuantityPromos";
        var form = $("#form_quantityPromotions");

        validateQuantityPromos(url,form, process);
    }

    function validateQuantityPromos(url,form, process) {

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: form.serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (data) {
                console.log(data);
                if (data.success == true) {
                    $("div#promo").removeClass('active');
                    getInitQuotationPromos(process);
                }
                else if (data.success == false) {
                    $.each(data.messages, function(key, message) {
                        addErrorMsgValidatePromos(key, message);
                        $('.modal__body').find('div#collapsePromo'+key).fadeIn();
                        $('.modal__body').find('a#btnCollapsePromo'+key).removeClass('collapsed');
                    });
                }
            },beforeSend: function (){
                cleanMessagesvalidatePromos();
                $('.loader').removeClass('hide').addClass('show');

            },
            complete: function () {
                $('.loader').removeClass('show').addClass('hide');
            },
            error: function() {
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }

    function checkSelectPromo(checkPromo,idPromo,idLine) {
        var qtyCards = $("div#collapsePromo"+idPromo).find("div.card").length;
        console.log(checkPromo, qtyCards);

        if(qtyCards === 1) {
            $(checkPromo).toggleClass('hasChecked');
            if ($(checkPromo).hasClass('hasChecked')) {
                $(checkPromo).prop("checked", true);
            } else {
                $(checkPromo).prop("checked", false);
            }

        } else {
            $('div#collapsePromo'+idPromo).find("div.card").each(function() {
                $(this).find(".numeric").find('input').val(0);
            });
            $(this).closest("div.card").find(".numeric").find('input').val(1);
        }
    }

    function addErrorMsgValidatePromos(key, message) {
        $('#collapsePromo' + key).find(".numeric").find('input').addClass('has-error');
        $('#collapsePromo' + key).find(".card__content").find("span.radio-label").addClass('has-error');
        $('#div_msg_error_' + key).html(message);
    }

    function cleanMessagesvalidatePromos() {
        $('.has-error').removeClass('has-error');
        $('.error-msg').html('');
    }

    function getZipCodeFromCorbiz(zip) {
        $.ajax({
            url: "{{route('register.zipcode')}}",
            type: 'POST',
            dataType: 'JSON',
            data: { zipCode: zip },
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(result) {

                if(result.status){
                    $('#zip').val(result.suggestions[0].data.zipcode);
                    $('#state').val(result.suggestions[0].data.idState);
                    $('#state_hidden').val(result.suggestions[0].data.idState);

                    citybystate(result.suggestions[0].data.idState,result.suggestions[0].data.idCity,result.suggestions[0].data.cityDescr,urlcities,token,validate,tipo);

                    if (check == 'county') {
                        $('#colony').val(result.suggestions[0].data.county);
                    }
                    else if (check == 'suburb') {
                        $('#colony').val(result.suggestions[0].data.suburb);
                    }

                    $('#city_hidden').val(result.suggestions[0].data.idCity);

                    $('.loader').removeClass('show').addClass('hide');
                }else{
                    $('.loader').removeClass('show').addClass('hide');
                    $("#error_step2").show();
                    $("#error__box_ul_step2").html("");
                    $("#state").addClass("has-error");
                    $.each(result.messages, function (i, item) {

                        if(item.messUser == null){

                            $("#error__box_ul_step2").append("<li class='text-danger'>" + item + "</li>");

                        }else{

                            $("#error__box_ul_step2").append("<li class='text-danger'>" + item.messUser + "</li>");

                        }

                    });

                    if (result.details != '') {
                        $('#error__box_ul_step2').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }
                }

            },
            beforeSend: function() {
                $('.loader').removeClass('hide').addClass('show');
            },
            error: function(result) {
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }

    function getInitQuotationPromos(process){

        var kitselected = $('input[name="kit"]:checked').val();
        var kitidentifier = $('input[name="kit"]:checked').attr('id');
        var kitprice = $('#' + kitidentifier).siblings('input[name="kitprice"]').val();
        var kitid    = $('#' + kitidentifier).siblings('input[name="kitid"]').val();

        $(".markrmv").attr('checked',false);
        $('#' + kitidentifier).attr('checked',true);

        var showPromotions = false;

        $.ajax({
            url: "{{ route('register.getInitQuotationPromos') }}",
            type: 'POST',
            data: {'kitselected': kitselected,'price':kitprice,'kitid':kitid,'iskit' : 1,'fromChanged':true, _token: '{{csrf_token()}}'},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result) {

                if (result.status) {

                    $("#error__box_ul_step3").html("");
                    $("#error_step3").hide();

                    $('div#cart-preview').find("#divResumeQuotationErrors").css('display','none');
                    $('div#cart-preview').find("#divResumeQuotationErrors").html("");

                    if (result.resultASW && result.resultASW.viewErrors) {
                        $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                        $('div#cart-preview').find("#divResumeQuotationErrors").css('display','inline-block');
                    }

                    if (result.resultASW && result.resultASW.existsPromotions) {
                        showPromotions = true;
                    }

                    getViewCartPreviewQuotation();
                    $("#choose").hide();
                    $("#banks").removeClass('hide hidden');
                    $('.overlay').hide();





                } else {

                    $("#error_step3").show();
                    $("#error__box_ul_step3").html("");
                    $("#city").addClass("has-error");
                    $.each(result.messages, function (i, item) {
                        $("#error__box_ul_step3").append("<li class='text-danger'>"+item.messUser+"</li>");
                    });
                    $('.loader').removeClass('show').addClass('hide');
                    $('.overlay').hide();

                    if (result.resultASW.details != '') {
                        $("#banks").addClass('hide hidden');
                        $('#error__box_ul_step3').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.resultASW.details);
                    }



                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            complete: function () {
                $('.loader').removeClass('show').addClass('hide');
                $('.overlay').hide();
                $('.bag_cart').hide();
                //console.log("showPromotions: "+showPromotions);
                if(showPromotions) {
                    getViewModalPromotions(process);
                }
            },
            error: function() {
                $('.loader').removeClass('show').addClass('hide');
                $('.overlay').hide();
            }
        });
    }







</script>
