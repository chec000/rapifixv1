{!! PageBuilder::section('head', ['title' => trans('cms::cedis.detail.cedis') .' '. mb_strtoupper($cedis->name) ]) !!}

<div class="ezone">
    <div class="wrapper full-size-mobile ezone__container">
        <div class="ezone__panel cedis">
            <figure class="cedis__gallery--main">
                <img width="390" height="400" src="{{ asset($cedis->image_01) }}" alt="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}" title="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}">
            </figure>
            @if (!empty($cedis->image_02))
            <figure class="cedis__gallery--item">
                <img src="{{ asset($cedis->image_02) }}" alt="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}" title="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}">
            </figure>
            @endif
            @if (!empty($cedis->image_03))
            <figure class="cedis__gallery--item">
                <img src="{{ asset($cedis->image_03) }}" alt="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}" title="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}">
            </figure>
            @endif
        </div>
        <!-- detail section -->
        <div class="ezone__content ezone__details">
            <section class="ezone__section">
                <header class="ezone__header">
                    <div class="ezone__headline bordered">
                        <h1 class="ezone__title small">@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}</h1>
                    </div>
                </header>
                <div class="ezone__body">
                    <div class="ezone__textcontent">
                        <div class="text">
                            <p>{{ $cedis->description }}<br><br></p>

                            @if ( !empty($cedis->address) )
                                <p><strong>@lang('cms::cedis.detail.address'):</strong> {{ $cedis->address }}</p>
                            @endif

                            @if ( !empty($cedis->neighborhood) )
                                    <p><strong>@lang('cms::cedis.detail.neighborhood_'.strtolower($cedis->country->country_key)):</strong> {{ $cedis->neighborhood }}</p>
                            @endif

                            @if ( !empty($cedis->postal_code) )
                                <p><strong>@lang('cms::cedis.detail.postal_code'):</strong> {{ $cedis->postal_code }}</p>
                            @endif

                            <p><strong>@lang('cms::cedis.detail.state'):</strong> {{ $cedis->state_name }}</p>

                            <p><strong>@lang('cms::cedis.detail.city'):</strong> {{ $cedis->city_name }}</p>

                            @if ( !empty($cedis->phone_number_01) )
                                <p><strong>@lang('cms::cedis.detail.phone_number_01'):</strong> {{ $cedis->phone_number_01 }}</p>
                            @endif

                            @if ( !empty($cedis->phone_number_02) )
                                <p><strong>@lang('cms::cedis.detail.phone_number_02'):</strong> {{ $cedis->phone_number_02 }}</p>
                            @endif

                            @if ( !empty($cedis->telemarketing) )
                                <p><strong>@lang('cms::cedis.detail.telemarketing'): </strong>{{ $cedis->telemarketing }}</p>
                            @endif

                            @if ( !empty($cedis->fax) )
                                <p><strong>@lang('cms::cedis.detail.fax'): </strong>{{ $cedis->fax }}</p>
                            @endif

                            @if ( !empty($cedis->email) )
                                <p><strong>@lang('cms::cedis.detail.email'):</strong> {{ $cedis->email }}</p>
                            @endif

                            <p><strong>@lang('cms::cedis.detail.schedule'):</strong> {{ $cedis->schedule }}</p>
                        </div>
                        <aside class="ezone__banners mul">
                            <figure class="ezone__banner">
                                <div style="height: 320px;" id="map"></div>
                                <script>
                                    var map;
                                    function initMap() {
                                        map = new google.maps.Map(document.getElementById('map'), {
                                            center: { lat: {{ $cedis->latitude }}, lng: {{ $cedis->longitude }} },
                                            zoom: 14
                                        });

                                        var marker = new google.maps.Marker({
                                            position: { lat: {{ $cedis->latitude }}, lng: {{ $cedis->longitude }} },
                                            map: map,
                                            title: '{{ $cedis->name }}'
                                        });
                                    }
                                </script>
                            </figure>

                            @if (isset($cedis->translate($currentLang)->banner_image) && !empty($cedis->translate($currentLang)->banner_image))
                                <figure class="ezone__banner large" style="overflow: hidden;">
                                    @if (!empty($cedis->banner_link))
                                        <a href="{{ !empty($cedis->banner_link) ? $cedis->banner_link : '#' }}">
                                    @endif
                                    <img style="width: 100%;" src="{{ asset($cedis->translate($currentLang)->banner_image) }}" alt="">
                                    @if (!empty($cedis->banner_link))
                                        </a>
                                    @endif
                                </figure>
                            @endif
                        </aside>
                    </div>
                </div>
            </section>
        </div>
        <!-- end detail section -->
    </div>
</div>

{!! PageBuilder::section('footer') !!}

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBmgIlPaMOTALtAFrpNzOSEpxEJHyoce4&callback=initMap" async defer></script>
