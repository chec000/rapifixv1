<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" sizes="57x57" href="//img1.wsimg.com/ux/favicon/apple-icon-57x57.png">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=yes">
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>

    <link href="{{asset('cms/inicio/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('cms/inicio/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('cms/inicio/css/icon-font.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('cms/inicio/css/plugins.css')}}" rel="stylesheet" type="text/css">

    <link href="{{asset('cms/inicio/css/main.css')}}" rel="stylesheet" type="text/css">



    <script>
        const URL_PROJECT = "{{url('/')}}";
    </script>

</head>

<body>
<div id="page">
    <div class="container">
        <div class="outer-row row">
            <div class="col-md-12">
                <!--===================================
                =            Header            		   =
                =====================================-->
                {!! PageBuilder::section('header',['categories'=>$categories,'cart'=>$cart]) !!}

