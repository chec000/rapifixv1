{!! PageBuilder::section('head') !!}

    <!-- Main slider home markup-->
    <div class="mainslider contact" style="padding: 0px;">
        <div class="slider__wrap">
            <div class="slider__item" style="background-image:url({{ PageBuilder::block('main_contact_image', ['view' => 'raw']) }});">
                <div class="mainslider__gradient theme--lightgray"></div>
                <div class="mainslider__wrap wrapper">
                    <div class="mainslider__content">
                    </div>
                </div>
            </div>
        </div>
        <div class="mainslider__signals signals">
        </div>
    </div>
    <!-- end Main slider home markup-->
    <!-- Content body-->
    <div class="wrapper full-size-mobile business__main">
        <div class="business__main-title col3-4">
            <div class="business__main-inner">
                <h3 class="products-maintitle">{!! PageBuilder::block('contact_title') !!}<span> {!! PageBuilder::block('contact_title_highlight') !!}</span></h3>
            </div>
        </div>

        <div class="business__slider slider" id="business-slider">
            <div class="contact--container">
                <div class="contact--description">
                    {!! PageBuilder::block('contact_info_text') !!}
                </div>
            </div>

            <div class="contact--list">
                <header class="ezone__header">
                    <div class="ezone__headline bordered">
                        <h1 class="ezone__title">{!! PageBuilder::block('contact_list_title') !!}</h1>
                    </div>
                </header>
                <div class="contact--list__creo">
                    <div class="business__slider slider" id="business-slider">
                        {!! PageBuilder::block('contact_info_tels') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Content block-->

{!! PageBuilder::section('footer') !!}
