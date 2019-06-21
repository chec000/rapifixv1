<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="{{ asset(Session::has('portal.main.brand.favicon') ? Session::get('portal.main.brand.favicon') : '/favicon.ico') }}" type="image/x-icon">
    @if(Request::is('support/*'))
      <title>@lang('404.header') | @lang('404.omnilife_admin')</title>
    @else
      <title>@lang('404.header') | @lang('404.'.config('cms.brand_css.'.session()->get('portal.main.brand.id')))</title>
    @endif

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed" rel="stylesheet">

    <style>
      html, body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
      }
      .navbar-default {
      	padding-top: 15px !important;
      	padding-bottom: 0 !important;
      	background: -webkit-gradient(linear, left top, right top, from(#7f47a5), to(#fffafa));
      	background: -webkit-linear-gradient(left, #7f47a5, #fffafa);
      	background: -moz-linear-gradient(left, #7f47a5, #fffafa);
      	background: -o-linear-gradient(left, #7f47a5, #fffafa);
      	background: linear-gradient(to left, #7f47a5, #fffafa) !important;
      	margin-bottom: 0;
      	border-bottom: 1px solid rgba(0,0,0,0.1) !important;
      	border-radius: 0;
        color: white;

      }
      .wrapper {
        margin: 0 auto;
        max-width: 1400px;
        position: relative;
        width: 92%;
      }
      .main-h {
        padding: 15px 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 100;
      }
      /* Para clase main-h por brand_id */
      .main-h_1 {
         background-color: #120918;
      }
      .main-h_2 {
        border-bottom: 1px solid #120918;
      }
      .main-h_3 {
        border-bottom: 1px solid #120918;
      }

      .main-h .wrapper {
        align-items: center;
        display: flex;
        justify-content: flex-start;
      }
      .main-h__logo {
        margin-right: auto;
        height: 25px;
        width: 93px;
      }
      .main-h__logo .icon {
        height: inherit;
        width: inherit;
      }
      .main-content {
        align-items: center;
        display: flex;
        flex-direction: column;
        height: calc(100vh - 55px);
        justify-content: center;
        text-align: center;
      }
      h1, h2 {
        font-family: 'Open Sans', sans-serif;
        text-transform: uppercase;
      }
      h1 {
        color: #fba343;
        font-size: 5em;
        line-height: 1;
        margin: 0;
      }
      .h1_1{
        color: #fba343 !important;
      }
      .h1_2{
        color: #ff5b66 !important;
      }
      .h1_3{
        color: #fba343 !important;
      }


      h2 {
        color: #673167;
        font-size: 2em;
        margin: 20px 0 30px;
      }
      p {
        color: #666666;
        font-size: 0.75em;
        line-height: 1.5;
        margin: 0;
      }
      .button {
        display: block;
        width: 201px;
        padding: 0.5rem 2rem;
        margin: 50px auto 0;
        font-size: 1rem;
        font-family: 'Barlow Semi Condensed', sans-serif;
        text-align: center;
        text-transform: uppercase;
        text-decoration: none;
        background-color: #fba343;
        border: none;
        border-radius: 20px;
        color: white;
        transition: all 0.17s ease-in-out;
      }
      .button:hover {
        background-color: lighten($orange, 10%);
      }
      .button_background_1{ background-color: #fba343 !important;}
      .button_background_2{ background-color: #ff5b66 !important;;}
      .button_background_3{ background-color: #8bcf57 !important;;}

      @media screen and (min-width: 768px) {
        h1 {
          font-size: 15.625em;
        }
        h2 {
          font-size: 3em;
        }
        p {
          font-size: 1rem;
        }
      }
      @media screen and (min-width: 1024px) {
        .main-h__logo {
          height: 38px;
          width: 145px;
        }

        .main-h__logo img {
          height: 38px;
        }
      }
    </style>
  </head>
  <body>
    <!-- starts header-->
    @if(Request::is('support/*'))
      <header>
        <div>
    <nav class="navbar navbar-default navbar-fixhed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="logo" href="{{ url('/admin') }}">
            <img src="{{ asset('cms/app/img/logo.png') }}" alt="{{ config('settings::site.name') }}"/>
          </a>
        </div>
      </div>
    </nav>
        </div>
      </header>
    @else
      <header class="main-h {{Session::has('portal.main.brand.id') ? 'main-h_'.Session::get('portal.main.brand.id') : ''}}">
        <div class="wrapper">
          <div class="logo main-h__logo">
            <a class="logo" href="/" >
              <img src="{{ url(session()->get('portal.main.brand.logo')) }}" title="Omnilife" alt="Omnilife">
            </a>
          </div>
        </div>
      </header>
    @endif
    <!-- ends header-->
    <div class="main-content wrapper">
      <h1 class="{{Session::has('portal.main.brand.id') ? 'h1_'.Session::get('portal.main.brand.id') : ''}}">404</h1>
      <h2>@lang('404.header')</h2>
      <p>@lang('404.subheader')</p>
      <p>@lang('404.advice')</p>
      @if(Request::is('support/*'))
      <a class="button" href="{{ url('/support') }}">@lang('404.back_button')</a>
      @else
      <a class="button {{Session::has('portal.main.brand.id') ? 'button_background_'.Session::get('portal.main.brand.id') : ''}}" href="{{ url('/') }}">@lang('404.back_button')</a>
      @endif

    </div>
  </body>
</html>
