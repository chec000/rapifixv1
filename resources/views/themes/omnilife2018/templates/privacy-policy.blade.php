{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}

<div class="wrapper full-size-mobile">
      <div class="history--container">
        <div class="history--description">
          <h2 class="history--title omnilife">
          {!! PageBuilder::block('title') !!}
          </h2>
          <p class="contact--subtitle">
          {!! PageBuilder::block('content') !!}
          </p>
          <br>
        </div>
      </div>
    </div>
    

    <!-- end Main slider home markup-->
{!! PageBuilder::section('footer') !!}
