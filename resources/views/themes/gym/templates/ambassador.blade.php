{!! PageBuilder::section('head') !!}

    <!-- Main slider ambassador markup-->
    {!! PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]) !!}
    <!-- end Main slider ambassador markup-->

    <!-- Content body-->
    <div class="wrapper full-size-mobile">

        <!-- Testimonials markup-->
        @php
            $ambassadorTitleVideo = PageBuilder::block('ambassador_title_video');
            $ambassadorDescriptionVideo = PageBuilder::block('ambassador_description_video');
            $ambassadorTestimonialsVideo = PageBuilder::block('ambassador_testimonials_video');
            $videoBlocks = BlockFormatter::validateBlocks([
                $ambassadorTitleVideo,
                $ambassadorDescriptionVideo,
                $ambassadorTestimonialsVideo
            ]);
        @endphp
        @if ($videoBlocks)
            <div class="testimonials slider ambassador theme--cyan">
                <header class="testimonials__head">
                    <h1 class="testimonials__title ambassador">
                        {!! $ambassadorTitleVideo !!}</h1>
                    <h3 class="testimonials__subtitle ambassador">{!! $ambassadorDescriptionVideo !!} </h3>
                </header>
                <figure class="ambassador--video">
                    {!! $ambassadorTestimonialsVideo !!}
                </figure>
            </div>
        @endif
        <!-- end Testimonials markup-->

        @php
            $ambassadorTittleTestimonials = PageBuilder::block('ambassador_title_testimonials');
            $ambassadorDescriptionTestimonials = PageBuilder::block('ambassador_description_testimonials');
            $ambassadorTestimonials = PageBuilder::block('ambassador_testimonials');
            $ambassadorTestimonialsLeft = BlockFormatter::validateBlocks([
                $ambassadorTittleTestimonials,
                $ambassadorDescriptionTestimonials
            ]);
        @endphp
        <!-- product block-->
        <div class="products-block">
            @if ($ambassadorTestimonialsLeft)
                <div class="products-desc withbg mid wrapper theme--gray over-main-slider">
                    <h1 class="products-desc__title">{!! $ambassadorTittleTestimonials !!}</h1>
                    <div class="ambassador--description">
                        {!! $ambassadorDescriptionTestimonials !!}
                    </div>
                </div>
            @endif
            @if ($ambassadorTestimonials)
                <div class="products slider over-main-slider">
                    <div class="grid">
                        {!! $ambassadorTestimonials !!}
                    </div>
                </div>
            @endif
        </div>
        <!-- end product block-->

        <!-- faq block-->
        <div class="ambassador--faq">
            @php
                $ambassadorFaqImage = PageBuilder::block('ambassador_faq_image', ['class' =>'ambassador--world']);
                $ambassadorFaqObjectives = PageBuilder::block('ambassador_faq_objectives');
                $ambassadorFaqs = BlockFormatter::validateBlocks([
                    $ambassadorFaqImage,
                    $ambassadorFaqObjectives
                ]);
            @endphp
            @if ($ambassadorFaqs)
                <div class="ambassador--faq__objectives theme--green over-main-slider">
                    {!! PageBuilder::block('ambassador_faq_image', ['class' =>'ambassador--world']) !!}
                    {!! PageBuilder::block('ambassador_faq_objectives') !!}
                </div>
            @endif
            <div class="ambassador--faq__benefits">
                @if (PageBuilder::block('ambassador_faq_benefits'))
                    <div class="ambassador--benefits__container theme--gray">
                        <div class="ambassador--faq__content">
                            {!! PageBuilder::block('ambassador_faq_benefits') !!}
                        </div>
                    </div>
                @endif
                @php
                    $ambassadorConvocatoryTitle = PageBuilder::block('ambassador_convocatory_title');
                    $ambassadorConvocatoryText = PageBuilder::block('ambassador_convocatory_text');
                    $ambassadorConvocatoryLink = PageBuilder::block('ambassador_convocatory_link');
                    $ambassadorConvocatoryLinkLabel = PageBuilder::block('ambassador_convocatory_link_label');
                    $ambassadorConvocatory = BlockFormatter::validateBlocks([
                        $ambassadorConvocatoryTitle,
                        $ambassadorConvocatoryText,
                        $ambassadorConvocatoryLink,
                        $ambassadorConvocatoryLinkLabel
                    ]);
                @endphp
                @if ($ambassadorConvocatory)
                    <div class="ambassador--benefits__convocatory theme--blue">
                        <h2>{{ $ambassadorConvocatoryTitle }}</h2>
                        <p>{!! $ambassadorConvocatoryText !!}</p>
                        @if ($ambassadorConvocatoryLinkLabel != '')
                            <a {!! $ambassadorConvocatoryLink !!}>
                                {{ $ambassadorConvocatoryLinkLabel }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <!-- end faq block-->

    </div>
    <!-- end Content block-->

{!! PageBuilder::section('footer') !!}
<script src="{{ PageBuilder::js('ambassadors') }}"></script>
