{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep2" name="formResetStep2" method="POST">
                    <div class="history--description single-section text-center">
                        <h3 class="products-maintitle">@lang('cms::reset_password.step2.title')</h3>
                        <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step2.subtitle')</h2>

                        <div id="error_ws_step2" class="error__box hidden" style="text-align: left;">
                            <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                            <ul>
                                <li id="error_ws_ul_step2"></li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <div class="form-radio card stack">
                                <input type="radio" id="method1" name="option_method" value="1">
                                <label class="card__content-wrap" for="method1">
                                    <div class="card__content">
                                        <label class="radio-fake" for="method1"></label>
                                        <span class="radio-label">
                                            @lang('cms::reset_password.step2.option1_title')
                                            <span class="small">
                                                @lang('cms::reset_password.step2.option1_subtitle') {{session()->get('portal.eo_reset.email2')}}
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>

                            <div class="form-radio card stack">
                                <input type="radio" id="method2" name="option_method" value="0">
                                <label class="card__content-wrap" for="method2">
                                    <div class="card__content">
                                        <label class="radio-fake" for="method2"></label>
                                        <span class="radio-label">
                                            @lang('cms::reset_password.step2.option2_title')
                                            <span class="small">
                                                @lang('cms::reset_password.step2.option2_subtitle')
                                            </span>
                                        </span>
                                    </div>
                                </label>
                            </div>

                            <div class="error-msg" id="div_option_method"></div>

                            <div class="buttons-container single-section">
                                <button id="btnBack" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                                <button id="btnContinue" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnContinue')</button>
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

        $('#btnBack').click(function() {
            $('.loader').removeClass('hide').addClass('show');

            $.get("{{route('resetpassword.back')}}", function(data) {
                location.href   = data.message;
            });
        });

        $('#btnContinue').click(function() {
            resetPasswordStep2();
        });
    });

    function resetPasswordStep2() {
        var url     = "{{route('resetpassword.method')}}";
        var form    = $('#formResetStep2');
        var step    = 'step2';

        validateStepResetPassword(url,form,step);
    }
</script>