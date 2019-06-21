{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep5" name="formResetStep5" method="POST">
                    <div class="history--description single-section">
                        <div class="history--description single-section text-center">
                            <h3 class="products-maintitle">@lang('cms::reset_password.step5.title')</h3>
                            <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step5.subtitle') {{session()->get('portal.eo_reset.email2')}}</h2>

                            <div id="error_ws_step5" class="error__box" style="display: none; text-align: left;">
                                <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                                <ul>
                                    <li id="errors_ws_step5"></li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <input type="password" id="new_password" name="new_password" placeholder="@lang('cms::reset_password.step5.new_password')" minlength="4" class="form-control m-bottom bottom-line line-down  reset-password">

                                <div id="div_new_password" class="error-msg"></div>
                            </div>

                            <div class="form-group">
                                <input type="password" id="new_password_confirm" name="new_password_confirm" placeholder="@lang('cms::reset_password.step5.new_password_confirm')" minlength="4" class="form-control m-bottom bottom-line line-down reset-password">

                                <div id="div_new_password_confirm" class="error-msg"></div>
                            </div>

                            <p>@lang('cms::reset_password.step5.alert')</p>

                            <div class="buttons-container single-section">
                                <button id="btnBackRPStep5" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                                <button id="btnContinueRPStep5" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnContinue')</button>
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

        $('#new_password').keypress(function(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            return (tecla != 13);
        });

        $('#new_password_confirm').keypress(function(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            return (tecla != 13);
        });

        $('#btnBackRPStep5').click(function() {
            $('.loader').removeClass('hide').addClass('show');

            $.get("{{route('resetpassword.back_new_password')}}", function(data) {
                location.href = data.message;
            });
        });

        $('#btnContinueRPStep5').click(function() {
            resetPasswordStep5();
        });
    });

    function resetPasswordStep5() {
        var url     = "{{route('resetpassword.validate_new_password')}}";
        var form    = $('#formResetStep5');
        var step    = 'step5';

        validateStepResetPassword(url,form,step);
    }
</script>