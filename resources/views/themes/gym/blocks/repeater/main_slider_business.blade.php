@if ($is_first)
    <div class="slider mainslider business-slider" id="main-slider">
        <div class="slider__wrap">
@endif
            @php
                $sliderType = PageBuilder::block('main_slider_type');
                $loginRequire = PageBuilder::block('main_slider_login_require');
                $userLevel = PageBuilder::block('main_slider_user_level');
                $sliderImage = PageBuilder::block('main_slider_image', ['view' => 'raw']);
                //$videoSrc = PageBuilder::block('main_slider_video');
                $videoYoutube = PageBuilder::block('main_slider_video_youtube',
                    ['view' => 'background', 'index' => $count]);
                $videoCloudFlare = PageBuilder::block('main_slider_video_cloudflare',
                    ['view' => 'background', 'index' => $count]);
                $title = PageBuilder::block('main_slider_title');
                $titleHighlight = PageBuilder::block('main_slider_title_highligth');
                $description = PageBuilder::block('main_slider_description');
                $link = PageBuilder::block('main_slider_link');
                $webServices = !config('settings::frontend.webservices');
            @endphp
            @if ($webServices || !($loginRequire && !Auth::check()))
                @if ($webServices || ($userLevel == '-' || $userLevel == '0'))
                    <a {!! $link !!}>
                        <div class="slider__item" style="background-image:url({{ $sliderImage }});">
                            <div class="mainslider__gradient {{ $gradientTheme }}"></div>
                            @if ($sliderType == 'video')
                                {{--
                                @if ($videoSrc !== '')
                                    <video class="mainslider__video show" loop muted>
                                        {!! $videoSrc !!}
                                    </video>
                                @else
                                    {!! $videoYoutube !!}
                                @endif
                                --}}
                                @if ($videoCloudFlare != '')
                                    {!! $videoCloudFlare !!}
                                @else
                                    {!! $videoYoutube !!}
                                @endif
                            @endif
                            <div class="mainslider__wrap wrapper">
                                <div class="mainslider__content">
                                    <h1 class="mainslider__title">
                                        <span class="highlight">{!! $titleHighlight !!}</span>
                                        <span>{!! $title !!}</span>
                                    </h1>
                                    <p class="mainslider__desc">{!! $description !!}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @endif
@if ($is_last)
        </div>
        <div class="mainslider__signals signals">
            <p class="signals__note">
                <span>{{ $signalTitle }}</span>
                <span>{{ $signalTitleHighlight }}</span>
            </p>
            <span class="signals__scroll">@lang('cms::main_slider.signal_scroll')</span>
        </div>
    </div>
@endif
