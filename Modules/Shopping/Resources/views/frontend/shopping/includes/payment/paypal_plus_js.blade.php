@php
    $country = strtolower(\App\Helpers\SessionHdl::getCorbizCountryKey());
    $env     = strtolower(env('APP_ENV')) == 'production' ? strtolower(env('APP_ENV')) : 'development';
@endphp
<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"></script>
<script>
    $('#paypal-plus-button-cancel').click(function () {
        removePaypalPlus();
        $('.payment-container.paypal-plus').show();
    });

    $('#paypal-plus-button').click(function () {
        $('.loader').addClass('show');

        $.ajax({
            url: '{{ route('paypalplus.create') }}',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: {'order' : $('#order').val()},
            type: 'POST',
            dataType : 'json',
            beforeSend: function(response) {
                $('#generic_error').replaceWith('<div id="generic_error"></div>');
            },
            success : function(response) {

                if (response.success) {
                    $('#btnPaymentpplus').hide();
                    $('#divppplus').show();
                    $('#i_pay_id').val(response.paymentID);
                    $('#approvalUrl').val(response.approvalUrl);
                    $('#payerEmail').val(response.eo_email);
                    $('#payerFirstName').val(response.eo_name);

                    $('.payment-container.paypal-plus').hide();
                    initiatePPlus();
                } else {
                    if (response.messages && response.messages.length > 0) {
                        showAlert(response.messages, '#generic_error', 'error', false);
                    } else {
                        showAlert(['{{ trans("shopping::checkout.payment.errors.sys104") }}'], '#generic_error', 'error', false);
                    }
                }
            },
            error : function(response) {
                showAlert(['{{ trans("shopping::checkout.payment.errors.sys104") }}'], '#generic_error', 'error', false);
                removePaypalPlus();
                $('.loader').removeClass('show');
                $('.payment-container.paypal-plus').show();
            },
            complete : function(xhr, status) {
                $('.loader').removeClass('show');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#divppplus").offset().top
                }, 1000);
            }
        });
    });

    function initiatePPlus() {
        ppp = PAYPAL.apps.PPP({
            'approvalUrl'                          : $('#approvalUrl').val(), //Url obtenida previamente al crear el Payment
            'placeholder'                          : 'ppplus', //Indica un elemento DOM en la página donde se dibujará el procesador de pagos
            //Datos del cliente
            'payerEmail'                           : $('#payerEmail').val(),
            'payerFirstName'                       : $('#payerFirstName').val(),
            'payerLastName'                        : '*',
            'payerTaxId'                           : '',
            'rememberedCards'                      : '0AyVyPx3xzA5uraCh_E0skvmq8zKxNnwEbcXyOkF1v-fJCVnF_vJdjj9_-IvAg6zHMJQKU6SSvu8OdpEsWwCsOJmd8UFqJ87DyLiqHfktxgDVJH4oSsp41jrsdBV2cdc6atRv74Y7J2wK9mJsWTihCLfbqs_6LlgxEl2VyVbhua42ucW', //Para usuarios registrados se mejora la experiencia de compra
            'mode'                                 : '{{ config("paymentmethods.paypal.{$country}.{$env}.mode") }}',
            'iframeHeight'                         : '560' ,
            'disableContinue'                      : 'paypal-plus-button-pay',
            'enableContinue'                       : 'paypal-plus-button-pay',
            'hideAmount'                           : false,
            'language'                             : '{{ config("paymentmethods.paypal.{$country}.locale") }}',
            'country'                              : '{{ config("paymentmethods.paypal.{$country}.country_code") }}',
            'disallowRememberedCards'              : false,
            'merchantInstallmentSelection'         : 0,
            'merchantInstallmentSelectionOptional' : true,
            'onError': function() {
                showAlert(['{{ trans("shopping::checkout.payment.errors.sys105") }}'], '#generic_error', 'error', false);
            },
            //Esta función siempre es ejecutada cuando el procesador de pagos finaliza su procesamiento del cobro
            //Como resultado del procesamiento se obtienen:  Token, Payer ID, Remembered Cards, Term
            'onContinue': function(rememberedCards, payerId, token, term) {
                console.log("en on continue");
                $('#paypal-plus-button-pay').hide();

                $('#i_token').val(token);
                $('#i_payerId').val(payerId);
                $('#i_term').val(term);

                $.ajax($('#f_ejecuta_pago').attr('action'), {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    method: 'POST',
                    data: $('#f_ejecuta_pago').serialize(),
                    dataType: 'JSON',
                    statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                    beforeSend: function () {
                        console.log("antes de enviar ajax ejecuta pago");
                        showModalPayment(true);
                    }
                })
                .done(function (response, textStatus, jqXHR) {
                    if (response.success) {
                        if (response.type === 'register') {
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['register', 'confirmation'])) }}', {'data': response,_token: '{{ csrf_token() }}'});
                            hasSession = false;
                        } else {
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['checkout', 'confirmation'])) }}', {'order': response.order.order_number, _token: '{{ csrf_token() }}'});
                        }
                    } else {
                        showAlert([response.message], '#generic_error', 'error', false);
                        window.scrollTo(0, 0);
                        $('#paypal-plus-button-pay').show();
                        hideModalPayment(true);
                        removePaypalPlus();
                        $('.payment-container.paypal-plus').show();
                    }
                })
                .fail(function (response, textStatus, errorThrown) {

                    window.scrollTo(0, 0);

                    showAlert(['{{ trans("shopping::checkout.payment.errors.sys106") }}'], '#generic_error', 'error', false);
                    console.log(response);
                    hideModalPayment(true);
                    removePaypalPlus();
                    $('.payment-container.paypal-plus').show();
                });
            },
        });
    }

    function initiateCheckout() {
        ppp = PAYPAL.apps.PPP({
            'approvalUrl'     : $('#approvalUrl').val(), //Url obtenida previamente al crear el Payment
            'placeholder'     : 'ppplusmini', //Indica un elemento DOM en la página donde se dibujará el procesador de pagos
            //Datos del cliente
            'payerEmail'      : $('#payerEmail').val(),
            'payerFirstName'  : $('#payerFirstName').val(),
            'payerLastName'   : '*',
            'payerTaxId'      : '',
            'rememberedCards' : '', //Para usuarios registrados se mejora la experiencia de compra
            'onError': function() {
                showAlert(['{{ trans("shopping::checkout.payment.errors.sys105") }}'], '#generic_error', 'error', false);
            },
            //Esta función siempre es ejecutada cuando el procesador de pagos finaliza su procesamiento del cobro
            //Como resultado del procesamiento se obtienen:  Token, Payer ID, Remembered Cards, Term
            'onContinue': function(rememberedCards, payerId, token, term) {
                $('#paypal-plus-button-pay').hide();

                $('#i_token').val(token);
                $('#i_payerId').val(payerId);
                $('#i_term').val(term);

                $.ajax($('#f_ejecuta_pago').attr('action'), {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    method: 'POST',
                    data: $('#f_ejecuta_pago').serialize(),
                    dataType: 'JSON',
                    statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                    beforeSend: function () {
                        showModalPayment(true);
                    }
                })
                .done(function (response, textStatus, jqXHR) {
                    console.log(response);
                    if (response.success) {
                        if (response.type === 'register') {
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['register', 'confirmation'])) }}', {'data': response,_token: '{{ csrf_token() }}'});
                            hasSession = false;
                        } else {
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['checkout', 'confirmation'])) }}', {'order': response.order.order_number, _token: '{{ csrf_token() }}'});
                        }
                    } else {
                        showAlert([response.message], '#generic_error', 'error', false);

                        window.scrollTo(0, 0);
                        hideModalPayment(true);
                        removePaypalPlus();
                    }
                })
                .fail(function (response, textStatus, errorThrown) {
                    window.scrollTo(0, 0);

                    showAlert(['{{ trans("shopping::checkout.payment.errors.sys106") }}'], '#generic_error', 'error', false);
                    console.log(err);
                    hideModalPayment(true);
                    removePaypalPlus();
                });
            },
            miniBrowser : true,
            onMiniBrowserClose : function () {},
        });
    }
</script>