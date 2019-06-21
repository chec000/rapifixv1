@if ($is_first)
@endif

@php
    $ambassador_name = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_name'),
        PageBuilder::block('ambassador_testimonial_position'));
    $ambassador_age = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_age'),
        trans('cms::ambassadors.testimonial.age'));
    $ambassador_cell_phone = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_cell_number'),
        trans('cms::ambassadors.testimonial.cell_phone'));
    $ambassador_monthly_check = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_monthly_check'),
        trans('cms::ambassadors.testimonial.monthly_check'));
    $ambassador_career_level = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_career_level'),
        trans('cms::ambassadors.testimonial.career_level'), 'span');

    $name_codistributor = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_name_codistributor'),
        PageBuilder::block('ambassador_testimonial_position_codistributor'));
    $age_codistributor = BlockFormatter::ambassadorInfo(PageBuilder::block('ambassador_testimonial_age_codistributor'),
        trans('cms::ambassadors.testimonial.age'));
    $monthly_check_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_monthly_check_codistributor'),
        trans('cms::ambassadors.testimonial.monthly_check'));
    $social_codistributor = PageBuilder::block('social_ambassador_codistributor');
    $cell_number_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_cell_number_codistributor'),
        trans('cms::ambassadors.testimonial.cell_phone'));
    $career_level_codistributor = BlockFormatter::ambassadorInfo(
        PageBuilder::block('ambassador_testimonial_career_level_codistributor'),
        trans('cms::ambassadors.testimonial.career_level'), 'span');
@endphp
        <div class="item ambassador">
            <div class="content">
                {!! PageBuilder::block('ambassador_testimonial_image') !!}
                <div class="ambassador--info">
                    <h3 class="ambassador__name">{{ PageBuilder::block('ambassador_testimonial_user_name') }}</h3>
                    <h4 class="ambassador__country">{{ PageBuilder::block('ambassador_testimonial_country') }}</h4>
                </div>
                <div class="desc">
                    <div class="ambassador--description__quote">
                        {!! PageBuilder::block('ambassador_testimonial_text') !!}
                    </div>
                    <!-- Ambassador titular data -->
                    {!! $ambassador_career_level !!}
                    {!! $ambassador_name !!}
                    {!! $ambassador_age !!}
                    {!! $ambassador_monthly_check !!}
                    <div class="ambassador--description__info">
                        {!! PageBuilder::block('social_ambassador') !!}
                    </div>
                    {!! $ambassador_cell_phone !!}

                    @if ($name_codistributor != '')
                        <hr>
                        <!-- Ambassador codistributor data -->
                        {!! $career_level_codistributor !!}
                        {!! $name_codistributor !!}
                        {!! $age_codistributor !!}
                        {!! $monthly_check_codistributor !!}
                        <div class="ambassador--description__info">
                            {!! PageBuilder::block('social_ambassador_codistributor') !!}
                        </div>
                        {!! $cell_number_codistributor !!}
                    @endif
                </div>
            </div>
        </div>

@if ($is_last)
@endif
