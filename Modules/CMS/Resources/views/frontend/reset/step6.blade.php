{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <div class="history--description single-section">
                    <div class="history--description single-section text-center">
                        <br>
                        <svg class="business__item-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 124 124">
                            <title>checkmark</title>
                            <circle class="cls-1" cx="62" cy="62" r="62"></circle>
                            <path class="cls-2" d="M32.8,64a3.1,3.1,0,0,1,0-4.2l4.4-4.2a2.6,2.6,0,0,1,2.1-.9,3,3,0,0,1,2.2.9l13,13.2L82.7,40.9a3,3,0,0,1,2.2-.9,2.6,2.6,0,0,1,2,.9l4.3,4.2a3.1,3.1,0,0,1,0,4.2L56.4,83.6a2.8,2.8,0,0,1-4.2,0Z"></path>
                        </svg>
                        <h3 class="products-maintitle">@lang('cms::reset_password.step6.title')</h3>
                        <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step6.subtitle')</h2>

                        <div id="error_ws_step6" class="error__box theme__transparent" style="display: none; text-align: left;">
                            <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                            <ul id="errors_ws_step6">
                            </ul>
                        </div>

                        <div class="buttons-container single-section">
                            <button id="btnLoginResetStep6" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnLogin')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! PageBuilder::section('footer') !!}

<script>
    $(document).ready(function() {
        $('.main-content').removeClass('single-section').addClass('single-section');

        //Envio de Form Login
        $('#btnLoginResetStep6').click(function() {
            var form = $('#formResetStep6');

            cleanMessagesStep6();

            var formData = {
                'code': "{{session('code')}}",
                'password': "{{session('password')}}",
                'country_corbiz': "{{session('country')}}",
                'language_corbiz': "{{session('lang')}}",
                'url_previous': "{{url('/')}}",
            };

            $.ajax({
                url: URL_PROJECT + '/login/auth',
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data.success == 'input_errors') {
                        $('#error_ws_step6').show();

                        $.each(data.message, function(key, message) {
                            $('#errors_ws_step6').append('<li>' + message + '</li>');
                        });

                        $('.loader').removeClass('show').addClass('hide');
                    }
                    else if (data.success == true) {
                        location.href = data.message;
                    }
                    else {
                        $('#error_ws_step6').show();
                        $('#errors_ws_step6').append('<li>' + data.message + '</li>');

                        $('.loader').removeClass('show').addClass('hide');
                    }
                },
                beforeSend: function() {
                    $('.loader').removeClass('hide').addClass('show');
                }
            });
        });
    });

    //Limpiar Mensajes
    function cleanMessagesStep6() {
        $('#error_ws_step6').hide();
        $('#errors_ws_step6').empty();
    }
</script>