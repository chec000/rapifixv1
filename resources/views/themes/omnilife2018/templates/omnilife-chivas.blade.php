{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme'),
        'signal_title' => PageBuilder::block('signal_title'),
        'signal_title_highlight' => PageBuilder::block('signal_title_highlight')
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
        <!-- Brands markup-->
        <div class="brands">
            <div class="brands--container">
                <h2>{{ PageBuilder::block('omnilife_brands_title') }}</h2>
                {!! PageBuilder::block('omnilife_brands') !!}
            </div>
        </div>
        <!-- end Brands markup-->
        <!-- Brand location markup-->
        <div class="brand--location">
            <h2>{!! PageBuilder::block('brand_location_title') !!}</h2>
            {!! PageBuilder::block('brand_location_desciption') !!}
            {!! PageBuilder::block('brand_location_map', ['class' => 'map']) !!}
        </div>
        <!-- end Brand location markup-->
    </div>
    <!-- end Main content markup-->

{!! PageBuilder::section('footer') !!}
