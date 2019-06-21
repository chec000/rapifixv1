@if ($is_first || $count % 6 == 1)
    <ul class="main-f__list contact-icons list-nostyle">
        <li class="contact-icon title">@lang('cms::footer.contact_us'):</li>
@endif
        <li class="contact-icon">
            <a {!! PageBuilder::block('social_link') !!}>
                <figure class="">
                {!! PageBuilder::block('social_icon_image') !!}
                </figure>
            </a>
        </li>
@if ($is_last || $count % 6 == 0)
    </ul>
@endif
