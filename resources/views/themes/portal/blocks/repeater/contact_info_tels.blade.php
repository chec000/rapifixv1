@if ($is_first)
    <ul class="business__grid list-nostyle slider__wrap">
@endif
@php
    $country = PageBuilder::block('contact_country_name');
    $creo = PageBuilder::block('contact_creo_data');
    $contact2 = PageBuilder::block('contact_2_data');
@endphp
        @if ($country != '')
            <li class="business__item slider__item contact">
                <h3 class="business__title business__item-title">{!! $country !!} </h3>
                <p class="business__item-description contact">
                    {!! BlockFormatter::contactCREO($creo, trans('cms::contact.creo')) !!}
                    <br>
                    {!! $contact2 !!}
                </p>
            </li>
        @endif
@if ($is_last)
    </ul>
@endif
