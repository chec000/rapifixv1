{!! PageBuilder::section('head', ['title' => trans('cms::cedis.general.title')]) !!}

<div class="ezone">
    <!-- content zone -->
    <div class="wrapper full-size-mobile ezone__container">
        <div class="ezone__content ezone__details">
            <section class="ezone__section">
                <header class="ezone__header">
                    <div class="ezone__headline bordered">
                        <h1 class="ezone__title small">@lang('cms::cedis.general.title')</h1>
                    </div>
                </header>

                <div class="datefilter inline">
                    <input type="hidden" id="country" value="{{ $countryKey }}">
                    <div class="datefilter__group"><span class="datefilter__label business-center">@lang('cms::cedis.general.state'):</span>
                        <div class="select">
                            <select class="form-control datefilter--city" name="city">
                                <option value="" disabled="" selected >@lang('cms::cedis.general.state_select')</option>
                                @foreach ($response['data'] as $city)
                                    <option @if ($cedisStateKey != null && $cedisStateKey == $city['id']) {{ 'selected' }} @endif value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if (!$response['status'] && isset($response['messages'][0]))
                            <span style="font-size: 12px;color: #a94442;margin-left: 10px; width: 100%;">{{ $response['messages'][0] }}</span>
                        @endif
                    </div>
                </div>

                <div class="ezone__description">
                    <p>@lang('cms::cedis.general.description')</p>
                </div>

                <!-- grid section -->
                <div class="ezone__body">
                    <ul class="ezone__grid-list list-nostyle">
                        @foreach ($allCedis as $cedis)
                            <li class="ezone__grid-item business__grid--item">
                                <a href="{{ route('cedis.detail', $cedis->slug) }}">
                                    <figure class="ezone__grid-img" style="width: 265px; height: 180px; margin: 15px auto 0px auto;">
                                        <img style="width: 100%;" src="{{ asset($cedis->image_01) }}" alt="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}" title="@lang('cms::cedis.detail.cedis') {{ mb_strtoupper($cedis->name) }}">
                                    </figure>
                                    <h3 class="ezone__grid-item__title theme--purple">{{ mb_strtoupper($cedis->name) }}</h3>
                                    <p class="ezone__grid-item__date cedis">{{ $cedis->address . '. ' . $cedis->neighborhood . ' '.trans('cms::cedis.general.postal_code_ab').' ' . $cedis->postal_code . '. ' . $cedis->city_name . ', ' . $cedis->state_name }}</p>
                                    <a href="{{ route('cedis.detail', $cedis->slug) }}" class="button small button--products cedis">@lang('cms::cedis.general.see_cedis')</a>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- end grid section -->

                <!-- pagination -->
                <div class="pager">
                    <a class="pager__ctrl prev" href="{{ $allCedis->previousPageUrl() }}{{ ($cedisCountryKey != null && !empty($allCedis->previousPageUrl())) ? '&country='.$cedisCountryKey : '' }}{{ ($cedisStateKey != null && !empty($allCedis->previousPageUrl())) ? '&city='.$cedisStateKey : '' }}">
                        <span class="pager__arrow"></span><span class="pager__label">@lang('cms::cedis.general.prev_page')</span>
                    </a>
                    <ul class="pager__list list-nostyle">
                        @for ($page = 1; $page <= $allCedis->lastPage(); $page++)
                            <li class="pager__item {{ $page == $allCedis->currentPage() ? 'active' : '' }}">
                                <a href="{{ $allCedis->url($page) }}{{ $cedisCountryKey != null ? '&country='.$cedisCountryKey : '' }}{{ $cedisStateKey != null ? '&city='.$cedisStateKey : '' }}">{{ $page }}</a>
                            </li>
                        @endfor
                    </ul>
                    <a class="pager__ctrl next" href="{{ $allCedis->nextPageUrl() }}{{ ($cedisCountryKey != null && !empty($allCedis->nextPageUrl())) ? '&country='.$cedisCountryKey : '' }}{{ ($cedisStateKey != null && !empty($allCedis->nextPageUrl())) ? '&city='.$cedisStateKey : '' }}">
                        <span class="pager__label">@lang('cms::cedis.general.next_page')</span><span class="pager__arrow"></span>
                    </a>
                </div>
                <!-- end pagination -->
            </section>
        </div>
    </div>
    <!-- end zone content -->
</div>


{!! PageBuilder::section('footer') !!}

<script src="{{ asset('cms/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('[name="country"]').change(function () {
           var country_key = $(this).val();
           if (country_key != '' && country_key != null) {
               window.location.replace('{{ route('cedis.index') }}?country='+country_key);
           }
       });

        $('[name="city"]').change(function () {
            var country_key = $('#country').val();
            var city_key    = $(this).val();

            if (country_key != '' && country_key != null && city_key != '' && city_key != null) {
                window.location.replace('{{ route('cedis.index') }}?country='+country_key+'&city='+city_key);
            } else {
                window.location.replace('{{ route('cedis.index') }}?city='+city_key);
            }
        });
    });
</script>
