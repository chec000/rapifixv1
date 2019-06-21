{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' | ' . trans('cms::reset_password.title')]) !!}

<div class="business single-section">
    <div class="wrapper full-size-mobile business__main single-section">
        <div class="reset-password">
            <div class="history--container">
                <form id="formResetStep3_2" name="formResetStep3_2" method="POST">
                    <div class="history--description single-section text-center" >
                        <h3 class="products-maintitle">@lang('cms::reset_password.step3.title')</h3>
                        <h2 class="history--title omnilife single-section">@lang('cms::reset_password.step3.subtitle')</h2>

                        <div id="error_ws_step3_2" class="error__box hidden" style="text-align: left;">
                            <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                            <ul>
                                <li id="error_ws_ul_step3_2"></li>
                            </ul>
                        </div>

                        <div class="form-row left">
                            <div class="form-label block">@lang('cms::reset_password.step3.born_date')</div>

                            <div class="form-group select small">
                                <select class="form-control" id="day" name="day">
                                    <option value="">@lang('cms::reset_password.step3.day')</option>
                                    @for($i=1;$i<=31;$i++)
                                        <?php $day = strlen($i) == 1 ? "0".$i : $i; ?>
                                        <option value="{{ $day }}">{{ $day }}</option>
                                    @endfor
                                </select>

                                <div id="div_day" class="error-msg"></div>
                            </div>

                            <div class="form-group select small">
                                <select class="form-control" id="month" name="month">
                                    <option value="">@lang('cms::reset_password.step3.month')</option>
                                    @foreach($months as $key => $month)
                                        <option value="{{$key}}">@lang($month)</option>
                                    @endforeach
                                </select>

                                <div id="div_month" class="error-msg"></div>
                            </div>

                            <div class="form-group select small">
                                <select class="form-control" id="year" name="year">
                                    <option value="">@lang('cms::reset_password.step3.year')</option>
                                </select>

                                <div id="div_year" class="error-msg"></div>
                            </div>

                            <div class="error-msg" id="error-msg-parameters"></div>
                        </div>

                        <div class="buttons-container single-section">
                            <button id="btnBackRPStep3_2" class="button secondary" type="button">@lang('cms::reset_password.btnBack')</button>
                            <button id="btnContinueRPStep3_2" class="button" type="button" data-to="step2">@lang('cms::reset_password.btnContinue')</button>
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

        $('#btnBackRPStep3_2').click(function() {
            $('.loader').removeClass('hide').addClass('show');

            location.href = "{{route('resetpassword.option')}}";
        });

        $('#btnContinueRPStep3_2').click(function() {
            resetPasswordStep3_2();
        });

        getParameters("{{$country}}");
    });

    function resetPasswordStep3_2() {
        var url     = "{{route('resetpassword.validate_borndate')}}";
        var form    = $('#formResetStep3_2');
        var step    = 'step3_2';

        validateStepResetPassword(url,form,step);
    }

    function getParameters(country) {
        $.ajax({
            type: 'POST',
            url: "{{ route('resetpassword.parameters') }}",
            data: {'country': country, _token: '{{csrf_token()}}'},
            success: function(result) {
                if (result.success) {
                    var info = result.data;

                    for (x= info.fechain; x >= info.fecha_fin; x--){
                        $('#year').append($('<option>', {
                            value: x,
                            text : x
                        }));
                    }
                }
                else {
                    $('#error-msg-parameters').append(result.message);
                    $('#year').addClass('has-error');
                    $('#day').addClass('has-error');
                    $('#month').addClass('has-error');
                }
            },
            error: function(result) {
                $('#error-msg-parameters').append(result.message);
            },
            beforeSend: function() {
                $('#error-msg-parameters').empty();
                $('#year').removeClass('has-error');
                $('#day').removeClass('has-error');
                $('#month').removeClass('has-error');
            },
            complete: function() {
            }
        });
    }
</script>