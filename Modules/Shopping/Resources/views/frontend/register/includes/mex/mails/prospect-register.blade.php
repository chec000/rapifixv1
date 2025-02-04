@php
    $footerLogo = asset('/uploads/images/mailing/logos/' . \App\Helpers\SessionHdl::getLocale() . '/omnilife_footer.png');
    $headerLogo = asset('/uploads/images/mailing/logos/' . \App\Helpers\SessionHdl::getLocale() . '/omnilife_header.png');
    $urlCREO    = \App\Helpers\CoasterFunctions::generatePageUrl(config('settings::inspire.creo.page_code'), config('settings::inspire.creo.page_template'));

	$finalUrlCREO = "<a href='{$urlCREO}' target='_blank'>CREO</a>";
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- If you delete this tag, the sky will fall on your head -->
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>@lang('shopping::register.mail.prospect.title')</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="stylesheets/email.css" />
    </head>

    <style>
        /* -------------------------------------
          GLOBAL
        ------------------------------------- */
        * {
            margin:0;
            padding:0;
        }
        * { font-family: "Roboto", "Helvetica", Helvetica, Arial, sans-serif; }

        img {
            max-width: 100%;
        }
        .collapse {
            margin:0;
            padding:0;
        }
        body {
            -webkit-font-smoothing:antialiased;
            -webkit-text-size-adjust:none;
            width: 100%!important;
            height: 100%;
        }


        /* -------------------------------------
                ELEMENTS
        ------------------------------------- */
        a { color: #2BA6CB;}

        .btn {
            text-decoration:none;
            color: #FFF;
            background-color: #666;
            padding:10px 16px;
            font-weight:bold;
            margin-right:10px;
            text-align:center;
            cursor:pointer;
            display: inline-block;
        }

        p.callout {
            padding:15px;
            background-color:#ECF8FF;
            margin-bottom: 15px;
        }
        .callout a {
            font-weight:bold;
            color: #2BA6CB;
        }

        table.social {
            /* 	padding:15px; */
            background-color: #ebebeb;

        }
        .social .soc-btn {
            padding: 3px 7px;
            font-size:12px;
            margin-bottom:10px;
            text-decoration:none;
            color: #FFF;font-weight:bold;
            display:block;
            text-align:center;
        }
        a.fb { background-color: #3B5998!important; }
        a.tw { background-color: #1daced!important; }
        a.gp { background-color: #DB4A39!important; }
        a.ms { background-color: #000!important; }

        .sidebar .soc-btn {
            display:block;
            width:100%;
        }

        /* -------------------------------------
                HEADER
        ------------------------------------- */
        table.head-wrap { width: 100%;}

        .header.container table td.logo { padding: 15px; }
        .header.container table td.label { padding: 15px; padding-left:0px;}


        /* -------------------------------------
                BODY
        ------------------------------------- */
        table.body-wrap { width: 100%;}


        /* -------------------------------------
                FOOTER
        ------------------------------------- */
        table.footer-wrap { width: 100%;	clear:both!important;
        }
        .footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
        .footer-wrap .container td.content p {
            font-size:10px;
            font-weight: bold;

        }


        /* -------------------------------------
                TYPOGRAPHY
        ------------------------------------- */
        h1,h2,h3,h4,h5,h6 {
            font-family: "Roboto", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
        }
        h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

        h1 { font-weight:200; font-size: 44px;}
        h2 { font-weight:200; font-size: 37px;}
        h3 { font-weight:500; font-size: 27px;}
        h4 { font-weight:500; font-size: 23px;}
        h5 { font-weight:900; font-size: 17px;}
        h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

        .collapse { margin:0!important;}

        p, ul {
            margin-bottom: 10px;
            font-weight: normal;
            font-size:14px;
            line-height:1.6;
        }
        p.lead { font-size:17px; }
        p.last { margin-bottom:0px;}

        ul li {
            margin-left:5px;
            list-style-position: inside;
        }

        /* -------------------------------------
                SIDEBAR
        ------------------------------------- */
        ul.sidebar {
            background:#ebebeb;
            display:block;
            list-style-type: none;
        }
        ul.sidebar li { display: block; margin:0;}
        ul.sidebar li a {
            text-decoration:none;
            color: #666;
            padding:10px 16px;
            /* 	font-weight:bold; */
            margin-right:10px;
            /* 	text-align:center; */
            cursor:pointer;
            border-bottom: 1px solid #777777;
            border-top: 1px solid #FFFFFF;
            display:block;
            margin:0;
        }
        ul.sidebar li a.last { border-bottom-width:0px;}
        ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



        /* ---------------------------------------------------
                RESPONSIVENESS
                Nuke it from orbit. It's the only way to be sure.
        ------------------------------------------------------ */

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            display:block!important;
            max-width:600px!important;
            margin:0 auto!important; /* makes it centered */
            clear:both!important;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            padding:15px;
            max-width:600px;
            margin:0 auto;
            display:block;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table { width: 100%; }


        /* Odds and ends */
        .column {
            width: 300px;
            float:left;
        }
        .column tr td { padding: 15px; }
        .column-wrap {
            padding:0!important;
            margin:0 auto;
            max-width:600px!important;
        }
        .column table { width:100%;}
        .social .column {
            width: 280px;
            min-width: 279px;
            float:left;
        }

        /* Be sure to place a .clear element after each set of columns, just to be safe */
        .clear { display: block; clear: both; }


        /* -------------------------------------------
                PHONE
                For clients that support media queries.
                Nothing fancy.
        -------------------------------------------- */
        @media  only screen and (max-width: 600px) {

            a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

            div[class="column"] { width: auto!important; float:none!important;}

            table.social div[class="column"] {
                width:auto!important;
            }

        }
    </style>

    <body bgcolor="#e2e1e0">
        <!-- HEADER -->
        <table class="head-wrap" bgcolor="#690d81">
            <tr>
                <td></td>
                <td class="header container">
                    <div class="content">
                        <table >
                            <tr>
                                <td><img style="width: 170px;" src="{{asset($headerLogo)}}" /></td>
                                <td align="right"><h6 class="collapse" style="color:#FFFFFF">@lang('shopping::register.mail.prospect.h6')</h6></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
        <!-- /HEADER -->

        <!-- BODY -->
        <table class="body-wrap">
            <tr>
                <td></td>
                <td class="container" bgcolor="#FFFFFF">
                    <div class="content" style="box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">
                        <table bgcolor="#fff" >
                            <tr>
                                <td>
                                    <!-- A Real Hero (and a real human being) -->
                                    <img src="{{asset('/uploads/images/mailing/assets/Ppal_prospect_register.jpg')}}" alt="Nuevo prospecto"/><!-- /hero -->
                                    <!-- Callout Panel -->

                                    <div style="padding:15px; color:#666; margin-top:40px; ">
                                        <h3 style="color:#892CAC; font-weight:800; font-size:21px;">@lang('shopping::register.mail.prospect.h3')</h3>

                                        <p>@lang('shopping::register.mail.prospect.p1', ['name' => $data['name']])</p>

                                        <p>@lang('shopping::register.mail.prospect.p2.text1') <strong>{{$data['name_prospect']}}</strong> @lang('shopping::register.mail.prospect.p2.text2')</p>

                                        <p>@lang('shopping::register.mail.prospect.p3'): </p>

                                        <ul>
                                            <li><strong>@lang('shopping::register.mail.prospect.li.1'):</strong> {{$data['name_prospect']}}</li>
                                            <li><strong>@lang('shopping::register.mail.prospect.li.2'):</strong> {{$data['tel_prospect']}}</li>
                                            <li><strong>@lang('shopping::register.mail.prospect.li.3'):</strong> {{$data['email_prospect']}}</li>
                                        </ul>

                                        <br>

                                        <p>@lang('shopping::register.mail.prospect.p4')</p>


                                        <p><small>@lang('shopping::register.mail.prospect.p5.text1') <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> {!! str_replace('{CREO}', $finalUrlCREO, trans('shopping::register.mail.prospect.p5.text2')) !!}</small></p>

                                        <!-- social & contact -->
                                        <div style="width:100%; background-color:#FFFFFF;" align="center">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 55%;">
                                                            <p style="padding-top: 30px; padding-left: 30px; padding-bottom: 0px;">
                                                                <a href="{{\Illuminate\Support\Facades\URL::to('/')}}" target="_blank">
                                                                    <img width="120" src="{{$footerLogo}}" alt="">
                                                                </a>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p style="padding-top: 30px; padding-bottom: 0px;">
                                                                <a href="{{\Illuminate\Support\Facades\URL::to('/')}}/contacto" target="_blank" style="padding: 8px;"><img src="{{asset('/uploads/images/mailing/assets/phone.png')}}" width="27" height="27"/></a>
                                                                <a href="https://www.facebook.com/OmnilifeOficialMexico" target="_blank" style="padding: 8px;"><img src="{{asset('/uploads/images/mailing/assets/facebook.png')}}" width="27" height="27"/></a>
                                                                <a href="https://twitter.com/Omnilife" target="_blank" style="padding: 8px;"><img src="{{asset('/uploads/images/mailing/assets/twitter.png')}}" width="27"  height="27" /></a>
                                                                <a href="https://www.instagram.com/omnilifeoficial/" target="_blank" style="padding: 8px;"><img src="{{asset('/uploads/images/mailing/assets/instagram-02.png')}}" width="27" height="27" /></a>
                                                                <a href="https://www.youtube.com/omnilifeoficial" target="_blank" style="padding: 8px;"><img src="{{asset('/uploads/images/mailing/assets/youtube-02.png')}}" width="27" height="27" /></a>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
        <!-- /BODY -->

        <!-- FOOTER -->
        <table class="footer-wrap">
            <tr>
                <td></td>
                <td class="container">
                    <!-- content -->
                    <div class="content">
                        <table>
                            <tr>
                                <td align="center">
                                    <p>
                                        <a href="{{\Illuminate\Support\Facades\URL::to('/')}}/politicas-de-privacidad" target="_blank">@lang('shopping::register.mail.prospect.a1')</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /content -->
                </td>
                <td></td>
            </tr>
        </table>
        <!-- /FOOTER -->
    </body>
</html>