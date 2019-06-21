@php
    $country = strtolower(\App\Helpers\SessionHdl::getCorbizCountryKey());
    $env     = strtolower(env('APP_ENV')) == 'production' ? strtolower(env('APP_ENV')) : 'development';
@endphp

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script type='text/javascript' src="{{ asset('/js/redirect.js')}}"></script>
<script type="application/javascript">
    /**
     * Mostrar mensajes
     * */
    function showAlert(messages, node, type, showLink) {
        if (type === 'error') { $(node).replaceWith(getErrorAlert(messages, showLink)); }
        if (type === 'warning') { $(node).replaceWith(getWarningAlert(messages)); }


    }

    function getErrorAlert(messages, showLink) {
        var messagesHTML = '';
        $.each(messages, function (index, message) {
            messagesHTML += '<li>'+message+'</li>';
        });

        return '' +
            '<div id="generic_error" class="error__box" style="display:block; width: 80%;margin:0 auto;">\n' +
            '    <span class="error__single">\n' +
            '        <img src="{{ asset('themes/omnilife2018/images/icons/warning.svg') }}">{{ trans("shopping::checkout.payment.errors.default") }}:\n' +
            '    </span>\n' +
            '    <ul id="error__boxSA_ul_step1">'+messagesHTML+'</ul>\n' +
            '' + (showLink ? '<a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{ trans('cms::errors.modal.more') }}</a>' : '') +
            '</div>'
    }

    function getWarningAlert(messages) {
        var messagesHTML = '';
        $.each(messages, function (index, message) {
            messagesHTML += '<li>'+message+'</li>';
        });

        return '' +
            '<div id="generic_error" class="warning__box" style="display:block; width: 80%;margin:0 auto;">\n' +
            '    <span class="warning__single">{{ trans("shopping::checkout.payment.attention") }}:</span>\n' +
            '    <ul id="error__boxSA_ul_step1">'+messagesHTML+'</ul>\n' +
            '</div>'
    }

    function showModalPayment(withProcessModel) {
        $('.overlay').show();

        if (withProcessModel) {
            $('#realizando-pago').addClass('active');
        }
    }

    function hideModalPayment(withProcessModel) {
        $('.overlay').hide();

        if (withProcessModel) {
            $('#realizando-pago').removeClass('active');
        }
    }

    function closeCart() {
        if ($('.cart-preview.fade-in-down.cart__right').hasClass('active')) {
            $('.cart-preview.fade-in-down.cart__right').removeClass('active');
        }
    }

    /**
     * Obtener el HTML de una vista
     * */
    function getView(url, callback) {
        $.ajax(url, {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            method: 'POST',
            dataType: 'HTML',
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
        })
        .done(function (response, textStatus, jqXHR) {
            return callback(null, response);
        })
        .fail(function (response, textStatus, errorThrown) {
            return callback(response, null);
        });
    }

    /**
     * Cargar las vistas de métodos de pago y el resúmen de la cotización
     * */
    $('.buttons-container').on('click', '[data-to=step2]', function () {

        $('#generic_error').replaceWith('<div id="generic_error"></div>');
        $('.payment-container').hide();

        if ($('#step2').hasClass('active')) {
            $('#icart').replaceWith('<a class="icon-btn icon-cart" id="icart"></a>');
            $('#paypal-button').show();

            $('#title-checkout').text("{{ trans('shopping::shopping_cart.tabs.payment.mobile') }}");

            getView('{{ route('checkout.getPaymentView') }}', function (err, response) {
                if (err) return console.log(err);
                $('#form-payment').replaceWith(response);
            });

            getView('{{ route('checkout.getCartPreview') }}', function (err, response) {
                if (err) return console.log(err);

                $('#cart-preview').replaceWith(response);
                var itemsLists = $('#cart-preview .cart-product__list');

                if (itemsLists.length > 0 && document.perfectScrollbar != undefined) {
                    new document.perfectScrollbar(itemsLists[0]);
                }

                $('#cart-preview-mov li.total').text($('#total').text());
                $('#cart-preview-mov li.points').text($('#points').text());
            });
        }

        $('input:radio[name="payment"]').each(function(i) {
            this.checked = false;
        });
    });

    /**
     * Generar la transacción en corbiz
     * */
    $('#step2').on('change', '[name=payment]', function () {
        $.ajax('{{ route('checkout.processTransaction') }}', {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            method: 'POST',
            data: {paymentMethod: $(this).val()},
            dataType: 'JSON',
            statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
            beforeSend: function () {
                showModalPayment();
            }
        })
        .done(function (response, textStatus, jqXHR) {
            if (response.status) {
                $('#generic_error').replaceWith('<div id="generic_error"></div>');
                $('.payment-container').hide();
                $('#order').val(response.order);

                if (response.method_key === 'PAYPAL') {
                    $('.payment-container.paypal').show();
                }

            } else if (response.status === false && response.errors && Array.isArray(response.errors) && response.errors.length > 0) {

                var showErrorDetail = false;
                if (response.err) {
                    showErrorDetail = true;
                    setErrors(response.err);
                }

                showAlert(response.errors, '#generic_error', 'error', showErrorDetail);
                window.scrollTo(0, 0);
            }

            hideModalPayment();
        })
        .fail(function (response, textStatus, errorThrown) {
            hideModalPayment();
            console.log(response, textStatus, errorThrown);
        });
    });

    $('#cart-preview-mov').on('click', function () {
        if (!$('.cart-preview.fade-in-down.cart__right').hasClass('active')) {
            $('.cart-preview.fade-in-down.cart__right').addClass('active');
        }
    });

    /**
     * Generar la transacción de inscripcion en corbiz
     * */
    $('#banks').on('change', '[name=payment]', function () {
        if($('input[name=kit]:checked').val()){
            $.ajax('{{ route('register.transactionFromCorbiz') }}', {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                method: 'POST',
                data: {paymentMethod: $(this).val(),'shipping_company': $("#shipping_way_hidden").val()},
                dataType: 'JSON',
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                beforeSend: function () {
                    $("#error__box_ul_step3").html("");
                    $("#error_step").hide();
                    showModalPayment();
                }
            })
                .done(function (response, textStatus, jqXHR) {
                    if (response.status) {
                        $("#error__box_ul_step3").html("");
                        $("#error_step3").hide();
                        $('.payment-container').hide();
                        $('#order').val(response.order);

                        if (response.method_key === 'PAYPAL') {
                            $("#paypal-button").removeClass('hide hidden');
                            $('.payment-container.paypal').show();
                        }

                    }
                    else if (response.status === false && response.errors && Array.isArray(response.errors) && response.errors.length > 0) {
                        $("#error_step3").show();
                        $("#error__box_ul_step3").html("");
                        $.each(response.errors, function (i, item) {

                            $("#error__box_ul_step3").append("<li class='text-danger'>"+item+"</li>");
                        });
                    }

                    hideModalPayment();
                })
                .fail(function (response, textStatus, errorThrown) {
                    hideModalPayment();
                    console.log(response, textStatus, errorThrown);
                });
        }else{
            $("#choose").show();
            $("#choose").focus();
        }
    });
