@if ($is_first)
    <ul class="business__grid list-nostyle slider__wrap">
@endif
        <li class="brand__item slider__item">
            <a {!! PageBuilder::block('omnilife_brand_link') !!}>
                <figure>
                    {!! PageBuilder::block('omnilife_brand_logo') !!}
                </figure>
            </a>
            <p class="business__item-description">{!! PageBuilder::block('omnilife_brand_description') !!}</p>
        </li>
@if ($is_last)
    </ul>
@endif
