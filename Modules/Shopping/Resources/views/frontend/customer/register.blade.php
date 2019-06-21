{!! PageBuilder::section('head', ['title' => strtoupper($brand) . ' - ' . trans('shopping::register_customer.title')]) !!}

@section('styles')
    <style>
        .ui-datepicker-title select {
            color: black;
        }
    </style>
@endsection

<div class="overlay"></div>

<div class="register fullsteps">
    <nav class="tabs-static">
        <div class="wrapper">
            <ul class="list-nostyle tabs-static__list">
                <li id="tab__step1" class="tabs-static__item{{($activation) ? '' : ' active'}}">
                    <span class="desk">@lang('shopping::register_customer.tabs.account.desktop')</span>
                    <span class="mov">@lang('shopping::register_customer.tabs.account.mobile')</span>
                </li>

                <li id="tab__step2" class="tabs-static__item">
                    <span class="desk">@lang('shopping::register_customer.tabs.email.desktop')</span>
                    <span class="mov">@lang('shopping::register_customer.tabs.email.mobile')</span>
                </li>

                <li id="tab__step3" class="tabs-static__item{{($activation) ? ' active' : ''}}">
                    <span class="desk">@lang('shopping::register_customer.tabs.activation.desktop')</span>
                    <span class="mov">@lang('shopping::register_customer.tabs.activation.mobile')</span>
                </li>
            </ul>
        </div>
    </nav>

    <div class="register__main">
        <form id="formRegisterCustomer" name="formRegisterCustomer">
            <div class="register__step step step2 fade-in-down{{($activation) ? '' : ' active'}}" id="step1">
                <input type="hidden" name="distributor_code" id="distributor_code">
                <input type="hidden" name="distributor_name" id="distributor_name">
                <input type="hidden" name="distributor_email" id="distributor_email">

                <div class="error__box hidden" id="error__box_step1">
                    <span class="error__single">
                        <img src="{{ asset('themes/omnilife2018/images/warning.svg') }}"> @lang('shopping::register_customer.error__box'):
                    </span>

                    <ul id="error__box_ul_step1">
                    </ul>
                </div>

                <div class="form-group radioEo">
                    <div class="form-label mov">@lang('shopping::register_customer.account.invited.label.mobile'):</div>
                    <div class="form-label desk">@lang('shopping::register_customer.account.invited.label.desktop'):</div>

                    <div class="col-right">
                        <div class="form-radio inline">
                            <span class="radio-label">@lang('shopping::register_customer.account.invited.answer.yes')</span>
                            <input type="radio" id="invited1" name="invited" value="1">
                            <label class="radio-fake" for="invited1"></label>
                        </div>

                        <div class="form-radio inline">
                            <span class="radio-label">@lang('shopping::register_customer.account.invited.answer.no')</span>
                            <input type="radio" id="invited2" name="invited" value="0">
                            <label class="radio-fake" for="invited2"></label>
                        </div>
                    </div>

                    <div class="error-msg" id="div_invited"></div>
                </div>

                <div class="form-group hidden" id="invited-yes">

                    <div class="sponsored form-label {{ !empty($numEo)  ? '' : 'hide hidden' }}">@lang('shopping::register.account.businessman_code.label_sponsored'):</div>
                    <div class="normal form-label {{ !empty($numEo)  ? 'hide hidden' : '' }}">@lang('shopping::register.account.businessman_code.label'):</div>

                    <div class="col-right">
                        <input rel="{{isset($codEo) ? $codEo : ''}}" class="form-control" type="text" id="register-code" name="register-code" placeholder="@lang('shopping::register_customer.account.businessman_code.placeholder')*" value="{{$numEo}}" maxlength="13" style="text-transform: uppercase;">

                        <div class="" id="valid-eo"></div>
                    </div>

                    <div class="error-msg" id="div_register-code"></div>
                </div>

                <div class="form-group hidden" id="invited-no">
                    <div class="form-label">@lang('shopping::register.account.meet_us.label'):</div>

                    <div class="col-right">
                        <div class="select">
                            <select class="form-control" name="references" id="references">
                            </select>

                            <div class="error-msg" id="error-msg-references"></div>
                            <div class="error-msg" id="error-msg-pool"></div>
                            <div class="error-msg error-validation"></div>
                        </div>
                    </div>

                    <div class="error-msg" id="div_references"></div>
                </div>

                <div class="form-row">
                    <div class="form-label block">@lang('shopping::register_customer.account.full_name.name.label')</div>

                    <div class="form-group medium">
                        <input class="form-control" type="text" id="name" name="name" placeholder="@lang('shopping::register_customer.account.full_name.name.placeholder')*" maxlength="30">

                        <div class="error-msg" id="div_name"></div>
                    </div>

                    <div class="form-group medium">
                        <input class="form-control" type="text" id="lastname" name="lastname" placeholder="@lang('shopping::register_customer.account.full_name.lastname.placeholder')" maxlength="30">

                        <div class="error-msg" id="div_lastname"></div>
                    </div>

                    <div class="form-group medium">
                        <input class="form-control" type="text" id="lastname2" name="lastname2" placeholder="@lang('shopping::register_customer.account.full_name.lastname2.placeholder')" maxlength="30">

                        <div class="error-msg" id="div_lastname2"></div>
                    </div>

                    <div class="form-group medium">
                        <div class="form-label mov">@lang('shopping::register_customer.account.sex.label'):</div>
                        <div class="form-label desk">@lang('shopping::register_customer.account.sex.label'):</div>

                        <div class="col-right">
                            <div class="form-radio inline">
                                <span class="radio-label">@lang('shopping::register_customer.account.sex.male')</span>
                                <input type="radio" id="sex2" name="sex" value="0">
                                <label class="radio-fake" for="sex2"></label>
                            </div>

                            <div class="form-radio inline">
                                <span class="radio-label">@lang('shopping::register_customer.account.sex.female')</span>
                                <input type="radio" id="sex1" name="sex" value="1">
                                <label class="radio-fake" for="sex1"></label>
                            </div>
                        </div>

                        <div class="error-msg" id="div_sex"></div>
                    </div>
                </div>

                <div class="form-row left">
                    <div class="form-label block">@lang('shopping::register_customer.account.borndate.label'):</div>
                    <div class="form-group select small">
                        <select class="form-control" name="day" id="day">
                            <option value="">@lang('shopping::register_customer.account.borndate.day')*</option>
                        </select>

                        <div class="error-msg" id="div_day"></div>
                    </div>
                    <div class="form-group select small">
                        <select class="form-control" name="month" id="month">
                            <option value="">@lang('shopping::register_customer.account.borndate.month')*</option>
                        </select>

                        <div class="error-msg" id="div_month"></div>
                    </div>
                    <div class="form-group select small">
                        <select class="form-control" name="year" id="year">
                            <option value="">@lang('shopping::register_customer.account.borndate.year')*</option>
                        </select>

                        <div class="error-msg" id="div_year"></div>
                    </div>

                    <div class="error-msg" id="error-msg-parameters"></div>
                    <div class="error-msg" id="div_borndate"></div>
                </div>

                <div id="documents">
                </div>

                <div class="form-row" id="form_included">
                </div>

                <div class="buttons-container">
                    <button class="button secondary" type="button" id="btnGoBackStep1">@lang('shopping::register_customer.btn.back')</button>
                    <button class="button" type="button" id="btnContinueStep1">@lang('shopping::register_customer.btn.continue')</button>
                </div>
            </div>

            <div class="register__step step step2 fade-in-down" id="step2">
                <div class="error__box hidden" id="error__box_step2">
                    <span class="error__single">
                        <img src="{{ asset('themes/omnilife2018/images/warning.svg') }}"> @lang('shopping::register_customer.error__box'):
                    </span>

                    <ul id="error__box_ul_step2">
                    </ul>
                </div>

                <div class="form-group">
                    <div class="form-label">@lang('shopping::register_customer.mail_address.mail.label'):</div>

                    <div class="col-right">
                        <input class="form-control" type="text" id="email" name="email" placeholder="@lang('shopping::register_customer.mail_address.mail.placeholder')*" maxlength="50">
                    </div>

                    <div class="error-msg" id="div_email"></div>
                </div>

                <div class="form-group">
                    <div class="form-label">@lang('shopping::register_customer.mail_address.confirm_mail.label'):</div>

                    <div class="col-right">
                        <input class="form-control" type="text" id="confirm-email" name="confirm-email" placeholder="@lang('shopping::register_customer.mail_address.confirm_mail.placeholder')*" maxlength="50">
                    </div>

                    <div class="error-msg" id="div_confirm-email"></div>
                </div>

                <div class="form-group{{Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.tel') ? '' : ' hidden'}}">
                    <div class="form-label">@lang('shopping::register_customer.mail_address.tel.label'):</div>

                    <div class="col-right">
                        <input class="form-control" type="text" id="tel" name="tel" placeholder="@lang('shopping::register_customer.mail_address.tel.placeholder')*" maxlength="10">
                    </div>

                    <div class="error-msg" id="div_tel"></div>
                </div>

                <div class="form-group{{Config::get('shopping.registercustomer.validate_form.' . Session::get('portal.register_customer.country_corbiz') . '.cel') ? '' : ' hidden'}}">
                    <div class="form-label">@lang('shopping::register_customer.mail_address.cel.label'):</div>

                    <div class="col-right">
                        <input class="form-control" type="text" id="cel" name="cel" placeholder="@lang('shopping::register_customer.mail_address.cel.placeholder')*" maxlength="10">
                    </div>

                    <div class="error-msg" id="div_cel"></div>
                </div>

                <div id="info_send_correo" class="hidden">
                    <h3>@lang('shopping::register_customer.mail_address.info_send')</h3>
                </div>

                <div class="buttons-container">
                    <button class="button secondary" type="button" id="btnGoBackStep2">@lang('shopping::register_customer.btn.back')</button>
                    <button class="button" type="button" id="btnContinueStep2">@lang('shopping::register_customer.btn.continue')</button>
                    <button class="button" type="button" id="btnResendMailRegisterCustomer" style="display: none;">@lang('shopping::register_customer.btn.resend_mail')</button>
                </div>
            </div>
            <!-- registro paso 2-->
            <div class="register__step step step2 fade-in-down{{($activation) ? ' active' : ''}}" id="step3">
                <div class="error__box hidden" id="error__box_step3">
                    <span class="error__single">
                        <img src="{{ asset('themes/omnilife2018/images/warning.svg') }}"> @lang('shopping::register_customer.error__box'):
                    </span>

                    <ul id="error__box_ul_step3">
                    </ul>
                </div>

                <div class="form-group" id="step3_div_1">
                    <div class="form-label">@lang('shopping::register_customer.activation.question'):</div>
                    <div class="col-right">
                        <div class="select">
                            <select class="form-control" name="secret-question" id="secret-question">
                                <option value="default">@lang('shopping::register_customer.activation.option')</option>
                            </select>

                            <div class="error-msg" id="error-msg-questions"></div>
                            <div class="error-msg error-validation" id="div_secret-question"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="step3_div_2">
                    <div class="form-label">@lang('shopping::register_customer.activation.answer'):</div>

                    <div class="col-right">
                        <input class="form-control" type="text" id="response-question" name="response-question" placeholder="@lang('shopping::register_customer.activation.placeholder')*" maxlength="50">

                        <div class="error-msg error-validation" id="div_response-question"></div>
                    </div>
                </div>

                <div class="buttons-container" id="step3_div_3">
                    <button class="button" type="button" id="btnContinueStep3">@lang('shopping::register_customer.btn.activate')</button>
                </div>

                <div class="register__banner text-center hidden" id="data_corbiz">
                </div>

                <div class="form-group hidden">
                    <input id="code_customer" name="code_customer" type="hidden" value="">
                    <input id="password_customer" name="password_customer" type="hidden" value="">
                    <input id="country_corbiz_customer" name="country_corbiz_customer" type="hidden" value="">
                    <input id="language_corbiz_customer" name="language_corbiz_customer" type="hidden" value="">
                </div>

                <div class="buttons-container">
                    <button class="button" type="button" id="btnFinishShopping" style="display: none;">@lang('shopping::register_customer.btn.finish.shopping')</button>
                    <button class="button" type="button" id="btnFinishLogin" style="display: none;">@lang('shopping::register_customer.btn.finish.login')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('themes.omnilife2018.sections.loader')

