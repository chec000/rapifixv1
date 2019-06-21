{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider home markup-->
    <div class="business">
         <div class=" wrapper full-size-mobile business__main">
        <!-- History markup-->
             <div class="business__main-title col3-4">
        <div class="business__main-inner">
          <h3 class="products-maintitle"> {{ PageBuilder::block('template_title') }} <span>{{ PageBuilder::block('template_title_complement') }}</span></h3>
        </div>
      </div>
        <div class="history--container">
            <div class="history--description">
                <h2 class="history--title omnilife">
                    {{ PageBuilder::block('history_header') }}
                </h2>
                {!! PageBuilder::block('history') !!}
            </div>
        </div>
        <!-- end History markup-->
        <!-- end Video markup-->
        <div class="products-block home has-dropdown">
            <div class="products-desc myomnibusiness-menu withbg omnilife mid wrapper">
                <h1 class="myomnibusiness__title">{{ PageBuilder::block('about_us_video_title') }}</h1>
                <p class="products-desc__description">{!! PageBuilder::block('about_us_video_description') !!}</p>
            </div>
            <div class="products slider" id="home-products">
                <div class="products__wrap slider__wrap">
                    <div class="product myomnibusiness omnilife slider__item">
                        @php
                            $videoYoutube = PageBuilder::block('about_us_video_youtube', ['width' => '80%']);
                            $videoCloudFlare = PageBuilder::block('about_us_video_cloudflare');
                            //$video = PageBuilder::block('about_us_video');
                        @endphp
                        {{--
                        @if (!empty($videoYoutube))
                            {!! $videoYoutube !!}
                        @else
                            <video class="video-responsive" controls width="80%">
                                {!! $video !!}
                            </video>
                        @endif
                        --}}
                        @if ($videoCloudFlare != '')
                            {!! $videoCloudFlare !!}
                        @else
                            @if ($videoYoutube != '')
                                {!! $videoYoutube !!}
                            @endif
                        @endif
                        <p>{{ PageBuilder::block('about_us_video_label') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Video markup-->
    </div>
        @php
    $sliderImage = PageBuilder::block('template_image', ['view' => 'raw']);
    @endphp
    <div class="bottom-banner align-left gradient business__banner" style="background-image:url({{ $sliderImage }});">
        <div class="wrapper bottom-banner__content">
            <h2>{!! PageBuilder::block('title_banner_template') !!} </h2>
            <p>{!! PageBuilder::block('subtitle_banner_template') !!}</p>
            <a {!! PageBuilder::block('link_template') !!}>
                {!! BlockFormatter::smallButton(PageBuilder::block('title_banner_button_template')) !!}
            </a>
        </div>
    </div>
    </div>
    <!-- Main content markup-->

    <!-- end Main content markup-->

{!! PageBuilder::section('footer') !!}
