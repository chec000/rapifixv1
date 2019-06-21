@php
    $country = strtolower(\App\Helpers\SessionHdl::getCorbizCountryKey());
    $env     = strtolower(env('APP_ENV')) == 'production' ? strtolower(env('APP_ENV')) : 'development';
@endphp
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
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