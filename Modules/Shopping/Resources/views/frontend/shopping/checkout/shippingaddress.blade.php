{!! PageBuilder::section('head', [
    'shoppingCart' => \App\Helpers\ShoppingCart::getItems(\App\Helpers\SessionHdl::getCorbizCountryKey()),
    'currency'     => \App\Helpers\SessionHdl::getCurrencyKey(),
    'subtotal'     => \App\Helpers\ShoppingCart::getSubtotalFormatted(\App\Helpers\SessionHdl::getCorbizCountryKey(), \App\Helpers\SessionHdl::getCurrencyKey()),
    'points'       => \App\Helpers\ShoppingCart::getPoints(\App\Helpers\SessionHdl::getCorbizCountryKey()),
    'title'        => trans('shopping::checkout.title')
]) !!}
<script type='text/javascript' src="{{ asset('cms/jquery/jquery.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('/js/jquery.autocomplete.js') }}"></script>
<script src="{{ PageBuilder::js('resume_cart_checkout_old_browsers') }}"></script>
{!! PageBuilder::section('loader') !!}
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<div class="cart fullsteps register">
    <nav class="tabs-static">
        <div class="wrapper">
            <!--registro barra pasos-->
            <ul class="list-nostyle tabs-static__list">
                <li id="tab__step1" class="tabs-static__item active">{!! trans('shopping::shippingAddress.tag_shipping_address') !!}</li>
                <li id="tab__step2" class="tabs-static__item">{!! trans('shopping::shippingAddress.tag_way_to_pay') !!}</li>
                <li id="tab__step3" class="tabs-static__item">{!! trans('shopping::shippingAddress.tag_confirm') !!}</li>
            </ul>
        </div>
    </nav>
    <div class="cart__main">
        <div class="wrapper">
            <div class="cart__content">
                <div class="cart__left">
                    <div id="title-checkout" class="cart__main-title">@lang('shopping::checkout.checkout')</div>
                    <div class="step step1 fade-in-down active" id="step1">
                        <br>
                        <div class="cart__main-subtitle">@lang('shopping::shippingAddress.select_new_shipping_address')</div>
                        <div class="error__box" id="error_step1" style="display: none;">
                            <span class="error__single">
                                <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                            </span>
                            <ul id="error__boxSA_ul_step1">
                            </ul>
                        </div>

                        <div class="alert alert-green  alert-success-green  alert-dismissible" id="success_step1" style="display: none;">
                            <button type="button" class="close-alert-green" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>@lang('shopping::shippingAddress.success')</strong>
                            <ul id="success__boxSA_ul_step1">
                            </ul>
                        </div>

                        <div class="form-group listShipmentAddress"></div>
                        <br>
                        <div class="form-group">
                            <div align="left" style="width: 100%">
                                <button id="btnAddressAdd" class="button small new-address" type="button">
                                    + @lang('shopping::shippingAddress.add_address')</button>
                            </div>
                        </div>


                        <div class="buttons-container">
                            <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}"><button class="button secondary small" type="button">@lang('shopping::checkout.keep_buying')</button></a>
                            <button id="buttonToStep2" class="button small" type="button"
                                    style="display:{{session()->has('portal.checkout.'.session()->get('portal.main.country_corbiz').'.quotation') ? 'inline-block' : "none"}}">@lang('shopping::checkout.continue_payment')</button>
                        </div>
                    </div>
                    <!-- Payment -->
                    <div class="step step2 fade-in-down" id="step2">
                        <div id="form-payment"></div>
                        <div class="buttons-container">
                            <button id="to-step1" class="button secondary small" type="button" data-to="step1">@lang('shopping::checkout.return')</button>

                            @php $banks = \Modules\Shopping\Entities\Bank::whereHas('banksCountry', function ($q) { $q->where('country_id', \App\Helpers\SessionHdl::getCountryID()); })->where('active', 1)->where('delete', 0)->get(); @endphp
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

                        @foreach ($banks as $bank)
                            @if ($bank->bank_key == 'PAYPAL_PLUS')
                                <div id="divppplus" style="display: none; text-align: center;">
                                    <h3 style="border-top-style: solid;border-bottom-style: solid;border-top-width: 1px;border-bottom-width: 1px;border-top-color: rgba(0,0,0,0.1);border-bottom-color: rgba(0,0,0,0.1);font-weight: lighter;padding: 5px 0;">@lang('shopping::checkout.payment.card_pplus')</h3>
                                    <div id="ppplus" style="border:none; margin: 0 auto;"></div>
                                    <div id="ppplusmini"></div>
                                    <form id="f_ejecuta_pago" method="POST" action="{{ route('paypalplus.process') }}">
                                        <input type="hidden" id="i_pay_id" name="paymentID" value="">
                                        <input type="hidden" id="i_payerId" name="payerID" value="">
                                        <input type="hidden" id="i_token" name="token" value="">
                                        <input type="hidden" id="i_term" name="term" value="">
                                    </form>
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

                    </div>
                </div>

                <!-- cart preview-->
            @if(View::exists("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".cart_preview_".strtolower(session()->get('portal.main.country_corbiz'))))
                @include("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".cart_preview_".strtolower(session()->get('portal.main.country_corbiz')))
            @endif
            <!-- end cart preview-->
            </div>

        </div>
    </div>

    <input type="hidden" id="current_country" value="{{session()->has("portal.main.country_corbiz") ? session()->get("portal.main.country_corbiz") : 0}}">
    <input type="hidden" id="current_language" value="{{session()->has("portal.main.language_corbiz") ? session()->get("portal.main.language_corbiz") : ""}}">
    <input type="hidden" id="order">
</div>

@if(View::exists("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".form_shippingaddress_".strtolower(session()->get('portal.main.country_corbiz'))))
    @include("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".form_shippingaddress_".strtolower(session()->get('portal.main.country_corbiz')))
@endif

@if(View::exists("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".modal_edit_shippingaddress_".strtolower(session()->get('portal.main.country_corbiz'))))
    @include("shopping::frontend.shopping.includes.".strtolower(session()->get('portal.main.country_corbiz')).".modal_edit_shippingaddress_".strtolower(session()->get('portal.main.country_corbiz')))
@endif

<div class="modal alert address" id="addressDelete">
    <button class="button secondary close modal-close" type="button">X</button>
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title highlight">@lang('shopping::shippingAddress.delete_address')</h5>
        </header>
        <div class="modal__body">
            <div class="card__content">
                <h4>@lang('shopping::shippingAddress.msg_confirm_delete_address')</h4>
            </div>
            <div class="error__box" id="error_step1_modal_delete" style="display: none;">
                <span class="error__single">
                    <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">@lang('shopping::shippingAddress.we_have_a_problem'):
                </span>
                <ul id="error__boxSA_ul_step1_modal_delete"></ul>
            </div>
        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button class="button secondary close" type="button">@lang('shopping::shippingAddress.cancel')</button>
                <button class="button primary btnConfirmDelete" type="button" >@lang('shopping::shippingAddress.delete')</button>
                <input type="hidden" id="idfolio" value="">
            </div>
        </footer>
    </div>
</div><!-- Temp markup -->


<!-- ends footer--><!-- Alert -->
<div class="modal alert" id="alertShippingAddress">
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h2 class="highlight"></h2>
        </header>
        <div class="modal__body">
            <p></p>
        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button class="button primary close" type="button">@lang('shopping::shippingAddress.accept')</button>
            </div>
        </footer>
    </div>
</div><!-- Temp markup -->

<div class="modal alert address" id="addressSuccess">
    <button class="button secondary close modal-close" type="button">X</button>
    <div class="modal__inner ps-container">
        <header class="modal__head">
            <h5 class="modal__title highlight"></h5>
        </header>
        <div class="modal__body">

        </div>
        <footer class="modal__foot">
            <div class="buttons-container">
                <button class="button secondary close" type="button">@lang('shopping::shippingAddress.close')</button>
            </div>
        </footer>
    </div>
</div><!-- Temp markup -->

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
            <p>@lang('shopping::checkout.payment.modal.loader.p2')</p>
        </header>
    </div>
</div>

{!! PageBuilder::section('footer', ['isInShoppingView' => true,'isRegister' => false]) !!}
@include("shopping::frontend.shopping.includes.promotions.modal_promo")
<script type="text/javascript" >

    var country = $("#current_country").val();
    var language = $("#current_language").val();
    var products_route = "{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}";
    var checkout_route = "{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('checkout', \App\Helpers\SessionHdl::getLocale()) }}";

    var defaultZipcode = "{{ Session::has('portal.main.zipCode') ? Session::get('portal.main.zipCode') : 0 }}";

    var firstQuotation = true;
    var modal_alerts = {
        title_empty_list_address: "{{trans('shopping::shippingAddress.modal_alerts.title_empty_list_address')}}",
        empty_list_address: "{{trans('shopping::shippingAddress.modal_alerts.empty_list_address')}}",
        title_auto_quatotion_zip_start: "{{trans('shopping::shippingAddress.modal_alerts.title_auto_quatotion_zip_start')}}",
        auto_quatotion_zip_start: "{{trans('shopping::shippingAddress.modal_alerts.auto_quatotion_zip_start')}}",
        title_auto_quotation_one_address: "{{trans('shopping::shippingAddress.modal_alerts.title_auto_quotation_one_address')}}",
        auto_quotation_one_address: "{{trans('shopping::shippingAddress.modal_alerts.auto_quotation_one_address')}}",
        title_no_match_zip_listAddress: "{{trans('shopping::shippingAddress.modal_alerts.title_no_match_zip_listAddress')}}",
        no_match_zip_listAddress: "{{trans('shopping::shippingAddress.modal_alerts.no_match_zip_listAddress')}}",
        title_select_add_no_match_zip: "{{trans('shopping::shippingAddress.modal_alerts.title_select_add_no_match_zip')}}",
        select_add_no_match_zip: "{{trans('shopping::shippingAddress.modal_alerts.select_add_no_match_zip')}}",
        title_msg_error_get_quotation: "{{trans('shopping::shippingAddress.modal_alerts.title_msg_error_get_quotation')}}",
        msg_error_get_quotation: "{{trans('shopping::shippingAddress.modal_alerts.msg_error_get_quotation')}}",
    };


    var translations = {
        errorEmptyShippingCompanies:  '{{ trans("shopping::register.kit.shippingCompanies_empty") }}',
        moreDetails : '{{trans("cms::errors.modal.more")}}'
    };

    @if ((config('settings::frontend.webservices') == 1) && (session()->has("portal.main.shopping_active") == 1))

    function getShippingAddress(getFromWS, start, folioAddAddressDefault){
        var url = URL_PROJECT+'/shopping/checkout/getShippingAddress/'+getFromWS;
        //var defaultZipcode = 0;
        var defaultShippmentAddress = false;
        var emptyListAddress = false;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                console.log(data);
                if (data.success || data.listShipmentAddress !== "") {
                    var listShipmentAddress = $('.listShipmentAddress');
                    listShipmentAddress.empty();
                    if(data.listShipmentAddress !== "") {
                        if (data.defaultZipcode) {
                            $("#zip").val(data.defaultZipcode);
                            defaultZipcode = data.defaultZipcode;
                        }

                        if(folioAddAddressDefault){
                            defaultShippmentAddress = folioAddAddressDefault;
                        } else {
                            defaultShippmentAddress = data.defaultShippmentAddress;
                        }

                        listShipmentAddress.empty();
                        $.each(data.listShipmentAddress, function (index, value) {
                            var newShipmentAddress = '';

                            if (value.correct) {
                                newShipmentAddress += '<div class="form-radio card stack">';
                                if (getFromWS === 1 && value.folio === defaultShippmentAddress) {
                                    newShipmentAddress += '<input type="radio" id="address' + value.folio + '" class="btnAddressChecked" name="address" value="' + value.folio + '" checked="checked">';
                                } else {
                                    newShipmentAddress += '<input type="radio" id="address' + value.folio + '" class="btnAddressChecked" name="address" value="' + value.folio + '">';
                                }
                                newShipmentAddress += '<label class="card__content-wrap" for="address' + value.folio + '">';
                            } else {
                                if(value.folio === defaultShippmentAddress){
                                    defaultShippmentAddress = false;
                                }

                                newShipmentAddress += '<div class="form-radio error__box card stack">' +
                                    '<span class="error__single">' +
                                    '@lang('shopping::shippingAddress.msg_address_error')' +
                                    '</span>';
                            }

                            newShipmentAddress += '<div class="card__content">' +
                                '<input type="hidden" class="valueFolio" name="folio" value="' + value.folio + '">' +
                                '<a class="ezone__info-edit checkout edit_sa_modal" href="#">';
                            if (value.permissions.canEdit) {
                                newShipmentAddress += '<figure class="icon icon-edit">' +
                                    '<span class="icon-edit__text">{{trans("shopping::shippingAddress.edit")}}</span>' +
                                    '<img src="{{ asset('themes/omnilife2018/images/icons/edit.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.edit")}}">' +
                                    '</figure>' +
                                    '</a>';
                            }
                            if (value.type === "ALTERNA" && value.permissions.canDelete) {
                                newShipmentAddress += '<a href="#" class="ezone__info-delete checkout delete_sa_modal">' +
                                    '<figure class="icon icon-delete">' +
                                    '<span class="icon-edit__text">{{trans("shopping::shippingAddress.delete")}}</span>' +
                                    '<img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.delete")}}">' +
                                    '</figure>' +
                                    '</a>';
                            }
                            newShipmentAddress += '<label class="radio-fake" for="address' + value.folio + '"></label>' + value.labelSA +
                                //'<span class="radio-label">'+value.Etiqueta+'<span class="small">'+value.Direccion+', '+ value.Colonia+', '+ value.Ciudad +' '+ value.Estado+'</span>'+
                                '</span>' +
                                '</div>' +
                                '</label>' +
                                '</div>';
                            listShipmentAddress.append(newShipmentAddress);
                        });
                        //$("#buttonToStep2").css('display','inline-block');
                    } else {
                        emptyListAddress = true;
                        $("div#cart-preview").find("#cart-list").find(".form-control.number").attr("disabled", "disabled");
                        $("div#cart-preview").find("#cart-list").find("div.bin").remove();

                        var msg_no_direcctions ="<div class='error__box theme__transparent' style='display: inline-block; font-size: 0.85em; padding: 10px; margin: 0 auto;width: 100%;text-align: center;border: 2px solid #fcb219;'>" +
                            "<ul style='list-style: none; padding: 0px;'>" +
                            "<li>{{ trans('shopping::shippingAddress.msg_not_address') }}</li>" +
                            "</ul>" +
                            "</div>";

                        listShipmentAddress.append(msg_no_direcctions);

                        $("#buttonToStep2").css('display','none');

                        $(".overlay").css("display",'block');
                    }

                    $(".loader").removeClass("show");

                }

                if (!data.success){
                    $('div#error_step1').css('display','inline-block');
                    if(start !== 1){
                        $("ul#error__boxSA_ul_step1").html("");
                    }

                    $.each(data.error, function( index, value ) {
                        $('ul#error__boxSA_ul_step1').append("<li>"+value+"</li>");
                    });

                    if (data.details != '') {
                        $('div#error_step1')
                            .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(data.details);
                    }

                    $(".loader").removeClass("show");
                }
            },
            beforeSend: function () {
                $(".loader").addClass("show");
            },
            complete: function () {
//                $(".loader").removeClass("show");

                //return defaultShippmentAddress;
                setTimeout(
                    function() {
                        if(getFromWS === 1 && defaultShippmentAddress !== false){
                            $(".loader").addClass("show");
                            selectShippingAddress(defaultShippmentAddress);
                        } else {
                            $("#buttonToStep2").css('display','none');
                            $("#cart-resume").html("");
                            if(emptyListAddress){
                                $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_empty_list_address);
                                $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.empty_list_address);
                                $(".overlay").css("display",'block');
                            } else {
                                if(start == 1){
                                    $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_no_match_zip_listAddress);
                                    $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.no_match_zip_listAddress);
                                    $(".overlay").css("display",'block');
                                }
                            }
                            $(".loader").removeClass("show");
                        }
                    }, 1000);
            },
            error: function (jqXHR, timeout, message) {
                $(".loader").removeClass("show");
               var contentType = jqXHR.getResponseHeader("Content-Type");
               if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                   window.location.reload();
               }

                return false;
            }
        });
    }

    function getShippingAddressInit(getFromWS, start){
        return new Promise (function(resolve, reject){
            var url = URL_PROJECT+'/shopping/checkout/getShippingAddress/'+getFromWS;
            //var defaultZipcode = 0;
            var defaultShippmentAddress = false;
            var emptyListAddress = false;
            var hasError = false;
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    if (data.success || data.listShipmentAddress !== "") {
                        var listShipmentAddress = $('.listShipmentAddress');
                        listShipmentAddress.empty();

                        if (data.defaultZipcode) {
                            $("#zip").val(data.defaultZipcode);
                            defaultZipcode = data.defaultZipcode;
                        }

                        if(data.listShipmentAddress !== "") {
                            $.each(data.listShipmentAddress, function (index, value) {
                                var newShipmentAddress = '';

                                if (value.correct) {
                                    newShipmentAddress += '<div class="form-radio card stack">';
                                    if (getFromWS === 1 && value.folio === data.defaultShippmentAddress) {
                                        defaultShippmentAddress = data.defaultShippmentAddress;
                                        newShipmentAddress += '<input type="radio" id="address' + value.folio + '" class="btnAddressChecked" name="address" value="' + value.folio + '" checked="checked">';
                                    } else {
                                        newShipmentAddress += '<input type="radio" id="address' + value.folio + '" class="btnAddressChecked" name="address" value="' + value.folio + '">';
                                    }
                                    newShipmentAddress += '<label class="card__content-wrap" for="address' + value.folio + '">';
                                } else {
                                    if(value.folio === defaultShippmentAddress){
                                        defaultShippmentAddress = false;
                                    }
                                    newShipmentAddress += '<div class="form-radio error__box card stack">' +
                                        '<span class="error__single">' +
                                        '@lang('shopping::shippingAddress.msg_address_error')' +
                                        '</span>';
                                }

                                newShipmentAddress += '<div class="card__content">' +
                                    '<input type="hidden" class="valueFolio" name="folio" value="' + value.folio + '">' +
                                    '<a class="ezone__info-edit checkout edit_sa_modal" href="#">';
                                if (value.permissions.canEdit) {
                                    newShipmentAddress += '<figure class="icon icon-edit">' +
                                        '<span class="icon-edit__text">{{trans("shopping::shippingAddress.edit")}}</span>' +
                                        '<img src="{{ asset('themes/omnilife2018/images/icons/edit.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.edit")}}">' +
                                        '</figure>' +
                                        '</a>';
                                }
                                if (value.type === "ALTERNA" && value.permissions.canDelete) {
                                    newShipmentAddress += '<a href="#" class="ezone__info-delete checkout delete_sa_modal">' +
                                        '<figure class="icon icon-delete">' +
                                        '<span class="icon-edit__text">{{trans("shopping::shippingAddress.delete")}}</span>' +
                                        '<img src="{{ asset('themes/omnilife2018/images/icons/bin.svg') }}" alt="OMNILIFE - {{trans("shopping::shippingAddress.delete")}}">' +
                                        '</figure>' +
                                        '</a>';
                                }
                                newShipmentAddress += '<label class="radio-fake" for="address' + value.folio + '"></label>' + value.labelSA +
                                    '</span>' +
                                    '</div>' +
                                    '</label>' +
                                    '</div>';
                                listShipmentAddress.append(newShipmentAddress);
                            });
                            //$("#buttonToStep2").css('display','inline-block');
                        } else {
                            emptyListAddress = true;

                            $("div#cart-preview").find("#cart-list").find(".form-control.number").attr("disabled", "disabled");
                            $("div#cart-preview").find("#cart-list").find("div.bin").remove();
                            var msg_no_direcctions ="<div class='error__box theme__transparent' style='display: inline-block; font-size: 0.85em; padding: 10px; margin: 0 auto;width: 100%;text-align: center;border: 2px solid #fcb219;'>" +
                            "<ul style='list-style: none; padding: 0px;'>" +
                            "<li>{{ trans('shopping::shippingAddress.msg_not_address') }}</li>" +
                            "</ul>" +
                            "</div>";

                            listShipmentAddress.append(msg_no_direcctions);

                            $("#buttonToStep2").css('display','none');

                            $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_empty_list_address);
                            $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.empty_list_address);
                            $(".overlay").css("display",'block');
                        }


                        $(".loader").removeClass("show");

                    }

                    if (!data.success){
                        hasError = true;
                        $('div#error_step1').css('display','inline-block');
                        if(start !== 1){
                            $("ul#error__boxSA_ul_step1").html("");
                        }

                        $.each(data.error, function( index, value ) {
                            $('ul#error__boxSA_ul_step1').append("<li>"+value+"</li>");
                        });

                        if (data.details != '') {
                            $('div#error_step1')
                                .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(data.details);
                        }

                        $("#buttonToStep2").css('display','none');
                        $(".loader").removeClass("show");
                    }
                },
                beforeSend: function () {
                    $(".loader").addClass("show");
                },
                complete: function () {
                    if(hasError && emptyListAddress){
                        reject(false);
                    } else {
                        var result = {defaultShippmentAddress:defaultShippmentAddress ,
                            emptyListAddress: emptyListAddress
                        };

                        resolve(result);
                    }
                },
                error: function (jqXHR, timeout, message) {
                    $(".loader").removeClass("show");
                    var contentType = jqXHR.getResponseHeader("Content-Type");
                    if (jqXHR.status === 200 && contentType.toLowerCase().indexOf("text/html") >= 0) {
                        window.location.reload();
                    }

                    reject(false);
                }
            });
        });
    }

    function selectShippingAddressInit(folio){
        return new Promise (function(resolve, reject) {
            $(".loader").addClass("show");

            var resultResolve = {
                showPromotions : false,
                zipcodeFolio : false
            };
            var url = URL_PROJECT+'/shopping/checkout/selectShippingAddress/' + folio;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                    if (result.status) {
                        resultResolve.zipcodeFolio = result.zipcode;
                        var products = {};
                        $.each(result.products, function (i, item) {
                            products[item.id] = item;
                        });
                        document.shopping_cart = products;
                        ShoppingCart.update_items();

                        /*$('div#error_step1').css('display', 'none');
                        $("ul#error__boxSA_ul_step1").html("");*/

                        $('div#cart-preview').find("#divResumeQuotationErrors").css('display', 'none');
                        $('div#cart-preview').find("#divResumeQuotationErrors").html("");

                        if (result.resultASW) {
                            if (result.resultASW.viewErrors) {
                                $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                                $('div#cart-preview').find("#divResumeQuotationErrors").css('display', 'inline-block');

                                if (result.resultASW.details != '') {
                                    $('div#cart-preview').find("#divResumeQuotationErrors").find('#error__box-resumeQuotation')
                                        .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                                    setErrors(result.resultASW.details);
                                }
                            }

                            if (result.resultASW.existsPromotions) {
                                resultResolve.showPromotions = true;
                            }

                            if (result.resultASW.showButtonProducts) {
                                $("#buttonToStep2").remove();
                                $(".btnAddressChecked").remove();
                                $(".radio-fake").remove();
                                $("#cart-resume").remove();

                            } else {
                                $("#buttonToStep2").css('display','inline-block');
                            }
                        }

                        $("div#change_period_step1").show();
                        //$("#buttonToStep2").css('display','inline-block');

                    } else {
                        if (result.messages == undefined) {
                            window.location.reload();
                        }

                        $('div#cart-preview').find("#divResumeQuotationErrors").css('display', 'none');
                        $('div#cart-preview').find("#divResumeQuotationErrors").html("");

                        if (result.resultASW) {
                            if (result.resultASW.viewErrors) {
                                $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                                $('div#cart-preview').find("#divResumeQuotationErrors").css('display', 'inline-block');

                                if (result.resultASW.details != '') {
                                    $('div#cart-preview').find("#divResumeQuotationErrors").find('#error__box-resumeQuotation')
                                        .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                                    setErrors(result.resultASW.details);
                                }
                            }

                            if (result.resultASW.showButtonProducts) {
                                $("#buttonToStep2").remove();
                                $(".btnAddressChecked").remove();
                                $(".radio-fake").remove();
                                $("#cart-resume").remove();

                            }
                        }

                        $('div#error_step1').css('display', 'inline-block');
                        $("ul#error__boxSA_ul_step1").html("");
                        $('ul#error__boxSA_ul_step1').append("<li>" + result.messages + "</li>");

                        $("div#change_period_step1").hide();

                        $(".loader").removeClass("show");
                    }
                },
                beforeSend: function () {
                    $(".loader").addClass("show");
                },
                complete: function () {
                    console.log("showPromotions: " + resultResolve.showPromotions);
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                    resolve(resultResolve);

                },
                error: function () {
                    $(".loader").removeClass("show");
                    reject(false);
                }
            });
        });
    }
    @endif




    $(document).on("click", ".delete_sa_modal", function (){
        $("#error__boxSA_ul_step1_modal_delete").html("");
        $("#error_step1_modal_delete").hide();
        var valueFolio = $(this).closest(".card__content").find(".valueFolio").val();
        $("#addressDelete").find("#idfolio").val(valueFolio);
        $("#addressDelete").addClass("active");
        $(".overlay").css("display",'block');

    });

    $(document).on("click", ".close", function (){
        document.getElementById("form_editShippingAddress").reset();

        document.getElementById("form_addShippingAddress").reset();

        $(".overlay").css("display",'none');
        $(this).closest("div.modal").removeClass("active");
    });

    $(document).on("click", ".btnConfirmDelete", function (){

        var idfolio = $("#addressDelete").find("#idfolio").val();

        $.ajax({
            type: "POST",
            url: "{{ route("checkout.shippingAddress.deleteShipmentAddress") }}",
            data: {folio:idfolio,country:country,lang:language},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            success: function (result){

                if(result.status){
                    $("#error__boxSA_ul_step1_modal_delete").html("");
                    $("#error_step1_modal_delete").hide();
                    $("#addressDelete").removeClass("active");
                    $(".overlay").css("display",'none');

                    getShippingAddress(1,0,false);

                    $("#success_step1").show();
                    $("#success__boxSA_ul_step1").html("");
                    $("#success__boxSA_ul_step1").append("<li class='text-success'>"+result.message_modal+"</li>");

                }else{

                    $("#error_step1_modal_delete").show();
                    $("#error__boxSA_ul_step1_modal_delete").html("");
                    $.each(result.messages, function (i, item) {
                        $("#error__boxSA_ul_step1_modal_delete").append("<li class='text-danger'>"+item+"</li>");
                    });

                    if (result.details != '') {
                        $("#error__boxSA_ul_step1_modal_delete")
                            .append('<br><div align="left"><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a></div>');
                        setErrors(result.details);
                    }

                }
            },
            error:function(result){

            },
            beforeSend: function () {
                $("#error__boxSA_ul_step1").html("");
                $("#error_step1").hide();
            },
            complete: function () {

            }
        });
    });

    $(document).on("click", ".btnAddressChecked", function (){
        var valChecked = $(this).val();
        selectShippingAddress(valChecked);
    });

    function selectShippingAddress(folio){
        $(".loader").addClass("show");

        var showPromotions = false;
        var url = URL_PROJECT+'/shopping/checkout/selectShippingAddress/'+folio;
        var zipcodeFolio = false;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                if (result.status) {
                    zipcodeFolio =result.zipcode;
                    var products = {};
                    $.each(result.products, function (i, item) {
                        products[item.id] = item;
                    });
                    document.shopping_cart = products;
                    ShoppingCart.update_items();


                    /*$('div#error_step1').css('display','none');
                    $("ul#error__boxSA_ul_step1").html("");*/

                    $('div#cart-preview').find("#divResumeQuotationErrors").css('display','none');
                    $('div#cart-preview').find("#divResumeQuotationErrors").html("");

                    if (result.resultASW ) {
                        if(result.resultASW.success){
                            $("#buttonToStep2").css('display','inline-block');
                        } else {
                            $("#buttonToStep2").css('display','none');
                        }
                        if(result.resultASW.viewErrors){
                            $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                            $('div#cart-preview').find("#divResumeQuotationErrors").css('display','inline-block');

                            if (result.resultASW.details != '') {
                                $('div#cart-preview').find("#divResumeQuotationErrors").find('#error__box-resumeQuotation')
                                    .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                                setErrors(result.resultASW.details);
                            }
                        }

                        if (result.resultASW.existsPromotions) {
                            showPromotions = true;
                        }

                        if (result.resultASW.showButtonProducts) {
                            $("#buttonToStep2").remove();
                            $(".btnAddressChecked").remove();
                            $(".radio-fake").remove();
                            $("#cart-resume").remove();

                        }
                    }
                    $("div#change_period_step1").show();

                } else {
                    if (result.messages == undefined) {
                        window.location.reload();
                    }

                    $('div#cart-preview').find("#divResumeQuotationErrors").css('display','none');
                    $('div#cart-preview').find("#divResumeQuotationErrors").html("");

                    if (result.resultASW ) {
                        if(result.resultASW.success){
                            $("#buttonToStep2").css('display','inline-block');
                        } else {
                            $("#buttonToStep2").css('display','none');
                        }

                        if(result.resultASW.viewErrors){
                            $('div#cart-preview').find("#divResumeQuotationErrors").append(result.resultASW.viewErrors);
                            $('div#cart-preview').find("#divResumeQuotationErrors").css('display','inline-block');

                            if (result.resultASW.details != '') {
                                $('div#cart-preview').find("#divResumeQuotationErrors").find('#error__box-resumeQuotation')
                                    .append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                                setErrors(result.resultASW.details);
                            }
                        }

                        if (result.resultASW.showButtonProducts) {
                            $("#buttonToStep2").remove();
                            $(".btnAddressChecked").remove();
                            $(".radio-fake").remove();
                            $("#cart-resume").remove();

                        }
                    }

                    $('div#error_step1').css('display','inline-block');
                    $("ul#error__boxSA_ul_step1").html("");
                    $('ul#error__boxSA_ul_step1').append("<li>"+result.messages+"</li>");
                    $("div#change_period_step1").hide();

                    $(".loader").removeClass("show");
                }
            },
            beforeSend: function () {
                $(".loader").addClass("show");
            },
            complete: function () {
                //$(".loader").removeClass("show");
                setTimeout(
                    function() {
                        getViewCartPreviewQuotation();
                    }, 1500);
                console.log("showPromotions: "+showPromotions);
                $('html,body').animate({
                    scrollTop: $(".tabs-static").offset().top
                }, 'slow');
            },
            error: function() {
                $(".loader").removeClass("show");
            }
        }).then(function(){
            if(showPromotions) {
                setTimeout(
                    function() {
                        getViewModalPromotions('checkout');
                    }, 1000);
            } else {
                //Funciones para mostrar los modales de información post Cotizacion
                if(firstQuotation){
                    if ($(".listShipmentAddress>div").length > 1) {

                        $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_auto_quatotion_zip_start);
                        var msg_modal_alert = modal_alerts.auto_quatotion_zip_start.replace('{zipCode}', zipcodeFolio);
                        $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(msg_modal_alert);
                        $(".overlay").css("display",'block');
                    } else {
                        if(zipcodeFolio){
                            $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_auto_quotation_one_address);
                            var msg_modal_alert = modal_alerts.auto_quotation_one_address.replace('{zipCode}', zipcodeFolio);
                            $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(msg_modal_alert);
                            $(".overlay").css("display",'block');
                        }
                    }
                    firstQuotation = false;
                }
            }
        });
    }

    function getViewCartPreviewQuotation(){
        var url = URL_PROJECT+'/shopping/checkout/quotation/getCartPreviewQuotation';
        $(".loader").addClass("show");
        return $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                //$(".overlay").css("display",'none');
                $('div#cart-preview').find("#cart-empty").remove();
                $('div#cart-preview').find(".cart-product__item").remove();
                $('div#cart-preview').find("#cart-empty-default").hide();
                if (result) {
                    $('div#cart-preview').find(".cart-product__list").append(result.items);

                    $('div#cart-preview').find(".cart-preview__resume").html("");
                    $('div#cart-preview').find(".cart-preview__resume").append(result.totals);
                    $('div#cart-preview').removeClass("active");

                    $('div#cart-preview').removeClass("active");
                    //$("#buttonToStep2").removeAttr('disabled');

                    $('#cart-preview-mov li.total_mov').text($('#total').text());
                    $('#cart-preview-mov li.points_mov').text($('#points').text());

                } else {
                    $('div#cart-preview').find("#cart-empty-default").show();
                }
            },
            complete: function () {
                $(".loader").removeClass("show");
            },
            error: function() {
                $(".loader").removeClass("show");
                $(".overlay").css("display",'none');
                $("#blank-overlay").css("display",'none');
            }
        });
    }

    $(document).on("click", ".btnchangePeriodQuotation", function (){
        var change_period = $(this).val();
        setChangePeriodSession(change_period);
    });

    function setChangePeriodSession(change_period){
        var url = URL_PROJECT+'/shopping/checkout/quotation/setChangePeriodSession/'+change_period;
        $.ajax({
            url: url,
            type: 'GET',
            success: function (result) {
                console.log(result);
                if (result.success) {
                    $("#addressSuccess").find(".modal__title").empty().append(result.message);
                    $("#addressSuccess").find(".modal__body").empty();
                    $("#addressSuccess").addClass("active");
                    $(".overlay").css("display",'block');
                } else {
                    $("#addressSuccess").find(".modal__title").empty().append(result.message);
                    $("#addressSuccess").find(".modal__body").empty();
                    $("#addressSuccess").addClass("active");
                    $(".overlay").css("display",'block');
                }
            },beforeSend: function () {
                $(".loader").addClass("show");
            },
            complete: function () {
                $(".loader").removeClass("show");
            },
            error: function() {
                $(".loader").removeClass("show");
            }
        });
    }

    $(document).ready(function(){
        // Cargar los productos del carrito en el document
        var shopping_cart = {!! ShoppingCart::sessionToJson(session()->get('portal.main.country_corbiz')) !!};
        if (shopping_cart.constructor === Array && shopping_cart.length == 0) {
            shopping_cart = {};
        }
        document.shopping_cart = shopping_cart;

        $("#blank-overlay").css("display",'none');

        //LLamado a funciones para carga de direcciones e inicio de cotizacion
        getShippingAddressInit(1,1).then(function(resultado){
            if(resultado && resultado.defaultShippmentAddress){
                return selectShippingAddressInit(resultado.defaultShippmentAddress).then(function (resultadoSelectSA) {
                    setTimeout(function () {
                        getViewCartPreviewQuotation().then(function () {
                            $(".loader").removeClass("show");
                            if (resultadoSelectSA.showPromotions) {
                                setTimeout(function () {
                                    getViewModalPromotionsInit('checkout');
                                }, 200);
                            } else {
                                //Funciones para mostrar los modales de información post Cotizacion
                                if(firstQuotation){
                                    if ($(".listShipmentAddress>div").length > 1) {
                                        $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_auto_quatotion_zip_start);
                                        var msg_modal_alert = modal_alerts.auto_quatotion_zip_start.replace('{zipCode}', resultadoSelectSA.zipcodeFolio);
                                        $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(msg_modal_alert);
                                        $(".overlay").css("display",'block');
                                    } else {
                                        if(resultadoSelectSA.zipcodeFolio){
                                            $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_auto_quotation_one_address);
                                            var msg_modal_alert = modal_alerts.auto_quotation_one_address.replace('{zipCode}', resultadoSelectSA.zipcodeFolio);
                                            $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(msg_modal_alert);
                                            $(".overlay").css("display",'block');
                                        }
                                    }
                                    firstQuotation = false;
                                }
                            }
                        });
                    }, 200);
                });
            } else {
                if(resultado && !resultado.emptyListAddress) {
                    $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_no_match_zip_listAddress);
                    $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.no_match_zip_listAddress);
                }
                $(".loader").removeClass("show");
                $(".overlay").css("display",'block');
            }
        }).catch(function () {
            $(".loader").removeClass("show");
            }
        );


        $('#to-step1').on('click', function () {
            getViewCartPreviewQuotation();
            $('#title-checkout').text("{{ trans('shopping::checkout.checkout') }}");

            if (removePaypalPlus) {
                removePaypalPlus();
            }
            $('#tab__step2').removeClass('active');
            $('#step2').removeClass('active');
            $('#tab__step3').removeClass('active');
            $('#step3').removeClass('active');
            // $('.cart-preview__head').append('<p id="cart-remove-all" class="remove-all js-empty-cart" style="display: inline-block"><a onclick="ResumeCart.remove_all()" href="javascript:;">Delete all</a></p>');
        });
    });



</script>

<script src="{{ PageBuilder::js('promotions') }}"></script>
