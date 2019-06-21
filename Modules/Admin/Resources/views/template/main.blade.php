<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{!! $site_name." | ".$title !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Omnilife CMS {{ config('cms.site.version') }}">
    <meta name="_token" content="{{ csrf_token() }}">

    <link href='//fonts.googleapis.com/css?family=Raleway:400,100,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    {!! AssetBuilder::styles() !!}
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <link href="{!! asset('/themes/omnilife2018/css/complementos.css') !!}" rel="stylesheet">
    @yield('styles')

</head>

<body>

<nav class="navbar navbar-default navbar-fixhed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="logo" href="{{ route('admin.home') }}">
                <img style="height: 63px" src="{{ URL::to(config('admin.config.public')) }}/app/img/logo.png" alt="Omnilife CMS"/>
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" style="color:black">
                @if (isset($system_menu))
                    {!! $system_menu !!}
                @endif
            </ul>
        </div> 
    </div>
</nav>

@if (!empty($sections_menu))
    <nav class="navbar navbar-inverse subnav navbar-fixedg-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar2"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar2" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {!! $sections_menu !!}
                </ul>
            </div> 
        </div>
    </nav>
@endif

<div class="container{{ empty($sections_menu)?' loginpanel':'' }}" id="content-wrap">
    <div class="row">
        <div class="{{ empty($sections_menu)?'col-sm-6 col-sm-offset-3':'col-sm-12' }}">
            <div id="cmsNotifications">
                <div class="alert" id="cmsDefaultNotification" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            {!! $content !!}
            <br /><br />
        </div>
    </div>
</div>

{!! $modals !!}


<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 style="color: white!important;"><i  style="color: white!important;" class="glyphicon glyphicon-thumbs-up"></i> Mensaje</h1>
            </div>
            <div class="modal-body">
                <div id="mensaje_final"></div>

                <h1 id="pago_realizado"><span id="mensaje">Su pago fue de: $</span> <span id="cantidad_pagar"></span></h1>
                <h1 id="restante"><span >Restante: $</span> <span id="cantidad_restante"></span></h1>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="reload()">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="loader" style=" opacity: 0.5;background-color: #f1eaea;">
    <div class="loader__content">
        <div class="loader__inner">
            <img src="{{asset('themes/omnilife2018/images/cargando-loading-041.gif')}}">            
        </div>
    </div>
</div>
<style>

    .modal-header-success {
        padding: 9px 15px;
        border-bottom: 1px solid #eee;
        background-color: #5cb85c;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-topright: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .loader {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        width: 100vw;
        height: 100vh;
        visibility: hidden;
        -webkit-transition: visibility 0s 0.5s;
        -moz-transition: visibility 0s 0.5s;
        -o-transition: visibility 0s 0.5s;
        -ms-transition: visibility 0s 0.5s;
        transition: visibility 0s 0.5s;
    }

    .loader.show {
        -webkit-transition: none;
        -moz-transition: none;
        -o-transition: none;
        -ms-transition: none;
        transition: none;
        opacity: 0.5;
        visibility: visible;
    }
    .loader.show .loader__content {
        -webkit-transition: -webkit-transform 0.17s ease-in-out, border-radius 0.17s ease-in-out 0.17s;
        -moz-transition: -moz-transform 0.17s ease-in-out, border-radius 0.17s ease-in-out 0.17s;
        -o-transition: -o-transform 0.17s ease-in-out, border-radius 0.17s ease-in-out 0.17s;
        -ms-transition: -ms-transform 0.17s ease-in-out, border-radius 0.17s ease-in-out 0.17s;
        transition: transform 0.17s ease-in-out, border-radius 0.17s ease-in-out 0.17s;
        border-radius: 0;
        -webkit-transform: scale3d(1, 1, 1);
        -moz-transform: scale3d(1, 1, 1);
        -o-transform: scale3d(1, 1, 1);
        -ms-transform: scale3d(1, 1, 1);
        transform: scale3d(1, 1, 1);
    }
    .loader__content {
        position: absolute;
        top: 0;
        left: 0;
        display: -webkit-box;
        display: -moz-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: box;
        display: flex;
        -webkit-box-pack: center;
        -moz-box-pack: center;
        -o-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -moz-box-align: center;
        -o-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
        width: 100%;
        height: 100%;
        background-color: #fff;
        background-color: rgba(255,255,255,.9);
        border-radius: 50%;
        -webkit-transform: scale3d(0, 0, 0);
        -moz-transform: scale3d(0, 0, 0);
        -o-transform: scale3d(0, 0, 0);
        -ms-transform: scale3d(0, 0, 0);
        transform: scale3d(0, 0, 0);
        -webkit-transition: -webkit-transform 0.17s ease-in-out 0.17s ease-in-out;
        -moz-transition: -moz-transform 0.17s ease-in-out 0.17 ease-in-out;
        -o-transition: -o-transform 0.17s ease-in-out 0.17s 0.17s ease-in-out;
        -ms-transition: -ms-transform 0.17s ease-in-out 0.17s 0.17s ease-in-out;
        transition: transform 0.17s ease-in-out 0.17s, opacity .9 ease-in-out;
    }
    .loader__circular {
        width: 100px;
        height: 100px;
        -webkit-animation: rotate 2s linear infinite;
        -moz-animation: rotate 2s linear infinite;
        -o-animation: rotate 2s linear infinite;
        -ms-animation: rotate 2s linear infinite;
        animation: rotate 2s linear infinite;
        -webkit-transform-origin: center center;
        -moz-transform-origin: center center;
        -o-transform-origin: center center;
        -ms-transform-origin: center center;
        transform-origin: center center;
    }
    .loader__base {
        fill: none;
        stroke: #673167;
        stroke-width: 7;
    }
    .loader__path {
        fill: none;
        stroke: #fba343;
        stroke-width: 2;
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
        stroke-linecap: round;
        stroke-miterlimit: 10;
        -webkit-animation: dash 1.5s ease-in-out infinite;
        -moz-animation: dash 1.5s ease-in-out infinite;
        -o-animation: dash 1.5s ease-in-out infinite;
        -ms-animation: dash 1.5s ease-in-out infinite;
        animation: dash 1.5s ease-in-out infinite;
    }

</style>
<script src="{{ URL::to(config('admin.config.public')).'/app/js/router.js' }}"></script>
<script type="text/javascript">
    var dateFormat = '{{ config('cms.date.format.jq_date') }}';
    var timeFormat = '{{ config('cms.date.format.jq_time') }}';
    var ytBrowserKey = '{{ config('settings::key.yt_browser') ?: config('cms.key.yt_browser') }}';
    var adminPublicUrl = '{{ URL::to(config('admin.config.public')).'/' }}';
    router.addRoutes({!! $coaster_routes !!});
    router.setBase('{{ URL::to('/') }}');
</script>

{!! AssetBuilder::scripts() !!}
<script type="text/javascript">
    var _URL_PROJECT = '{{ route('admin.home') }}';
    $.ajaxSetup({
        statusCode: {
            419: function () {
                window.location.href = _URL_PROJECT;
            },
        }
    });
</script>
@yield('scripts')
@if (!empty($alerts))
    <script type="text/javascript">
        $(document).ready(function () {
            @foreach($alerts as $alert)
                cms_alert('{!! $alert->class !!}', '{!! $alert->content !!}');
            @endforeach
        });
        
                         function reload() {
                        location.reload();
                    }

    </script>
@endif

</body>

</html>