</script>
<script type="application/javascript">
    /**
     * Paypal
     * */
    var showDefaultError = true;

    paypal.Button.render({
        env: '{{ config("paymentmethods.paypal.{$country}.{$env}.mode_checkout") }}',
        locale: '{{ config("paymentmethods.paypal.{$country}.locale") }}',
        style: {
            size: 'responsive', // tiny, small, medium
            height: 35,
            color: 'gold',  // gold, blue, silver
            shape: 'pill',  // pill, rect
        },
        commit: true,
        payment: function(resolve, reject) {
            paypal.request.post('{{ route('paypal.create') }}', {order: $('#order').val(),type: $('#type_action').val(), _token: '{{ csrf_token() }}'})
                .then(function(data) {
                    if (data.success) {
                        resolve(data.paymentId);
                    } else {
                        window.scrollTo(0, 0);
                        showAlert(data.messages, '#generic_error', 'error', false);

                        showDefaultError = false;
                        throw data.messages;
                    }
                })
                .catch(function(err) {
                    reject(err);
                });
        },
        onAuthorize: function(data, actions) {
            showModalPayment(true);

            paypal.request.post('{{ route('paypal.process') }}', { paymentID: data.paymentID, payerID: data.payerID,type: $('#type_action').val(), _token: '{{ csrf_token() }}'} )
                .then(function(data) {
                    if (data.success) {
                        if(data.type == 'register'){
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['register', 'confirmation'])) }}', {'data': data,_token: '{{ csrf_token() }}'});
                            hasSession = false;
                        }else{
                            $.redirect('{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['checkout', 'confirmation'])) }}', {'order': data.order.order_number, _token: '{{ csrf_token() }}'});
                        }
                    } else {
                        showAlert([data.message], '#generic_error', 'error', false);

                        window.scrollTo(0, 0);
                        hideModalPayment(true);
                    }
                })
                .catch(function(err) {
                    window.scrollTo(0, 0);

                    showAlert(['{{ trans("shopping::checkout.payment.errors.sys103") }}'], '#generic_error', 'error', false);
                    console.log(err);
                    hideModalPayment(true);
                });
        },
        onCancel: function(data, actions) {
            showAlert(['{{ trans("shopping::checkout.payment.errors.cancel_paypal") }}'], '#generic_error', 'warning', false);
            window.scrollTo(0, 0);

            $.ajax('{{ route('paypal.cancel') }}', {
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                method: 'POST',
                data: {order: $('#order').val(),type: $('#type_action').val()},
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                dataType: 'JSON'
            })
            .done(function (response, textStatus, jqXHR) {
                console.log(response.success);
            })
            .fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        },
        onError: function(err) {
            if (showDefaultError) {
                window.scrollTo(0, 0);
                showAlert(['{{ trans("shopping::checkout.payment.errors.sys101") }}'], '#generic_error', 'error', false);

                console.log(err);
                throw new Error(err);
            }
        },
    }, '#paypal-button');
</script>