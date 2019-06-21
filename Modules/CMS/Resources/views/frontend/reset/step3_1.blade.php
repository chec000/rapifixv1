{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep3_1" name="formResetStep3_1" method="POST">
                    <div class="history--description single-section ">
                        <div class="history--description single-section text-center">
                            <h3 class="products-maintitle">@lang('cms::reset_password.step3_1.title')</h3>
                            <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step3_1.subtitle')</h2>

                            <div id="error_ws_step3_1" class="error__box hidden" style="text-align: left;">
                                <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                                <ul>
                                    <li id="error_ws_ul_step3_1"></li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <input type="text text-center" id="verification_code" name="verification_code" placeholder="@lang('cms::reset_password.step3_1.code')" class="form-control m-bottom bottom-line line-down text-center" maxlength="8">

                                <div id="div_verification_code" class="error-msg"></div>
                            </div>

                            <p>@lang('cms::reset_password.step3_1.forwarding')<a onclick="sendCode()" style="cursor: pointer;">@lang('cms::reset_password.step3_1.forwarding_2')</a></p>

                            <div class="buttons-container single-section">
                                <button id="btnBackRPStep3_1" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                                <button id="btnContinueRPStep3_1" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnContinue')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('themes.omnilife2018.sections.loader')

{!! PageBuilder::section('footer') !!}

<script>
    $(document).ready(function() {
        $('.main-content').removeClass('single-section').addClass('single-section');

        $('#verification_code').keypress(function(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            return (tecla != 13);
        });

        $('#btnBackRPStep3_1').click(function() {
            $('.loader').removeClass('hide').addClass('show');

            $.get("{{route('resetpassword.back_code')}}", function(data) {
                location.href   = data.message;
            });
        });

        $('#btnContinueRPStep3_1').click(function() {
            resetPasswordStep3_1();
        });
    });

    function sendCode() {
        $('.loader').removeClass('hide').addClass('show');

        $.get("{{route('resetpassword.send_code')}}", function() {
            $('.loader').removeClass('show').addClass('hide');
        });
    }

    function resetPasswordStep3_1() {
        var url     = "{{route('resetpassword.verification_code')}}";
        var form    = $('#formResetStep3_1');
        var step    = 'step3_1';

        validateStepResetPassword(url,form,step);
    }
</script>