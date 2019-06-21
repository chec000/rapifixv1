<!-- starts header-->
<header class="main-h">
    <div class="wrapper">
        <div class="logo main-h__logo">
            <a class="logo" {{ PageBuilder::block('header_logo_link') }}>
                <figure class="icon-omnilife">
                {!! PageBuilder::block('logo') !!}
                </figure>
            </a>
        </div>
        <nav class="main-nav">
            <div class="main-nav__head mov">
                @if (Session::get('portal.eo.auth') == true)
                    <figure class="avatar small">
                        <img class="icon-btn icon-user-logged-header" style="height: 100%;">
                    </figure>
                    <div class="main-nav__user">
                        <div class="main-nav__name">
                            {{Session::get('portal.eo.shortTitleName')}}
                        </div>
                        <div class="main-nav__level">
                            <span>Nivel bronce</span>
                            <span class="sep">|</span>
                            <span class="points">3,000 pts</span>
                        </div>
                    </div>
                @else
                    @if(config('settings::frontend.webservices') == 1)
                        @if((session()->get('portal.eo.auth') == true))
                            <button class="icon-btn icon-user-logged-header" id="iuser-mobile"></button>
                        @else
                            <button class="icon-btn icon-user" id="iuser-mobile"></button>
                        @endif
                    <a class="main-nav__link" id="login-btn-mov" href="#">@lang('cms::header.log_in')</a>
                    <a class="main-nav__link bold" href="#">@lang('cms::header.sign_in')</a>
                    @endif
                @endif
                <button class="icon-btn icon-cross close"></button>
            </div>
            <div class="main-nav__body">
                <input type="hidden" name="country_current_selected" value="{{session()->get('portal.main.country_id')}}" id="country_current_selected">
                <ul class="nav-list top list-nostyle">
                    @if(!empty(session()->get('portal.main.varsMenu.otherBrands')))
                        @foreach(session()->get('portal.main.varsMenu.otherBrands') as $brandMenu)
                            <li class="nav-item nav-item_hover_{{config('cms.brand_css.'.$brandMenu->id) }}"><a data-brandId="{{$brandMenu->id}}" href="{{$brandMenu->domain}}">{{$brandMenu->name}}</a></li>
                        @endforeach
                    @endif

                    @if(session()->get('portal.main.brand.parent_brand_id') != 0 && !empty(session()->get('portal.main.varsMenu.parentBrands')))
                        @if(is_object(session()->get('portal.main.varsMenu.parentBrands')) && count(session()->get('portal.main.varsMenu.parentBrands')) > 1)
                            <li class="nav-item"><a href="#">@lang('cms::header.products')</a>
                                <ul class="nav-item__list list-nostyle">
                                    @foreach(session()->get('portal.main.varsMenu.parentBrands') as $parentBrand)
                                        <li class="nav-item__item">
                                            <a data-brandId="{{$parentBrand->id}}" href="{{$parentBrand->domain}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}">{{$parentBrand->alias}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                                <li class="nav-item"><a href="{{session()->get('portal.main.varsMenu.parentBrands.0.domain')}}/{{ \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('products', session()->get('portal.main.app_locale')) }}"> @lang('cms::header.products')</a></li>
                        @endif
                    @else
                    <!--<li class="nav-item"><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}"> @lang('cms::header.products')</a></li>-->
                    @endif
                    {!! PageBuilder::menu('main_menu',['view' =>'main_menu']) !!}
                </ul>
                <ul class="nav-list list-nostyle">
                    <li class="nav-item dropdown"><span class="dropdown-toggle">@lang('cms::header.country'):
                            <figure class="flag"><img src="{{ asset(session()->get('portal.main.flag')) }}" alt=""></figure>{{session()->get('portal.main.country_name')}}</span>
                        <ul class="dropdown-list list-nostyle">
                            @if(!empty(session()->get('portal.main.brand.countries')))
                                @foreach(session()->get('portal.main.brand.countries') as $countryMenu)
                                    <li class="dropdown-item dropdown-item_change_country">
                                        <a class="change_country_header" data-countryid="{{$countryMenu->id}}"
                                           data-countryidcurrent="{{session()->get('portal.main.country_id')}}">
                                            <figure class="flag">
                                                <img src="{{ asset($countryMenu->flag) }}" alt="{{$countryMenu->name}}">
                                            </figure>{{$countryMenu->name}}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @if(!empty(session()->get('portal.main.varsMenu.countryLangs')) && count(session()->get('portal.main.varsMenu.countryLangs')) > 1)
                    <li class="nav-item dropdown"> <span class="dropdown-toggle">@lang('cms::header.language'): {{session()->get('portal.main.language_name')}}</span>

                        <ul class="dropdown-list list-nostyle">
                            @foreach(session()->get('portal.main.varsMenu.countryLangs') as $index => $langMenu)
                                <li class="dropdown-item dropdown-item_change_lang"><a class="change_language_header" data-langid="{{$index}}"
                                     data-langidcurrent="{{session()->get('portal.main.language_id')}}" type="button">{{$langMenu}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @if(config('settings::frontend.webservices') == 1 && session()->get('portal.main.inscription_active') == 1 && !session()->has('portal.eo'))
                    <li class="nav-item desk bold">
                        <a href="{{route('register')}}">@lang('cms::header.register')</a>
                    </li>
                    @endif
                    @if(config('settings::frontend.webservices') == 1 && !session()->has('portal.eo'))
                        <li class="nav-item desk bold "><a href="#" id="login-btn">@lang('cms::header.sign_in')</a></li>
                    @endif
                </ul>
            </div>
        </nav>
        <ul class="main-h__icons list-nostyle">
            <li class="main-h__icon">
                <button class="icon-btn icon-search" id="isearch"></button>
            </li>
            @if (\App\Helpers\SessionHdl::isShoppingActive())
                <li class="nav-item main-h__icon">
                    <button class="icon-btn icon-cart" id="icart"></button>
                    <span style="display: none;" class="notification">0</span>
                </li>

            @else
                <li class="main-h__n-icon">
                    <a target="_blank" href="https://www.omnilife.com/shopping/login.php?fidioma={{ strtolower(\App\Helpers\SessionHdl::getCorbizLanguage()) }}"><button class="icon-btn icon-cart"></button></a>
                </li>
            @endif
            @if(config('settings::frontend.webservices') == 1)
                <li class="main-h__icon">
                    @if(session()->get('portal.eo.auth') == true)
                        <button class="icon-btn icon-user-logged-header" id="iuser"></button>
                    @else
                        <button class="icon-btn icon-user" id="iuser"></button>
                    @endif
                </li>
            @endif
            <li class="main-h__icon mov">
                <button class="icon-btn" id="imenu">
                    <figure class="icon-menu"><img src="{{ asset('themes/omnilife2018/images/icons/menu-red.svg') }}" alt="OMNILIFE - menu">
                    </figure>
                </button>
            </li>
        </ul>
    </div>
</header>
<!-- ends header-->
