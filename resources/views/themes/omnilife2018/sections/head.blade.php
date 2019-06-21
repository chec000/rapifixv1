<!DOCTYPE html>
<html lang="en">
       <link rel="icon" href=" {!! asset(Session::get('portal.main.brand.favicon')) !!}" rel="image/x-icon" type="image/x-icon">

<head itemscope>
    {{csrf_field()}}
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!--<title>{!! isset($title) ? $title : PageBuilder::block('meta_title', ['meta' => true]) !!}</title>-->
    <meta name="description" content="{!! PageBuilder::block('meta_description', ['meta' => true]) !!}">
    <meta name="keywords" content="{!! PageBuilder::block('meta_keywords', ['meta' => true]) !!}">
    <meta itemprop="name" content="{!! PageBuilder::block('meta_title', ['meta' => true]) !!}">
    <meta itemprop="description" content="{!! PageBuilder::block('meta_description', ['meta' => true]) !!}">
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id={!!config('cms.analytics.'.session()->get('portal.main.brand.id'));!!}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{!!config('cms.analytics.'.session()->get('portal.main.brand.id'))!!}');
</script>-->



    @if (isset($socialTags) && !empty($socialTags))
        <!-- Social tags -->
        @if (isset($socialTags['facebook']))
            <meta property="og:title"       content="{{ $socialTags['facebook']['title'] }}">
            <meta property="og:type"        content="{{ $socialTags['facebook']['type'] }}">
            <meta property="og:description" content="{{ $socialTags['facebook']['description'] }}">
            <meta property="og:url"         content="{{ $socialTags['facebook']['url'] }}">
            <meta property="og:site_name"   content="{{ $socialTags['facebook']['site_name'] }}">
            <meta property="og:image"       content="{{ $socialTags['facebook']['image'] }}">
            <meta property="og:image:secure_url" content="{{ $socialTags['facebook']['image'] }}">
            <meta property="og:image:type" content="image/png">
            <meta property="og:image:width" content="400">
            <meta property="og:image:height" content="400">
        @endif

        @if (isset($socialTags['twitter']))
            <meta name="twitter:card"        content="{{ $socialTags['twitter']['card'] }}">
            <meta name="twitter:title"       content="{{ $socialTags['twitter']['title'] }}">
            <meta name="twitter:site"        content="{{ $socialTags['twitter']['site'] }}">
            <meta name="twitter:creator"     content="{{ $socialTags['twitter']['creator'] }}">
            <meta name="twitter:url"         content="{{ $socialTags['twitter']['url'] }}">
            <meta name="twitter:domain"      content="{{ $socialTags['twitter']['domain'] }}">
            <meta name="twitter:description" content="{{ $socialTags['twitter']['description'] }}">
            <meta name="twitter:image"       content="{{ $socialTags['twitter']['image'] }}">
        @endif
    @else
        @php
            $brandName = config('cms.brand_css.'.session()->get('portal.main.brand.id'));
            $brandName = ($brandName == 'master') ? 'omnilife' : $brandName;
            $metaTitle = PageBuilder::block('meta_title', ['meta' => true]) ?:
                trans('cms::header.metadata.' . $brandName . '.title');
            $metaDescription = PageBuilder::block('meta_description', ['meta' => true]) ?:
                trans('cms::header.metadata.' . $brandName . '.description');
        @endphp
        <meta property="og:title" content="{!! $metaTitle !!}">
        <meta property="og:description" content="{!! $metaDescription !!}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{!! $metaDescription !!}">
        <meta property="og:image" content="{!! asset('themes/omnilife2018/images/logos/' . $brandName . '.png') !!}">
        <meta property="og:image:secure_url" content="{!! asset('themes/omnilife2018/images/logos/' . $brandName . '.png') !!}" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="600">
        <meta property="og:image:height" content="314">
        <meta name="twitter:title" content="{!! $metaTitle !!}">
        <meta name="twitter:description" content="{!! $metaDescription !!}">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:image" content="{!! asset('themes/omnilife2018/images/logos/' . $brandName . '.png') !!}">
        <meta name="twitter:site" content="https://twitter.com/omnilife">
        <meta name="twitter:creator" content="Omnilife">
    @endif


    <meta name="revisit-after" content="7 days">
         <link rel="icon" href=" {!! asset(Session::get('portal.main.brand.favicon')) !!}" rel="image/x-icon" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,500,600" rel="stylesheet">

    <!-- master CSS -->
    <link href="{!! asset('/themes/omnilife2018/css/master.css') !!}" rel="stylesheet">
    @if(!empty(config('cms.brand_css.'.session()->get('portal.main.brand.id'))))
        @if (config('cms.brand_css.'.session()->get('portal.main.brand.id')) != 'master')
            <link href="{!! PageBuilder::css(config('cms.brand_css.'.session()->get('portal.main.brand.id'))) !!}" rel="stylesheet">
        @endif
    @endif
    @if (session()->get('portal.main.app_locale') == 'ru' && session()->get('portal.main.countryCode') == 'RU')
        <link href="{!! asset('/themes/omnilife2018/css/russia.css') !!}" rel="stylesheet">
    @endif
    <link href="{!! asset('/themes/omnilife2018/css/responsive.css') !!}" rel="stylesheet">
    <link href="{!! asset('/cms/jquery/fancybox/jquery.fancybox.css') !!}" media="all" type="text/css" rel="stylesheet">
    <link href="{!! asset('/cms/jquery-ui/jquery-ui.css') !!}" media="all" type="text/css" rel="stylesheet">

    <link href="{!! asset('/themes/omnilife2018/css/survey.css') !!}" rel="stylesheet">
</head>

@php
    $brand = 'omnilife';
@endphp
<body class="{{ PageBuilder::block('body_theme') }}">
    <div id="blank-overlay" style="position: fixed; background: white; z-index: 9999; width: 100%; height: 100%;"></div>
    <div class="overlay"></div>
    {!! PageBuilder::section('header') !!}
    {!! PageBuilder::section('search') !!}
    {!! PageBuilder::section('login') !!}
    @if (Request::url() !== url('/shopping/checkout')))
        @include('themes.omnilife2018.sections.cart')
    @endif
    <div class="main-content">
