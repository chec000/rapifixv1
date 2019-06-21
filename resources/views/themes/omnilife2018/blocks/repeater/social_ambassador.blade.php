@if ($is_first || $count % 6 == 1)
    <span>@lang('cms::ambassadors.testimonial.social_networks'):</span>
    <div class="ambassador--description__socialmedia">
@endif
        <a {{ PageBuilder::block('ambassador_social_link') }}>
            <figure class="">
            {!! PageBuilder::block('ambassador_social_icon') !!}
            </figure>
        </a>
@if ($is_last || $count % 6 == 0)
    </div>
@endif
