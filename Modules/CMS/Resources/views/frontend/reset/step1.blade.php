{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep1" name="formResetStep1" method="POST">
                    <div class="history--description single-section text-center">
                        <h3 class="products-maintitle">@lang('cms::reset_password.step1.title')</h3>
                        <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step1.subtitle')</h2>

                        <div id="error_ws_step1" class="error__box hidden" style="text-align: left;">
                            <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                            <ul>
                                <li id="error_ws_ul_step1"></li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <input type="text" id="dist_num" name="dist_num" placeholder="@lang('cms::reset_password.step1.placeholder')" class="form-control m-bottom bottom-line line-down text-center">

                            <div id="div_dist_num" class="error-msg"></div>
                        </div>

                        <div class="form-group">
                            <input class="form-control transparent" type="hidden" name="country_corbiz" id="country_corbiz_reset_password_step1" value="{{session()->get('portal.main.country_corbiz')}}">
                            <input class="form-control transparent" type="hidden" name="language_corbiz" id="language_corbiz_reset_password_step1" value="{{session()->get('portal.main.language_corbiz')}}">
                        </div>

                        <p>@lang('cms::reset_password.step1.contact1') <a href="mailto:{{$emailContact}}">@lang('cms::reset_password.step1.contact2')</a>.</p>

                        <div class="buttons-container single-section">
                            <button id="btnFormResetStep1" type="button" class="button small">@lang('cms::reset_password.btnContinue')</button>
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

        $('#dist_num').keypress(function(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            return (tecla != 13);
        });

        $('#btnFormResetStep1').click(function() {
            resetPasswordStep1();
        });
    });

    function resetPasswordStep1() {
        var url     = "{{route('resetpassword.validate_dist')}}";
        var form    = $('#formResetStep1');
        var step    = 'step1';

        validateStepResetPassword(url, form, step);
    }
</script>