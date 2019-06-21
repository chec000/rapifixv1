{!! PageBuilder::section('head') !!}
<div class="business">
    {!! PageBuilder::block('main_slider', ['view' => PageBuilder::block('main_slider_view'),
    'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
   
    <div class="wrapper full-size-mobile business__main">
        <div class="business__main-title col3-4">
            <div class="business__main-inner">
                <h3 class="products-maintitle">
                    {!! PageBuilder::block('general_title_cresiendo') !!}        <span>
                        {!! PageBuilder::block('general_title_cresiendo_light') !!}  </span></h3>
            </div>
        </div> 
        <div class="cresiendo--container">
            <div class="cresiendo--description">
                <p class="cresiendo--subtitle">
                    {!! PageBuilder::block('content') !!}       
                </p>
                <div class="cresiendo--thumbnails">
                    {!! PageBuilder::block('cresiendo_item') !!}       
                </div>
            </div>
        </div>

        <div class="cases__body">
            <div class="business__main-title cases__headline cresiendo">
            <header>
            <h1 class="testimonials__title">
                  {!! PageBuilder::block('exit_testimony_first') !!} <span> {!! PageBuilder::block('exit_testimony_complement') !!}</span></h1>
            </header>
          </div>
           {!!  PageBuilder::block('creciendo_item_stories') !!}
          </div>
    </div>
    @php
    $sliderImage = PageBuilder::block('creciendo_image', ['view' => 'raw']);
    @endphp
    <div class="bottom-banner" style="background-image:url({{ $sliderImage }});">
        <div class="wrapper bottom-banner__content">
            <h2>    {!! PageBuilder::block('title_banner_cresiendo') !!}
            </h2>
            <p> {!! PageBuilder::block('subtitle_banner_cresiendo') !!}</p>
            <a {!! PageBuilder::block('link_creciendo') !!}>
                {!! BlockFormatter::smallButton(PageBuilder::block('title_banner_button_cresiendo')) !!}
            </a>
        </div>
    </div>
</div>
<!-- Main slider home markup-->
<!--crecsendo-->
<!-- end Main slider home markup-->
{!! PageBuilder::section('footer') !!}
