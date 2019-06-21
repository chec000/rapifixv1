@if ($is_first)
    <div class="front-banners">
        <div class="wrapper body-content">
@endif
            <div class="front-banner">
                <a {{ PageBuilder::block('frontbanner_link') }}>
                    <figure class="front-banner_img">
                        {!! PageBuilder::block('frontbanner_image') !!}
                    </figure>
                </a>
                @php
                    $frontbannerTitle = PageBuilder::block('frontbanner_title');
                    $frontbannerText = PageBuilder::block('frontbanner_text');
                @endphp
                @if ($frontbannerTitle != '' || $frontbannerText != '')
                    <div class="front-banner__description">
                        <h6>{{ $frontbannerTitle }}</h6>
                        <p>{{ $frontbannerText }}</p>
                    </div>
                @endif
            </div>
@if ($is_last)
        </div>
    </div>
@endif
