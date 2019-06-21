@if ($is_first)
    <div class="slider__wrap">
@endif
        <div class="slider__item">
            <div class="testimonial">
                <div class="testimonial__avatar">
                    <figure class="avatar medium">{!! PageBuilder::block('testimonial_user_avatar') !!}</figure>
                </div>
                <div class="testimonial__about">
                    <h1 class="testimonial__name">{{ PageBuilder::block('testimonial_user_name') }}</h1>
                    <div class="testimonial__metas">
                        <span>{{ PageBuilder::block('testimonial_user_age') }}</span>
                        <span>{{ PageBuilder::block('testimonial_user_city') }}</span>
                    </div>
                    <p class="testimonial__extract">
                        {{ PageBuilder::block('testimonial_extract') }}
                    </p>
                    <a {{ PageBuilder::block('testimonial_button_link') }}>
                        {!! BlockFormatter::smallButton(PageBuilder::block('testimonial_button_label')) !!}
                    </a>
                </div>
                <blockquote class="testimonial__frase">{{ PageBuilder::block('testimonial_phrase') }}</blockquote>
            </div>
        </div>
@if ($is_last)
    </div>
@endif
