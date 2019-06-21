
@if ($is_first)
 
        <ul class="tools--grid__list list-nostyle slider__wrap">
@endif

            <li class="tools--grid__item slider__item">
      
                <figure>
                    {!! PageBuilder::block('business_icon', ['class' => 'business__item-icon']) !!}
                </figure>
            </a>
            <h3 class="business__title business__item-title">{!! (PageBuilder::block('text_title_tool')) !!}</h3>
            <p class="business__item-description">{!! (PageBuilder::block('text_body_tool')) !!}</p>
        </li>

@if ($is_last)
        </ul>
    </div>
@endif
