@if ($is_first)
    <ul class="ezone__grid-list list-nostyle">
@endif
        @php
            $link = PageBuilder::block('galleries_link');
            $message = PageBuilder::block('galleries_link_message');
        @endphp
        <li class="ezone__grid-item">
            <figure class="ezone__grid-img">
                {!! PageBuilder::block('galleries_image', ['view' => 'fancybox']) !!}
            </figure>
            @if ($link != '' && $message != '')
                <a {!! $link !!}>
                    {{ $message }}
                </a>
            @endif
        </li>
@if ($is_last)
    </ul>
@endif
