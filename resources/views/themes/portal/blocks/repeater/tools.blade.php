@if ($is_first)
    <div class="business__slider slider" id="business-slider">
        <ul class="business__grid list-nostyle slider__wrap">
@endif
            <li class="business__item slider__item">
                <a {!! PageBuilder::block('tools_icon_link') !!}>
                    <figure>
                        {!! PageBuilder::block('tools_icon', ['class' => 'business__item-icon']) !!}
                    </figure>
                </a>
                <h3 class="business__title business__item-title">{!! (PageBuilder::block('text_title_tool')) !!}</h3>
                <p class="business__item-description">{!! (PageBuilder::block('text_body_tool')) !!}</p>
            </li>
@if ($is_last)
        </ul>
    </div>
@endif
