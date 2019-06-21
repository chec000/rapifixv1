{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider home markup-->

    <!-- Main content markup-->
    <div class="wrapper full-size-mobile">
        <!-- History markup-->
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
    <!-- end Main content markup-->

{!! PageBuilder::section('footer') !!}
