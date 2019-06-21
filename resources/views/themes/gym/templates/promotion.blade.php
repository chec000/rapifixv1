{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->

    
  <div class="business">
    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider home markup-->
    <!-- Content body-->
    <div class="wrapper full-size-mobile">
      <!-- Testimonials markup-->
      <div class="myomnibusiness-header omnilife">
        <div class="myomnibusiness">
          <div class="myomnibusiness__about">
            <h1 class="myomnibusiness__title omnilife">{{ PageBuilder::block('promotions_title') }}</h1>
            <p class="myomnibusiness__subtitle omnilife">
                {!! PageBuilder::block('promotions_description') !!}
            </p>
          </div>
            <figure class="testimonial__frase">
           {!! PageBuilder::block('testimonial_image_promotion') !!}
            </figure>
        </div>
      </div>
      <!-- end Testimonials markup-->
    </div>
    {!! PageBuilder::block('promotions_items') !!}
    <!-- end Content Body-->
  </div>
  <!-- bottom banner-->

          @php
    $sliderImage = PageBuilder::block('promotion_image_banner', ['view' => 'raw']);
    @endphp
    <div class="bottom-banner align-left gradient business__banner" style="background-image:url({{ $sliderImage }});">
        <div class="wrapper bottom-banner__content">
            <h2>{!! PageBuilder::block('title_banner_promotion') !!} </h2>
            <p>{!! PageBuilder::block('subtitle_banner_promotion') !!}</p>
            <a {!! PageBuilder::block('link_promotion') !!}>
                {!! BlockFormatter::smallButton(PageBuilder::block('title_banner_button_promotion')) !!}
            </a>
        </div>
    </div>
{!! PageBuilder::section('footer') !!}