@include('shopping::partial_views.exit_register')

<button id="btnExitModalRegister" data-modal="true" style="display: none;" href="#exitModalRegister"></button>

{!! PageBuilder::section('footer') !!}

<script>
    var hrefExit            = '';
    var typeExit            = '';
    var currentCountryId    = '';
    var newCountryId        = '';
    var currentLangId       = '';
    var newLangId           = '';
    var lang                = '';
    var countryId           = '';
    var countryCorbiz       = '';
    var hasSession          = true;
    var translations        = {
        errorEmptyShippingCompanies:    '{{trans("shopping::register.kit.shippingCompanies_empty")}}',
        errorStreetCorbiz:              '{{trans("shopping::register_customer.fields.street_corbiz")}}',
    };
    @if(session('modalExit') || session()->get('portal.main.zipCode') == null)
    var zipCodeSession      = null;
    @else
    var zipCodeSession      = '{{session()->get('portal.main.zipCode')}}';
    @endif

    $(document).ready(function () {
        $('#btnCloseLoginSection').click(function() {
            $('.overlay').hide();
        });
    });
</script>

@if($activation)
<script>
    $(document).ready(function() {
        countryId   = '{{Session::get('portal.main.country_id')}}';
        getQuestions(countryId);

        /* Registro Inconcluso - Al cambiar de país, cambiar lenguaje o click en login */
        $('a').on({
            click: function(e) {
                if (hasSession == true) {
                    var tagClass = $(this).attr('class');
                    var attrId = $(this).attr('id');

                    if (tagClass == 'change_country_header') {
                        e.stopPropagation();
                        currentCountryId = $(this).data('countryidcurrent');
                        newCountryId = $(this).data('countryid');
                        typeExit = 'refresh_country';

                        if (currentCountryId != newCountryId) {
                            $('#btnExitModalRegister').click();
                        }
                    }
                    else if (tagClass == 'change_language_header') {
                        e.stopPropagation();
                        currentLangId = $(this).data('langidcurrent');
                        newLangId = $(this).data('langid');
                        typeExit = 'refresh_lang';

                        if (currentLangId != newLangId) {
                            $('#btnExitModalRegister').click();
                        }
                    }
                    else if (attrId == 'login-btn') {
                        e.stopPropagation();
                        e.preventDefault();
                        $('.login').removeClass('active');
                        $('#btnExitModalRegister').click();
                        typeExit = 'section';
                        hrefExit = '.login';
                    }
                }
            }
        });

        /* Registro Inconcluso - Alerta al hacer click en el icono de login */
        $('.icon-btn').on({
            click: function() {
                if (hasSession == true) {
                    var attrId = $(this).attr('id');
                    typeExit = 'section';

                    if (attrId == 'iuser') {
                        $('.login').removeClass('active');
                        hrefExit = '.login';
                        $('#btnExitModalRegister').click();
                    }
                    else if (attrId == 'icart') {
                        $('.cart-preview').removeClass('active');
                        typeExit = 'change_url';
                        hrefExit = "{{session()->get('portal.main.brand.domain')}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}";
                        $('#btnExitModalRegister').click();
                    }
                }
            }
        });

        //Validamos los campos obligatorios del step3
        $('#btnContinueStep3').click(function() {
            validateStep3();
        });

        //Inciamos Sesion
        $('#btnFinishShopping').click(function() {
            var url = "{{route('checkout.index')}}";

            loginRegisterCustomer(url);
        });

        //Rediregimos a Login
        $('#btnFinishLogin').click(function() {
            var url = URL_PROJECT;

            loginRegisterCustomer(url);
        });

        $('#btnAcceptModalExitRegister').click(function() {
            if (typeExit == 'section') {
                $('.overlay').show();
                $(hrefExit).addClass('active');
                $('#btnCancelModalExitRegister').click();
            }
            else if (typeExit == 'change_url') {
                var url         = "{{route('registercustomer.exit')}}";
                var dataForm    = {
                    name_session:           'register_customer',
                    url_next_exit_register: hrefExit,
                };

                modalUnfinishedRegister(url, dataForm);
            }
            else if (typeExit == 'refresh_lang') {
                $('.loader').removeClass('hide').addClass('show');

                if (currentLangId != newLangId) {
                    change_country_language(newLangId, 'language');
                }
            }
            else if (typeExit == 'refresh_country') {
                $('.loader').removeClass('hide').addClass('show');

                if(currentCountryId != newCountryId) {
                    change_country_language(newCountryId, 'country');
                }
            }
            else {
                var url         = "{{route('registercustomer.exit')}}";
                var dataForm    = {
                    name_session:           $('#name_session').val(),
                    url_next_exit_register: $('#url_next_exit_register').val(),
                };

                modalUnfinishedRegister(url, dataForm);
            }
        });
    });

    //Se obtienen las preguntas secreteas cuando se cambia de país en el select
    function getQuestions(country) {
        //Llamado Secret Questions
        $.ajax({
            type: 'POST',
            url: "{{ route('register.questions') }}",
            data: {'country': country, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function(result) {
                if (result.success) {
                    $('#secret-question').children('option:not(:first)').remove();
                    $('#error-msg-questions').html('');
                    $('#secret-question').removeClass('has-error');

                    $.each(result.data, function(i, item) {
                        $('#secret-question').append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                    });
                }
                else {
                    $("#error-msg-questions").html(result.message);
                    $('#secret-question').addClass('has-error');
                }
            },
            error:function(result) {
                $("#error-msg-questions").html(result.message);
            },
            beforeSend: function() {
                $("#secret-question").children('option:not(:first)').remove();
            },
            complete: function() {
            }
        });
    }

    function validateStep3() {
        var url         = "{{route('registercustomer.validate_step3')}}";
        var form        = $('#formRegisterCustomer');
        var tipo        = 'customer';
        var step        = 'step3';
        var nextStep    = 'step4';

        validateFieldsPortal(url,form,tipo,step,nextStep);
    }

    function generateTransaction() {
        var html_corbiz = '';

        $.ajax({
            url: "{{route('registercustomer.generate_transaction')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {
                code:       '{{Session::get('portal.register_customer.ca.id')}}',
                question:   $('#secret-question').val(),
                answer:     $('#response-question').val(),
            },
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                if (data.success == true) {
                    $('#step3_div_1').hide();
                    $('#step3_div_2').hide();
                    $('#step3_div_3').hide();
                    $('.register__banner').removeClass('hidden');

                    html_corbiz += "<img src='" + data.message.url_image + "' alt=''>";
                    html_corbiz += "<p><strong>{{trans('shopping::register_customer.activation.label')}}:</strong></p>";
                    html_corbiz += "<p>{{trans('shopping::register_customer.activation.code')}}: " + data.message.code + "</p>";
                    html_corbiz += "<p>{{trans('shopping::register_customer.activation.password')}}: " + data.message.password + "</p>";
                    html_corbiz += "<p>{{trans('shopping::register_customer.activation.question')}}: " + data.message.question + "</p>";

                    $('#data_corbiz').html(html_corbiz);

                    if (data.message.items == true) {
                        $('#btnFinishShopping').show();
                    }
                    else {
                        $('#btnFinishLogin').show();
                    }

                    $('#code_customer').val(data.message.code);
                    $('#password_customer').val(data.message.password);
                    $('#country_corbiz_customer').val(data.message.country);
                    $('#language_corbiz_customer').val(data.message.language);
                    hasSession = false;

                    $('.loader').removeClass('show').addClass('hide');
                }
                else if (data.success == false) {
                    $('#error__box_step3').show();

                    $.each(data.message, function (key, message) {
                        $('#error__box_ul_step3').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');
                    });

                    if (data.details != '') {
                        $('#error__box_ul_step3').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(data.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                    $('.loader').removeClass('show').addClass('hide');
                }
            },
            beforeSend: function() {
                $('.loader').removeClass('hide').addClass('show');
                $('#error__box_step3').hide();
                $('#error__box_ul_step3').html('');
                $('#data_corbiz').html('');
                $('.register__banner').addClass('hidden');
                $('#btnFinishShopping').hide();
                $('#btnFinishLogin').hide();
            },
            complete: function() {
            },
            error: function() {
                $('html,body').animate({
                    scrollTop: $(".tabs-static").offset().top
                }, 'slow');
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }

    function loginRegisterCustomer(url) {
        $.ajax({
            url: "{{route('login.auth')}}",
            type: 'POST',
            dataType: 'JSON',
            data: {
                'code': $('#code_customer').val(),
                'password': $('#password_customer').val(),
                'country_corbiz': $('#country_corbiz_customer').val(),
                'language_corbiz': $('#language_corbiz_customer').val(),
                'url_previous': url,
            },
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if (data.success == true) {
                    location.href = data.message;
                } else {
                    $('#error__box_step3').show();
                    $('#error__box_ul_step3').html('');

                    if (typeof data.message === "object") {
                        $.each(data.message, function (key, value) {
                            $('#error__box_ul_step3').append('<li>' + value.messUser + '</li>');
                        });
                    } else {
                        $('#error__box_ul_step3').append('<li>{{ trans('shopping::checkout.payment.errors.sys006') }}</li>');
                    }

                    $('.loader').removeClass('show').addClass('hide');
                }
            },
            beforeSend: function () {
                $('.loader').removeClass('hide').addClass('show');
            },
            error: function (data) {
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }
</script>
@else
<script type="text/javascript" src="{{ asset('cms/jquery/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('cms/jquery-ui/jquery-ui.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/jquery.autocomplete.js') }}"></script>
<script>
    $(document).ready(function() {
        lang            = '{{Session::get('portal.main.app_locale')}}';
        countryId       = '{{Session::get('portal.main.country_id')}}';
        countryCorbiz   = '{{Session::get('portal.main.country_corbiz')}}';

        $('#zip').blur(function() {
            zipCodeSession = null;
        });

        /* Registro Inconcluso - Al cambiar de país, cambiar lenguaje o click en login */
        $('a').on({
            click: function(e) {
                var tagClass = $(this).attr('class');
                var attrId = $(this).attr('id');

                if (tagClass == 'change_country_header') {
                    e.stopPropagation();
                    currentCountryId = $(this).data('countryidcurrent');
                    newCountryId = $(this).data('countryid');
                    typeExit = 'refresh_country';

                    if (currentCountryId != newCountryId) {
                        $('#btnExitModalRegister').click();
                    }
                }
                else if (tagClass == 'change_language_header') {
                    e.stopPropagation();
                    currentLangId = $(this).data('langidcurrent');
                    newLangId = $(this).data('langid');
                    typeExit = 'refresh_lang';

                    if (currentLangId != newLangId) {
                        $('#btnExitModalRegister').click();
                    }
                }
                else if (attrId == 'login-btn') {
                    e.stopPropagation();
                    e.preventDefault();
                    $('.login').removeClass('active');
                    $('#btnExitModalRegister').click();
                    typeExit = 'section';
                    hrefExit = '.login';
                }
            }
        });

        /* Registro Inconcluso - Alerta al hacer click en el icono de login */
        $('.icon-btn').on({
            click: function() {
                var attrId = $(this).attr('id');
                typeExit = 'section';

                if (attrId == 'iuser') {
                    $('.login').removeClass('active');
                    hrefExit = '.login';
                    $('#btnExitModalRegister').click();
                }
                else if (attrId == 'icart') {
                    $('.cart-preview').removeClass('active');
                    typeExit = 'change_url';
                    hrefExit = "{{session()->get('portal.main.brand.domain')}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}";
                    $('#btnExitModalRegister').click();
                }
            }
        });

        getParameters(countryId);
        loadView(countryCorbiz);
        getQuestions(countryId);

        //Se obtienen las referencias y el pool de empresario asl seccionar que no fuiste invitado
        $('#invited2').click(function() {
            $('#valid-eo').removeClass('alert-businessman alert-success');
            $('#valid-eo').html('');

            //Llamado registration references
            $.ajax({
                type: 'POST',
                url: "{{ route('registercustomer.references') }}",
                data: {'country': countryId, _token: '{{csrf_token()}}'},
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                success: function(result) {
                    if (result.success) {
                        $('#references').children('option').remove();
                        $('#error-msg-references').html('');

                        $.each(result.data, function (i, item) {
                            $('#references').append($('<option>', {
                                value: item.id,
                                text : item.name
                            }));
                        });

                        @if(session('modalExit'))
                            var dataExit    = jQuery.parseJSON('{!!session('dataUnfinished')!!}');

                            $.each(dataExit, function(key, value) {
                                if (key == 'references') {
                                    $('#references').val(value);
                                }
                            });
                        @endif
                    }
                    else {
                        $('#error-msg-references').html(result.message);
                    }
                },
                error: function(result) {
                    $('#error-msg-references').html(result.message);
                },
                beforeSend: function() {
                    $('#references').children('option:not(:first)').remove();
                    $('#error__box_step1').hide();
                    $('#error__box_ul_step1').html('');
                    $('#register-code').val('');
                },
                complete: function() {
                }
            });

            //llamado pool de empresarios
            $.ajax({
                type: 'POST',
                url: "{{ route('registercustomer.pool') }}",
                data: {'country': countryId, 'lang': lang, _token: '{{csrf_token()}}'},
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                success: function(result) {
                    if (result.success) {
                        info = result.data;
                        $('#error-msg-pool').html('');
                        $('#distributor_name').val(info.distributor_name);
                        $('#distributor_code').val(info.distributor_code);
                        $('#distributor_email').val(info.distributor_email);
                    }
                    else {
                        $('#error-msg-pool').html(result.message);
                    }
                },
                error: function(result) {
                    $('#error-msg-pool').html(result.message);
                },
                beforeSend: function() {
                    $('#distributor_code').val('');
                    $('#distributor_name').val('');
                    $('#distributor_email').val('');
                },
                complete: function() {
                }
            });
        });

        $('#invited1').click(function() {
            $('#error-msg-pool').html('');
            $('#distributor_name').val('');
            $('#distributor_code').val('');
            $('#distributor_email').val('');
        });

        //se valida si el empresario ingresado existe
        $('#register-code').blur(function() {
            var sponsor = $('#register-code').val();

            $.ajax({
                type: 'POST',
                url: "{{route('registercustomer.validateeo')}}",
                data: {'country': countryId, 'sponsor': sponsor, 'lang': lang},
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(result) {
                    if (result.status){
                        info = result.data;
                        $('#valid-eo').addClass('alert-businessman alert-success');
                        $('#valid-eo').html(info.name_1);
                        $('#distributor_name').val(info.name_1);
                        $('#distributor_code').val(info.dist_id);
                        $('#distributor_email').val(info.email);
                    }
                    else {
                        $('#error__box_step1').show();
                        $('#register-code').addClass('has-error');

                        $.each(result.messages, function (key, value) {
                            var id_error = (value.idError == '') ? '' : ' (' + value.idError + ')';
                            $('#error__box_ul_step1').append('<li>' + $.trim(value.messUser) + $.trim(id_error) + '</li>');
                        });

                        if (result.details != '') {
                            $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(result.details);
                        }

                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    }
                },
                error: function(result) {
                },
                beforeSend: function() {
                    $('#error__box_step1').hide();
                    $('#error__box_ul_step1').empty();
                    $('#register-code').removeClass('has-error');
                    $('#valid-eo').removeClass('alert-businessman alert-success');
                    $('#valid-eo').html('');
                    $('#distributor_name').val('');
                    $('#distributor_code').val('');
                    $('#distributor_email').val('');
                },
                complete: function() {
                }
            });
        });

        //Validamos los campos obligatorios del step1
        $('#btnContinueStep1').click(function() {
            validateStep1();
        });

        //Validamos los campos obligatorios del step2
        $('#btnContinueStep2').click(function() {
            validateStep2();
        });

        //Reenvio de email
        $('#btnResendMailRegisterCustomer').click(function() {
            resendMailRegisterCustomer();
        });

        //GoBack Step1
        $('#btnGoBackStep1').click(function() {
            backStep1();
        });

        //GoBack Step2
        $('#btnGoBackStep2').click(function() {
            $('#tab__step2').removeClass('active');
            $('#step2').removeClass('active');
            $('#tab__step1').addClass('active');
            $('#step1').addClass('active');

            $.ajax({
                type: 'POST',
                url: "{{route('registercustomer.backStep2')}}",
                data: {_token: '{{csrf_token()}}'},
                statusCode: { 419: function() { window.location.href = URL_PROJECT; }},
                success : function (data) {
                }
            });
        });

        $('#btnAcceptModalExitRegister').click(function() {
            if (typeExit == 'section') {
                $('.overlay').show();
                $(hrefExit).addClass('active');
                $('#btnCancelModalExitRegister').click();
            }
            else if (typeExit == 'change_url') {
                var url         = "{{route('registercustomer.exit')}}";
                var dataForm    = {
                    name_session:           'register_customer',
                    url_next_exit_register: hrefExit,
                };

                modalUnfinishedRegister(url, dataForm);
            }
            else if (typeExit == 'refresh_lang') {
                $('.loader').removeClass('hide').addClass('show');

                if (currentLangId != newLangId) {
                    change_country_language(newLangId, 'language');
                }
            }
            else if (typeExit == 'refresh_country') {
                $('.loader').removeClass('hide').addClass('show');

                if(currentCountryId != newCountryId) {
                    change_country_language(newCountryId, 'country');
                }
            }
            else {
                var url         = "{{route('registercustomer.exit')}}";
                var dataForm    = {
                    name_session:           $('#name_session').val(),
                    url_next_exit_register: $('#url_next_exit_register').val(),
                };

                modalUnfinishedRegister(url, dataForm);
            }
        });

        if ($('#register-code').val() != '' && $('#register-code').attr('rel') == 1) {
            $('#invited-yes').removeClass('hidden hide');
            $('#register-code').attr('readonly','readonly');
            $('.radioEo').addClass('hidden hide');
            $('#register-code').blur();
            $('#invited1').prop('checked',true);
        }
    });

    $(document).on('change', '#city', function() {
        var selectCity          = document.getElementById('city');
        var selectedOptionCity  = selectCity.options[selectCity.selectedIndex].text;
        var value               = $(this).val();

        $('#city_name').val(selectedOptionCity);

        if (value == 'default') {
            $('#city_hidden').val('');
        }
        else {
            $('#city_hidden').val(value);
        }

        getShippingCompanyFromCorbiz($('#state').val(),$('#city').val());
    });

    $(document).on('change', '#state', function() {
        var state       = $(this).val();
        var htmlCities  = '';

        if (state != 'default') {
            $.ajax({
                type: 'POST',
                url: "{{route('registercustomer.cities')}}",
                data: {'country': countryCorbiz, 'state': state, _token: '{{csrf_token()}}'},
                statusCode: {
                    419: function () {
                        window.location.href = URL_PROJECT;
                    }
                },
                success: function (result) {
                    if (result.status) {
                        $("#error__box_ul_step1").html("");
                        $("#error__box_step1").hide();
                        $('#city').removeClass('has-error');

                        htmlCities += '<option value="default">@lang("shopping::register_customer.account.address.placeholders.city")*</option>';

                        $.each(result.data, function (i, item) {
                            htmlCities += '<option value="' + $.trim(item.id) + '">' + $.trim(item.name) + '</option>';
                        });

                        $("#city").html(htmlCities);

                        if (state == 'default') {
                            $('#state_hidden').val('');
                        }
                        else {
                            $('#state_hidden').val(state);
                        }

                        $('.loader').removeClass('show').addClass('hide');
                    }
                    else {
                        $("#error__box_step1").show();
                        $("#error__box_ul_step1").html("");
                        $("#city").addClass("has-error");

                        $.each(result.messages, function (key, value) {
                            var id_error = (value.idError == '') ? '' : ' (' + value.idError + ')';
                            $('#error__box_ul_step1').append('<li>' + $.trim(value.messUser) + $.trim(id_error) + '</li>');
                        });

                        if (result.details != '') {
                            $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(result.details);
                        }

                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');

                        $('.loader').removeClass('show').addClass('hide');
                    }
                },
                error: function (result) {
                    $('.loader').removeClass('show').addClass('hide');
                },
                beforeSend: function () {
                    $('.loader').removeClass('hide').addClass('show');
                    $("#error__box_ul_step1").html("");
                    $("#error__box_step1").hide();
                    $("#city").children('option:not(:first)').remove();
                },
                complete: function () {
                }
            });
        }
    });

    $(document).on('keyup', '#street', function() {
        var street = $(this).val();
        var appliesValidation = '{{config('shopping.defaultValidationForm.' . session()->get('portal.register_customer.country_corbiz') . '.specialstreet')}}';

        if (appliesValidation) {
            $.ajax({
                type: 'POST',
                url: "{{route('registercustomer.validatestreet')}}",
                data: { 'street': street, _token: '{{csrf_token()}}' },
                statusCode: {
                    419: function() {
                        window.location.href = URL_PROJECT;
                    }
                },
                success: function(result) {
                    if (result.passes) {
                        $('#btnContinueStep1').attr('disabled', false);
                        $('#div_message_street').html('');
                        $('#div_message_street').html(result.message);
                        $('#div_message_street').css('color', 'dodgerblue');
                    }
                    else {
                        $('#btnContinueStep1').attr('disabled', true);
                        $('#div_message_street').html('');
                        $('#div_message_street').html(result.message);
                        $('#div_message_street').css('color', 'red');
                    }
                },
                error: function(result) {},
                beforeSend: function() {},
                complete: function() {}
            });
        }

    });

    function loadView(countryId){
        $.ajax({
            type: 'POST',
            url: "{{ route('registercustomer.changeview') }}",
            data: {'country': countryId, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success : function (data) {
                $("#form_included").html(data);
                getStates(countryId);
            }
        });
    }

    //Se obtienen las preguntas secreteas cuando se cambia de país en el select
    function getQuestions(countryId) {
        //Llamado Secret Questions
        $.ajax({
            type: 'POST',
            url: "{{ route('register.questions') }}",
            data: {'country': countryId, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function(result) {
                if (result.success) {
                    $('#secret-question').children('option:not(:first)').remove();
                    $('#error-msg-questions').html('');
                    $('#secret-question').removeClass('has-error');

                    $.each(result.data, function(i, item) {
                        $('#secret-question').append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                    });
                }
                else {
                    $("#error-msg-questions").html(result.message);
                    $('#secret-question').addClass('has-error');
                }
            },
            error:function(result) {
                $("#error-msg-questions").html(result.message);
            },
            beforeSend: function() {
                $("#secret-question").children('option:not(:first)').remove();
            },
            complete: function() {
            }
        });
    }

    //Llamado Parametros de Inscripcion
    function getParameters(countryId) {
        $.ajax({
            type: "POST",
            url: "{{ route('registercustomer.parameters') }}",
            data: {'country': countryId, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function (result){
                if (result.success) {
                    var info = result.data;
                    $("#error-msg-parameters").html("");
                    $('#year').removeClass('has-error');

                    for (d = 1; d <= 31; d++) {
                        $('#day').append($('<option>', {
                            value: d,
                            text : d
                        }));
                    }

                    @foreach($months as $key => $month)
                        $('#month').append('<option value="{{$key}}">{{trans($month)}}</option>');
                    @endforeach

                    for (x= info.fechain;x >= info.fecha_fin; x--) {
                        $('#year').append($('<option>', {
                            value: x,
                            text : x
                        }));
                    }

                    if (info.has_documents == 1) {
                        $("#documents").show('fadeIn');
                        //llamado a documentos de corbiz por país
                        getDocumentsFromCorbiz(countryId);
                    }
                }
                else {
                    $("#error-msg-parameters").html(result.message);
                    $('#year').addClass('has-error');
                    $('#day').addClass('has-error');
                    $('#month').addClass('has-error');
                    $('#documents').hide();
                }
            },
            error: function(result) {
                $("#error-msg-parameters").html(result.message);
            },
            beforeSend: function() {
                $("#error-msg-parameters").html("");
                $('#day').children('option:not(:first)').remove();
                $('#month').children('option:not(:first)').remove();
                $('#year').children('option:not(:first)').remove();
            },
            complete: function() {
            }
        });
    }

    function getDocumentsFromCorbiz(countryId){
        var html = '';

        $.ajax({
            type: "POST",
            url: "{{ route('registercustomer.documents') }}",
            data: {'country': countryId, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function(result) {
                if (result.status) {
                    for (i = 1; i <= result.numDocs; i ++) {
                        html += '<div class="form-row">';
                        html += '<div class="form-label block">' + '{{trans("shopping::register_customer.account.identification.label")}}' + ' ' + i + '</div>';
                        html += '<div class="form-group select medium">';
                        html += '<select class="form-control" name="id_type[' + i + ']" id="id_type' + i + '" onchange="disableOptionDocument(' + i + ',' + result.numDocs + ')">';
                        html += '<option value="default">{{trans("shopping::register_customer.account.identification.option")}}</option>';
                        html += '<input type="hidden" name="id_type_name[' + i + ']" id="id_type_name' + i + '" value="" />';
                        html += '</select>';
                        html += '<div class="error-msg" id="div_id_type' + i + '"></div>';
                        html += '</div>';
                        html += '<div class="form-group medium">';
                        html += '<input class="form-control" type="text" name="id_num[' + i + ']" id="id_num' + i + '" placeholder="' + '{{trans("shopping::register_customer.account.identification.placeholder")}}' + '*" maxlength="20">';
                        html += '<div class="error-msg" id="div_id_num' + i + '"></div>';
                        html += '</div>';
                        if(result.active_expiration){
                            html += '<div class="form-group medium">';
                            html += '<input class="form-control pickers" type="text" onfocus="openPicker(' + i + ')" name="id_expiration[' + i + ']" id="id_expiration' + i + '" placeholder="' + '{{trans("shopping::register_customer.account.expiration.placeholder")}}' + '*">';
                            html += '<div class="error-msg" id="div_id_expiration' + i + '"></div>';
                            html += '</div>';
                        }
                        html += '</div>';
                    }

                    $('#documents').html(html);

                    for (x = 1; x <= result.numDocs; x ++) {
                        $.each(result.data, function(i, item) {
                            $('#id_type' + x).append($('<option>', {
                                value:  item.id,
                                text:   item.name,
                            }));
                        });

                        @if(!session('modalExit'))
                        if (x > 1) {
                            $('#id_type' + x).prop('disabled', true);
                            $('#id_num' + x).prop('readonly', true);
                            $('#id_expiration' + x).prop('readonly', true);
                        }
                        @endif
                    }
                }
                else {
                    $('#error__box_step1').show();
                    $('#error__box_ul_step1').html('');

                    $.each(result.messages, function (i, item) {
                        $('#error__box_ul_step1').append('<li>' + item + '</li>');
                    });
                }
            },
            error: function(result) {
                console.log(result);
            },
            beforeSend: function() {
                $('#error__box_ul_step1').html('');
                $('#error__box_step1').hide();
            },
            complete: function() {
            }
        });
    }

    function getShippingCompanyFromCorbiz(state,city) {
        $.ajax({
            type: 'POST',
            url: "{{route('registercustomer.shippingCompanies')}}",
            data: {'state': state, 'city': city},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (result) {
                if (result.status) {
                    if(!$.trim(result.data)) {
                        $('#shipping_company').addClass('has-error');
                        $('#error__box_step1').show();
                        $('#div_shipping_company').append(translations.errorEmptyShippingCompanies);
                    }
                    else {
                        $.each(result.data, function(i, item) {
                            $('#shipping_company').append($('<option>', {
                                value:  item.id,
                                text:   item.name,
                            }));
                        });

                        @if(session('modalExit'))
                            var data                = jQuery.parseJSON('{!!session('dataUnfinished')!!}');

                            if (data != null || data != '') {
                                $.each(data, function (key, value) {
                                    if (key == 'shipping_company') {
                                        $('#shipping_company').val(value);
                                    }
                                });
                            }
                        @endif
                    }

                    $('.loader').removeClass('show').addClass('hide');
                }
                else {
                    $('#error__box_step1').show();

                    $.each(result.messages, function(key, message) {
                        var id_error = (message.idError != '') ? ' (' + $.trim(message.idError) + ')' : '';

                        $('#error__box_ul_step1').append('<li>' + $.trim(message.messUser) + id_error + '</li>');
                    });

                    if (result.details != '') {
                        $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');

                    $('.loader').removeClass('show').addClass('hide');
                }
            },
            error:function(result) {
                $('.loader').removeClass('show').addClass('hide');
            },
            beforeSend: function() {
                $('#div_shipping_company').empty();
                $('#shipping_company').removeClass('has-error');
                $('.loader').removeClass('hide').addClass('show');
                $('#error__box_ul_step1').empty();
                $('#error__box_step1').hide();
                $('#shipping_company').children('option:not(:first)').remove();
            },
            complete: function () {
            }
        });
    }

    function disableOptionDocument(id,numDocs) {
        var typeText    = $('#id_type' + id).find('option:selected').text();
        var newId       = 0;

        $('#id_type_name' + id).val(typeText);

        if (id < numDocs) {
            newId = id + 1;

            for (x = newId; x <= numDocs; x ++) {
                $('#id_num' + id).val('');
                $('#id_num' + x).val('');

                $('#id_type' + x + ' option').each(function () {
                    $(this).removeAttr('disabled').removeClass('optionDisabled');
                });

                $('#id_type' + x).prop('disabled', true);
                $('#id_num' + x).prop('readonly', true);
                $('#id_expiration' + x).prop('readonly', true);
                $('#id_type' + x).children('option[value="default"]').prop('selected', true);

                for (y = 1; y <= id; y ++) {
                    $('#id_type' + x).children('option[value="' + $('#id_type' + y).val() + '"]').prop('disabled', true).addClass('optionDisabled');
                }
            }

            $('#id_type' + newId).prop('disabled', false);
            $('#id_num' + newId).prop('readonly', false);
            $('#id_expiration' + newId).prop('readonly', false);
        }
    }

    function openPicker(id) {
        var item = id;

        $('#id_expiration' + item).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 1
        });
    }

    function getStates(countryId) {
        var stateHtml = '';

        $.ajax({
            type: 'POST',
            url: "{{ route('registercustomer.states') }}",
            data: {'country': countryId, _token: '{{csrf_token()}}'},
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            success: function(result) {
                if(result.status) {
                    $('#error__box_ul_step1').html("");
                    $('#error__box_step1').hide();
                    $('#state').removeClass('has-error');

                    stateHtml += '<option value="default">@lang("shopping::register_customer.account.address.placeholders.state")*</option>';

                    $.each(result.data, function(i, item) {
                        stateHtml += '<option value="' + $.trim(item.id) + '">' + $.trim(item.name) + '</option>';
                    });

                    $("#state").html(stateHtml);
                    getZipCodeFromCorbiz(zipCodeSession);
                }
                else {
                    $("#error__box_step1").show();
                    $("#error__box_ul_step1").html("");
                    $("#state").addClass("has-error");

                    $.each(result.messages, function(key, message) {
                        var id_error = (message.idError != '') ? ' (' + $.trim(message.idError) + ')' : '';
                        $('#error__box_ul_step1').append('<li>' + $.trim(message.messUser) + id_error + '</li>');
                    });

                    if (result.details != '') {
                        $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(result.details);
                    }

                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            error: function(result) {
            },
            beforeSend: function() {
                $("#error__box_ul_step1").html("");
                $("#error__box_step1").hide();
                $("#state").children('option:not(:first)').remove();
            },
            complete: function() {
            }
        });
    }

    function getZipCodeFromCorbiz(zip) {
        if (zip != null) {
            $.ajax({
                url: "{{route('registercustomer.zipcode')}}",
                type: 'POST',
                dataType: 'JSON',
                data: {zipCode: zip},
                statusCode: {
                    419: function () {
                        window.location.href = URL_PROJECT;
                    }
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (result) {

                    if(result.status){
                        $('#zip').val(result.suggestions[0].data.zipcode);
                        $('#state').val(result.suggestions[0].data.idState);
                        $('#state_hidden').val(result.suggestions[0].data.idState);

                        citybystate(result.suggestions[0].data.idState, result.suggestions[0].data.idCity, result.suggestions[0].data.cityDescr, urlcities, token, validate, tipo);

                        if (check == 'county') {
                            $('#colony').val(result.suggestions[0].data.county);
                        }
                        else if (check == 'suburb') {
                            $('#colony').val(result.suggestions[0].data.suburb);
                        }

                        $('#city_hidden').val(result.suggestions[0].data.idCity);

                        $('.loader').removeClass('show').addClass('hide');
                    }else{
                        $('.loader').removeClass('show').addClass('hide');
                        $("#error__box_step1").show();
                        $("#error__box_ul_step1").html("");
                        $("#state").addClass("has-error");

                        $.each(result.messages, function (i, item) {
                            if(item.messUser == null){
                                $("#error__box_ul_step1").append("<li class='text-danger'>" + item + "</li>");

                            }else{
                                $("#error__box_ul_step1").append("<li class='text-danger'>" + item.messUser + "</li>");

                            }
                        });

                        if (result.details != '') {
                            $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(result.details);
                        }


                    }

                },
                beforeSend: function () {
                    $('.loader').removeClass('hide').addClass('show');
                },
                error: function(result) {
                    $('.loader').removeClass('show').addClass('hide');
                }
            });
        }
    }

    function clear_form_elements() {
        $("#form_included").find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
        });
    }

    function backStep1() {
        typeExit    = 'change_url';
        hrefExit    = '/';

        $('#btnExitModalRegister').click();
    }

    function validateStep1() {
        var url         = "{{route('registercustomer.validate_step1')}}";
        var form        = $('#formRegisterCustomer');
        var tipo        = 'customer';
        var step        = 'step1';
        var nextStep    = 'step2';

        validateFieldsPortal(url, form, tipo, step, nextStep);
    }

    function validateStep2() {
        var url         = "{{route('registercustomer.validate_step2')}}";
        var form        = $('#formRegisterCustomer');
        var tipo        = 'customer';
        var step        = 'step2';
        var nextStep    = 'step3';

        validateFieldsPortal(url,form,tipo,step,nextStep);
    }

    function validateCustomer(dataForm) {
        $.ajax({
            url: "{{route('registercustomer.validate_corbiz')}}",
            type: 'POST',
            dataType: 'JSON',
            data: dataForm,
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                if (data.success == true) {
                    saveRegisterCustomer(dataForm);
                }
                else if (data.success == false) {
                    $('#error__box_step1').show();
                    $('#error__box_step2').show();

                    $.each(data.message, function (key, message) {
                        $('#error__box_ul_step1').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');
                        $('#error__box_ul_step2').append('<li>' + $.trim(message.messUser) + ' (' + message.idError + ')</li>');

                        if (message.idError == '10026') {
                            $('#street').removeClass('has-error').addClass('has-error');
                            $('#div_street').empty().append(translations.errorStreetCorbiz);
                        }
                    });

                    if (data.details != '') {
                        $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        $('#error__box_ul_step2').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                        setErrors(data.details);
                    }

                    $('.loader').removeClass('show').addClass('hide');
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            beforeSend: function() {
                $('#error__box_step1').hide();
                $('#error__box_ul_step1').html('');
                $('#error__box_step2').hide();
                $('#error__box_ul_step2').html('');
            },
            complete: function() {
            }
        });
    }

    function saveRegisterCustomer(dataForm) {
        $.ajax({
            url: "{{route('registercustomer.save')}}",
            type: 'POST',
            dataType: 'JSON',
            data: dataForm,
            statusCode: {
                419: function() {
                    window.location.href = URL_PROJECT;
                }
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                if (data.success == true) {
                    $('#email').prop('readonly', true);
                    $('#confirm-email').prop('readonly', true);
                    $('#tel').prop('readonly', true);
                    $('#cel').prop('readonly', true);
                    $('#info_send_correo').removeClass('hidden');
                    $('#btnGoBackStep2').hide();
                    $('#btnContinueStep2').hide();
                    $('#btnResendMailRegisterCustomer').show();
                    $('.loader').removeClass('show').addClass('hide');
                }
                else if (data.success == false) {
                    $('#error__box_step2').show();
                    $('#error__box_ul_step2').html('<li>' + data.message + '</li>');
                    $('.loader').removeClass('show').addClass('hide');
                    $('html,body').animate({
                        scrollTop: $(".tabs-static").offset().top
                    }, 'slow');
                }
            },
            beforeSend: function() {
                $('#error__box_step2').hide();
                $('#error__box_ul_step2').html('');
                $('#email').prop('readonly', false);
                $('#confirm-email').prop('readonly', false);
                $('#tel').prop('readonly', false);
                $('#cel').prop('readonly', false);
            },
            complete: function() {
            }
        });
    }
    
    function resendMailRegisterCustomer() {
        $('#info_send_correo').addClass('hidden');
        $('#btnResendMailRegisterCustomer').prop('disabled', true);
        $('.loader').removeClass('hide').addClass('show');

        $.get("{{route('registercustomer.send_mail')}}", function(data) {
            if (data.success == true) {
                $('#info_send_correo').removeClass('hidden');
                $('#btnResendMailRegisterCustomer').prop('disabled', false);
                $('.loader').removeClass('show').addClass('hide');
            }
            else {
                $('#info_send_correo').removeClass('hidden');
                $('#btnResendMailRegisterCustomer').prop('disabled', false);
                $('.loader').removeClass('show').addClass('hide');
            }
        });
    }

    /* Registro Inconcluso */
    @if(session('modalExit'))
    $('#btnCancelModalExitRegister').click(function() {
        @if(session('stepUnfinished') != null)
        /* Tab Activa */
        $('#tab__step1').removeClass('active');
        $('#step1').removeClass('active');
        $('#tab__step' + '{{session('stepUnfinished')}}').addClass('active');
        $('#step' + '{{session('stepUnfinished')}}').addClass('active');
        @endif

        /* Carga de Datos al Formulario */
        var data        = jQuery.parseJSON('{!!session('dataUnfinished')!!}');
        var city        = '';
        var invited     = '';

        if (data != null || data != '') {
            $.each(data, function(key, value) {
                if (key == 'invited') {
                    if (value == 1) {
                        invited = 1;
                        $('#invited1').click();
                    }
                    else if (value == 0) {
                        invited = 0;
                        $('#invited2').click();
                    }
                }
                else if (key == 'sex') {
                    if (value == 1) {
                        $('#sex1').click();
                    }
                    else if (value == 0) {
                        $('#sex2').click();
                    }
                }
                else if (key == 'id_type' || key == 'id_num' || key == 'id_expiration' || key == 'id_type_name') {
                    $.each(value, function(key2, value2) {
                        $('#' + key + key2).val(value2);
                    });
                }
                else if (key == 'city_hidden' || key == 'city') {
                    if (value != null || value != '') {
                        city = value;
                    }
                }
                else if (key == 'state_hidden' || key == 'state') {
                    if (value != null || value != '') {
                        $('#state').val(value);
                        $('#state_hidden').val(value);
                    }
                }
                else {
                    $('#' + key).val(value);
                }
            });

            getCities($('#state_hidden').val(), city);
            @if(!isset($codEo) && !isset($numEo))
            $('#invited-yes').removeClass('hidden hide');
            $('#register-code').attr('readonly','readonly');
            $('.radioEo').addClass('hidden hide');
            $('#register-code').blur();
            $('#invited1').prop('checked',true);
            $(".normal").removeClass('hide hidden');
            $(".sponsored").addClass('hide hidden');
            @else
                $(".normal").addClass('hide hidden');
            $(".sponsored").removeClass('hide hidden');
            if (invited == 1) {
                $('#register-code').blur();
            }
            @endif
        }
    });

    function getCities(state, city) {
        var htmlCities = '';

        if (state != 'default') {
            $.ajax({
                type: 'POST',
                url: "{{route('registercustomer.cities')}}",
                data: {'country': countryCorbiz, 'state': state, _token: '{{csrf_token()}}'},
                statusCode: {
                    419: function () {
                        window.location.href = URL_PROJECT;
                    }
                },
                success: function (result) {
                    if (result.status) {
                        $("#error__box_ul_step1").html("");
                        $("#error__box_step1").hide();
                        $('#city').removeClass('has-error');

                        htmlCities += '<option value="default">@lang("shopping::register_customer.account.address.placeholders.city")*</option>';

                        $.each(result.data, function (i, item) {
                            htmlCities += '<option value="' + $.trim(item.id) + '">' + $.trim(item.name) + '</option>';
                        });

                        $("#city").html(htmlCities);
                        $('#city').val(city);
                        $('#city_hidden').val(city);

                        var cityText = $('#city').find('option:selected').text();
                        $('#city_name').val(cityText);

                        getShippingCompanyFromCorbiz(state, city);
                    }
                    else {
                        $("#error__box_step1").show();
                        $("#error__box_ul_step1").html("");
                        $("#city").addClass("has-error");

                        $.each(result.messages, function (key, value) {
                            var id_error = (value.idError == '') ? '' : ' (' + value.idError + ')';
                            $('#error__box_ul_step1').append('<li>' + $.trim(value.messUser) + $.trim(id_error) + '</li>');
                        });

                        if (result.details != '') {
                            $('#error__box_ul_step1').append('<br><a href="#" class="detail-err-open" style="text-align: right;font-size: 12px;color: #F44336;text-decoration: underline;">{{trans('cms::errors.modal.more')}}</a>');
                            setErrors(result.details);
                        }

                        $('html,body').animate({
                            scrollTop: $(".tabs-static").offset().top
                        }, 'slow');
                    }
                },
                error: function (result) {
                },
                beforeSend: function () {
                    $("#error__box_ul_step1").html("");
                    $("#error__box_step1").hide();
                    $("#city").children('option:not(:first)').remove();
                },
                complete: function () {
                }
            });
        }
    }
    @endif
</script>
@endif