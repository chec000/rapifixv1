@if ($is_first)
    <div class="jobs--thumbnails">
@endif
        <figure class="jobs--thumbnails__item">
            {!! PageBuilder::block('jobs_thumbnails_image') !!}
            <figcaption>
                {{ PageBuilder::block('jobs_thumbnails_message') }}
            </figcaption>
        </figure>
@if ($is_last)
    </div>
@endif
