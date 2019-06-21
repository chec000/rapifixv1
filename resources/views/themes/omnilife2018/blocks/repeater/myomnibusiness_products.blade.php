@if ($is_first)
@endif
    <figure class="product--device">
        <figcaption>
            <span class="device--image">{{ PageBuilder::block('myomnibusiness_products_message') }}</span>
        </figcaption>
        {!! PageBuilder::block('myomnibusiness_products_image') !!}
    </figure>
@if ($is_last)
@endif
