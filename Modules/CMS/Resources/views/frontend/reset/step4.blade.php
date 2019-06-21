{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep4" name="formResetStep4">
                    <div class="history--description single-section ">
                        <div class="history--description single-section text-center">
                            <h3 class="products-maintitle">@lang('cms::reset_password.step4.title')</h3>
                            <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step4.subtitle')</h2>

                            <div id="error_ws_step4" class="error__box" style="display: none; text-align: left;">
                                <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                                <ul>
                                    <li id="error_ws_ul_step4"></li>
                                </ul>
                            </div>

                            @if($question != null || $question != '')
                                <h4 class="question">{{$question}}</h4>

                                <div class="form-group">
                                    <input type="text text-center" id="answer" name="answer" class="form-control m-bottom bottom-line line-down">

                                    <div id="div_answer" class="error-msg"></div>
                                </div>

                                <div class="buttons-container single-section">
                                    <button id="btnBackRPStep4" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                                    <button id="btnContinueRPStep4" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnContinue')</button>
                                </div>
                            @else
                                <h4 class="question">@lang('cms::reset_password.step4.answer_no_exist')</h4>

                                <div class="buttons-container single-section">
                                    <button id="btnBackRPStep4" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                                </div>
                            @endif
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

        $('#answer').keypress(function(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            return (tecla != 13);
        });

        $('#btnBackRPStep4').click(function() {
            $('.loader').removeClass('hide').addClass('show');

            location.href = "{{route('resetpassword.borndate')}}";
        });

        $('#btnContinueRPStep4').click(function() {
            resetPasswordStep4();
        });
    });

    function resetPasswordStep4() {
        var url     = "{{route('resetpassword.validate_question')}}";
        var form    = $('#formResetStep4');
        var step    = 'step4';

        validateStepResetPassword(url,form,step);
    }
</script>