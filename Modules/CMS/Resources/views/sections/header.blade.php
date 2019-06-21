<!-- starts header-->
<header class="main-h">
  <div class="wrapper">
    <div class="logo main-h__logo">
      <a href="#">
        <figure class="icon-omnilife">
          <img src="{{ asset('themes/omnilife2018/images/icons/'.$brand.'.svg') }}" alt="OMNILIFE">
        </figure>
      </a>
    </div>
    <nav class="main-nav">
      <div class="main-nav__head mov">
        @if (Auth::check())
          <figure class="avatar small">
            <img src="{{ asset('themes/omnilife2018/images/user-image.png') }}" alt="user-image">
          </figure>
          <div class="main-nav__user">
            <div class="main-nav__name">
              {{ Auth::user()->name }}
            </div>
            <div class="main-nav__level">
              <span>Nivel bronce</span>
              <span class="sep">|</span>
              <span class="points">3,000 pts</span>
            </div>
          </div>
        @else
          <button class="icon-btn">
            <figure class="icon-user">
              <img src="{{ asset('themes/omnilife2018/images/icons/user.svg') }}" alt="OMNILIFE - user">
            </figure>
          </button>
          <a class="main-nav__link" id="login-btn-mov" href="#">@lang('cms::header.log_in')</a>
          <a class="main-nav__link bold" href="#">@lang('cms::header.sign_in')</a>
        @endif
        <button class="icon-btn icon-cross close"></button>
      </div>
      <div class="main-nav__body">
        <ul class="nav-list top list-nostyle">
          <li class="nav-item"><a href="../omnilife/index.html">Omnilife</a></li>
          <li class="nav-item"><a href="../nfuerza/index.html">Nfuerza</a></li>
          <li class="nav-item"><a href="productos.html">Productos</a></li>
          <li class="nav-item"><a href="historias-exito.html">Historias de Éxito</a></li>
          <li class="nav-item"><a href="haz-negocio.html">Haz Negocio</a></li>
        </ul>
        <ul class="nav-list list-nostyle">
          <li class="nav-item dropdown"><span class="dropdown-toggle">@lang('cms::header.country')</span>
            <ul class="dropdown-list list-nostyle">
              <li class="dropdown-item">
                <a href="#">
                  <figure class="flag"><img src="{{ asset('themes/omnilife2018/images/flags/mx.svg') }}" alt=""></figure>México
                </a>
              </li>
              <li class="dropdown-item"><a href="#">
                  <figure class="flag"><img src="{{ asset('themes/omnilife2018/images/flags/us.svg') }}" alt=""></figure>Estados Unidos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown"> <span class="dropdown-toggle">@lang('cms::header.language')</span>
            <ul class="dropdown-list list-nostyle">
              <li class="dropdown-item"><a href="#">Español</a></li>
              <li class="dropdown-item"><a href="#">Inglés</a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="#">@lang('cms::header.businessmen_zone')</a></li>
          <li class="nav-item desk bold"><a href="#">@lang('cms::header.sign_in')</a></li>
          <li class="nav-item desk bold "><a href="#" id="login-btn">@lang('cms::header.log_in')</a></li>
        </ul>
      </div>
    </nav>
    <ul class="main-h__icons list-nostyle">
      <li class="main-h__icon">
        <button class="icon-btn" id="isearch">
          <figure class="icon-search"><img src="{{ asset('themes/omnilife2018/images/icons/search-gray.svg') }}" alt="OMNILIFE - search"></figure>
        </button>
      </li>
      <li class="main-h__icon">
        <button class="icon-btn" id="icart">
          <figure class="icon-cart"><img src="{{ asset('themes/omnilife2018/images/icons/cart-gray.svg') }}" alt="OMNILIFE - cart"></figure>
        </button>
      </li>
      <li class="main-h__icon">
        @if (Auth::check())
          <button class="icon-btn" id="iuser">
            <figure class="icon-user" style="border-radius: 50%;overflow: hidden;">
              <img src="{{ asset('themes/omnilife2018/images/user-image.png') }}" alt="user-image">
            </figure>
          </button>
        @else
          <button class="icon-btn" id="iuser">
            <figure class="icon-user"><img src="{{ asset('themes/omnilife2018/images/icons/user-gray.svg') }}" alt="OMNILIFE - user"></figure>
          </button>
        @endif
      </li>
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
