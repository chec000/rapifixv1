<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="{{ asset(Session::has('portal.main.brand.favicon') ? Session::get('portal.main.brand.favicon') : '/favicon.ico') }}" type="image/x-icon">
    @if(Request::is('support/*'))
      <title>@lang('403.header') | @lang('403.omnilife_admin')</title>
    @else
      <title>@lang('403.header') | @lang('403.'.config('cms.brand_css.'.session()->get('portal.main.brand.id')))</title>
    @endif
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('cms/bootstrap/css/bootstrap.min.css') }}">
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
        background-color: #120918;
        padding: 15px 0;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 100;
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
        height: 70vh;
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
      h2 {
        color: #673167;
        font-size: 2em;
        margin: 20px 0 30px;
      }
      p {
        color: #666666;
        font-size: 2rem;
        line-height: 1.5 !important;
        margin: 0;
      }
      .button {
        display: block;
        width: 201px;
        padding: 0.5rem 2rem;
        margin: 10px auto 0;
        font-size: 2rem;
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
      @media screen and (min-width: 768px) {
        h1 {
          font-size: 15.625em;
        }
        h2 {
          font-size: 3em;
        }
      }
      @media screen and (min-width: 1024px) {
        .main-h__logo {
          height: 38px;
          width: 145px;
        }
      }
    </style>
  </head>
  <body>
    <!-- starts header-->
    <nav class="navbar navbar-default navbar-fixhed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="logo" href="{{ url('/support') }}">
              <img style="height: 57px;" src="{{ asset('cms/app/img/logo.png') }}" alt="{{ config('settings::site.name') }}"/>
          </a>
        </div>
      </div>
    </nav>
    <!-- ends header-->
    <div class="main-content wrapper">
      <h1>403</h1>
      <h2>@lang('403.header')</h2>
      <p>@lang('403.subheader')</p>
      <p>@lang('403.advice')</p>
      @if(Request::is('support/*'))
        <a class="button" href="{{ url('/support') }}">@lang('403.back_button')</a>
      @else
        <a class="button" href="{{ url('/') }}">@lang('403.back_button')</a>
      @endif
    </div>
  </body>
</html>
