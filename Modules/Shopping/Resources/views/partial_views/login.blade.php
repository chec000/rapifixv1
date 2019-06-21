<div class="modal alert access" id="loginShopping">
    <button class="button secondary close modal-close" type="button" id="btnCloseLoginModal">X</button>

    <div class="modal__inner ps-container">
        <div class="modal__body">
            <div class="modal__login">
                <h3 class="modal__login--title">@lang('shopping::login.modal.login.title')</h3>

                <div class="modal__login--content">
                    <form id="formLoginShopping" name="formLoginShopping">
                        <div class="login--form">
                            <div id="error_ws_modal" class="error__box theme__transparent hidden" style="font-size: 10pt;">
                                <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                                <ul id="error_ws_ul_modal">
                                </ul>
                            </div>

                            <input type="text" id="code_modal" name="code" placeholder="@lang('shopping::login.modal.login.user')" class="form-control">

                            <div class="error-msg" id="div_code_modal"></div>

                            <input type="password" id="password_modal" name="password" placeholder="@lang('shopping::login.modal.login.password')" class="form-control">

                            <div class="error-msg" id="div_password_modal"></div>

                            <input class="form-control transparent" type="hidden" name="url_previous" id="url_previous_modal" value="{{session('url_previous')}}">
                            <input class="form-control transparent" type="hidden" name="country_corbiz" id="country_corbiz_modal" value="{{Session::get('portal.main.country_corbiz')}}">
                            <input class="form-control transparent" type="hidden" name="language_corbiz" id="language_corbiz_modal" value="{{Session::get('portal.main.language_corbiz')}}">

                            <button id="btnLoginShopping" class="button small" type="button">@lang('shopping::login.modal.login.btn')</button>
                            <a class="password__recovery" href="{{route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['reset-password', 'index']))}}">@lang('shopping::login.modal.login.reset_password')</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal__register">
                <h3 class="modal__register--title">@lang('shopping::login.modal.register.title')</h3>

      
            </div>
        </div>
    </div>


</div>

@include('themes.omnilife2018.sections.loader')

<button id="btnShowModalLogin" href="#loginShopping" data-modal="true" style="display: none;"></button>