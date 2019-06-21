@if(isset($isRegister) && !$isRegister)
    <script type='text/javascript' src="{{ asset('/js/redirect.js')}}"></script>
@endif
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

    function removePaypalPlus() {
        $('#ppplus').html('');
        $('#divppplus').hide();
    }

    /**
     * Obtener el HTML de una vista
     * */
    function getView(url, callback) {
        $('div#error_step1').css('display','none');
        $("ul#error__boxSA_ul_step1").html("");

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

    function validateDataQuotationToStep2() {
        return new Promise (function(resolve, reject) {
            var url = URL_PROJECT+'/shopping/checkout/quotation/validateDataQuotationToStep2';
            var resultado = ""
            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                    resultado = result.success;
                },
                complete: function () {
                    resolve(resultado);
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

    $('#buttonToStep2').on('click', function () {

        validateDataQuotationToStep2().then(function(validateQuotation) {
            $(".loader").addClass("show");
            if (validateQuotation) {
                $(".loader").removeClass("show");
                $('#generic_error').replaceWith('<div id="generic_error"></div>');
                $('.payment-container').hide();

                $('#tab__step1').removeClass('active');
                $('#step1').removeClass('active');
                $('#tab__step2').addClass('active');
                $('#step2').addClass('active');

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

                $('input:radio[name="payment"]').each(function (i) {
                    this.checked = false;
                });
            } else {
                $(".loader").removeClass("show");
                $(".overlay").css("display", 'inline-block');
                $("#alertShippingAddress").find('.modal__head h2').html("").append(modal_alerts.title_msg_error_get_quotation);
                $("#alertShippingAddress").addClass('active').find('.modal__body p').html("").append(modal_alerts.msg_error_get_quotation);
            }
        });
    });

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
        }).done(function (response, textStatus, jqXHR) {
            if (response.status) {
                $('#generic_error').replaceWith('<div id="generic_error"></div>');
                $('.payment-container').hide();
                $('#order').val(response.order);

                removePaypalPlus();

                switch (response.method_key) {
                    case 'PAYPAL':
                        $('.payment-container.paypal').show();
                        break;

                    case 'PAYPAL_PLUS':
                        $('.payment-container.paypal-plus').show();
                        break;
                }

            } else if (response.status === false && response.errors && Array.isArray(response.errors) && response.errors.length > 0) {
                var showErrorDetail = false;
                if (response.errors) {
                    showErrorDetail = true;
                    setErrors(response.errors);
                }

                if (response.back_to_step1) {
                    $('div#error_step1').css('display','inline-block');
                    $("ul#error__boxSA_ul_step1").html("");
                    $('ul#error__boxSA_ul_step1').append("<li>"+response.errors[0]+"</li>");

                    $('#to-step1').trigger('click');
                } else {
                    showAlert(response.errors, '#generic_error', 'error', showErrorDetail);
                    window.scrollTo(0, 0);
                }
            }

            hideModalPayment();
        }).fail(function (response, textStatus, errorThrown) {
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
    $('#banks').on('click', '[name=payment]', function (evt) {

            if ($('input[name=kit]:checked').val()) {
                $.ajax('{{ route('register.transactionFromCorbiz') }}', {
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    method: 'POST',
                    data: {paymentMethod: $(this).val(), 'shipping_company': $("#shipping_way_hidden").val()},
                    dataType: 'JSON',
                    statusCode: {
                        419: function () {
                            window.location.href = URL_PROJECT;
                        }
                    },
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

                            removePaypalPlus();

                            switch (response.method_key) {
                                case 'PAYPAL':
                                    $("#paypal-button").removeClass('hide hidden');
                                    $('.payment-container.paypal').show();
                                    break;

                                case 'PAYPAL_PLUS':
                                    $('.payment-container.paypal-plus').show();
                                    break;
                            }
                        } else if (response.status === false && response.errors && Array.isArray(response.errors) && response.errors.length > 0) {
                            $("#error_step3").show();
                            $("#error__box_ul_step3").html("");
                            $.each(response.errors, function (i, item) {

                                $("#error__box_ul_step3").append("<li class='text-danger'>" + item + "</li>");
                            });
                        }

                        hideModalPayment();
                    })
                    .fail(function (response, textStatus, errorThrown) {
                        hideModalPayment();
                        console.log(response, textStatus, errorThrown);
                    });
            }
            else {
                $("#choose").show();
                $("#choose").focus();
            }

    });
</script>
