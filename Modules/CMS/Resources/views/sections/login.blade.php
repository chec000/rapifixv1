<section class="login">
    <div class="login__head">
    @if((session()->get('portal.eo.auth') == true))
        <!-- logged in -->
            <p>@lang('cms::login_aside.logged_head'):</p>
    @else
        <!-- login -->
            <p>@lang('cms::login_aside.login_head')</p>
        @endif
        <button id="btnCloseLogin" class="icon-btn icon-cross close" type="button"></button>
    </div>
    <div class="login__content">
    @if ((session()->get('portal.eo.auth') == true))
        <!-- logged in -->
            <div class="login__profile">
                <div class="login__profile-avatar" data-level="{{session()->get('portal.eo.shortTitleName')}}" >
                    <figure class="avatar medium">
                        <img src="{{ asset('themes/omnilife2018/images/user-image.png') }}" alt="Perfil">
                    </figure>
                </div>
                <p class="login__profile-name">{{ session()->get('portal.eo.name1') }}</p>
                <a href="#" class="button default">@lang('cms::login_aside.view_profile')</a>
                <p class="login__profile-points">@lang('cms::login_aside.profile_points'): 000</p>
            </div>
    @else
        <!-- login -->
            <form id="formLoginG" name="formLoginG" method="POST" action="{{ Request::root().'/login/auth' }}">
                <div id="error_ws_login" class="error__box theme__transparent" style="display: none;">
                    <span class="error__single"><img src="{{asset('themes/omnilife2018/images/warning.svg')}}"> @lang('cms::reset_password.errors')</span>
                    <ul id="ul_errors">
                    </ul>
                </div>
                <div class="form-group">
                    <input class="form-control transparent" type="text" name="code" id="code" placeholder="@lang('cms::login_aside.client_code_placeholder')">
                    <div id="div_code" class="error-msg"></div>
                </div>
                <div class="form-group">
                    <input class="form-control transparent" type="password" name="password" id="password" placeholder="@lang('cms::login_aside.password_placeholder')">
                    <div id="div_password" class="error-msg"></div>
                </div>
                <div class="form-group">
                    <input class="form-control transparent" type="hidden" name="url_previous" id="url_previous" value="{{session('url_previous')}}">
                    <input class="form-control transparent" type="hidden" name="country_corbiz" id="country_corbiz" value="{{session()->get('portal.main.country_corbiz')}}">
                    <input class="form-control transparent" type="hidden" name="language_corbiz" id="language_corbiz" value="{{session()->get('portal.main.language_corbiz')}}">
                </div>
                <button id="btnFormLoginG" class="button default" type="button">@lang('cms::login_aside.login_button')</button><a class="link" href="{{url('/resetpassword')}}">@lang('cms::login_aside.password_forgotten')</a>
            </form>
        @endif
        <div class="login__noaccount">
        @if ((session()->get('portal.eo.auth') == true))
            <!-- logged in -->
                <button id="btnLogoutG" class="button transparent">@lang('cms::login_aside.logout')</button>
        @else
            <!-- login -->
                <p class="text">@lang('cms::login_aside.no_account_text')</p><a class="button transparent" href="#">@lang('cms::login_aside.no_account_button')</a>
            @endif
        </div>
    </div>
</section>