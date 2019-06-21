@if ($is_first)
    <div class="cases__body">
@endif
        <div class="testimonial cases__item story-item">
            <div class="cases__about">
                <div class="testimonial__headline">
                    <div class="testimonial__avatar">
                        <figure class="avatar smallx">
                            {!! PageBuilder::block('success_stories_avatar') !!}
                        </figure>
                    </div>
                    <div class="testimonial__about">
                        <h1 class="testimonial__name">{{ PageBuilder::block('success_stories_name') }}</h1>
                        <div class="testimonial__metas">
                            <span>{{ PageBuilder::block('success_stories_age') }}</span>
                            <span>{{ PageBuilder::block('success_stories_city') }}</span>
                        </div>
                    </div>
                </div>
                <p class="testimonial__extract">
                    {!! \Illuminate\Support\Str::words(PageBuilder::block('success_stories_text'), 22, '...') !!}
                </p>
                <blockquote class="testimonial__frase">{{ PageBuilder::block('success_stories_phrase') }}</blockquote>
                <div class="cases__video">
                    @php
                        $storyMedia = PageBuilder::block('success_stories_media');
                        $videoYoutube = PageBuilder::block('success_stories_video');
                        //$videoUploaded = PageBuilder::block('success_stories_video_uploaded');
                        $videoCloudFlare = PageBuilder::block('success_stories_video_cloudflare');
                        $image = PageBuilder::block('success_stories_image');
                    @endphp
                    {{--
                    @if ($storyMedia == 'video')
                        {!! $video !!}
                    @elseif ($storyMedia == 'videouploaded')
                        <video class="video-responsive" controls width="100%">
                            {!! $videoUploaded !!}
                        </video>
                    @elseif ($storyMedia == 'image')
                        {!! $image !!}
                    @endif
                    --}}
                    @if ($storyMedia == 'video')
                        @if ($videoCloudFlare != '')
                            {!! $videoCloudFlare !!}
                        @else
                            {!! $videoYoutube !!}
                        @endif
                    @else
                        {!! $image !!}
                    @endif
                </div>
                <button class="cases__open testimonial__readmore button small">@lang('cms::get-inspired.read_more')</button>
            </div>
            <div class="cases__testimonial">
                <div class="cases__testimonial-inner">
                    <div class="cases__testimonial-body ps-container desk-only ps ps--active-y">
                        {!! PageBuilder::block('success_stories_text') !!}
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; height: 369px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 276px;"></div>
                        </div>
                    </div>
                    <button class="cases__close button small secondary">@lang('cms::get-inspired.close')</button>
                </div>
            </div>
        </div>
@if ($is_last)
    </div>
@endif
