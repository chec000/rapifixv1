{!! PageBuilder::section('head', [
    'title' => $system->name
]) !!}

@php
    app('request')->session()->flash('system_color', $system->color);
@endphp

<div class="products-page inner category {{ $system->color }}">
    <header class="products-page__h">
        <div class="wrapper">
            <ul class="products-page__tabs list-nostyle">
                @foreach ($categories as $c)
                    <li class="products-page__tab">
                        <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $c->slug) }}">{{ $c->name }}</a>
                    </li>
                @endforeach
                @if ($showSystemTab)
                    <li class="products-page__tab active">
                        <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}#systems">@lang('shopping::products.systems.systems')</a>
                    </li>
                @endif
            </ul>
        </div>
    </header>

    <div class="wrapper full-size-mobile">
        <div class="principal category__slider">
            <div class="principal__desc">
                @if ($system->link_banner) <a target="_blank" href="{{ $system->link_banner }}"> @endif
                    <img src="{{ asset($system->image_banner) }}" alt="">
                @if ($system->link_banner) </a> @endif
            </div>
        </div>

        <div class="products-block grid has-dropdown">
            <!-- Info Category -->
            <div class="products-desc wrapper">
                <h1 class="products-desc__title purple">{{ $system->name }}</h1>
                <p class="products-desc__description visible">{{ $system->description }}</p>

                <div class="products-filter flex-column">
                    @if (show_price())
                        <h2 class="products-filter__title">@lang('shopping::products.systems.total'): <span>{{ currency_format($system->systemPrice, $currency) }}</span></h2>
                    @endif

                    @if (show_add_to_car())
                        <button onclick="ShoppingCart.add_system('{{ $system->id }}')" class="button" type="button">@lang('shopping::products.systems.buy_system')</button>
                    @endif
                </div>

                @if (show_disclaimer())
                    @if (\App\Helpers\SessionHdl::hasEo())
                        <p class="disclaimer" style="order: 10;">@lang('shopping::products.disclaimer_eo')</p>
                    @else
                        <p class="disclaimer" style="order: 10;">@lang('shopping::products.disclaimer')</p>
                    @endif
                @endif

                <div style="order: 12" class="products-filter">
                    <h2 class="products-filter__title">@lang('shopping::products.systems.other'):</h2>
                    <ul class="products-filter__list list-nostyle">
                        @foreach ($systems as $s)
                            @if ($s->id != $system->id)
                                <li class="products-filter__item active">
                                    <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'system']), $s->slug) }}">{{ $s->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="products-filter__dropdown dropdown light">
                        <span class="dropdown-toggle products-filter__dropdown">{{ $system->name }}
                            <div class="dropdown-list">
                                <ul class="list-nostyle">
                                    <li class="dropdown-item">
                                        <a href="#">{{ $system->name }}</a>
                                    </li>
                                    @foreach ($systems as $s)
                                        @if ($s->id != $system->id)
                                            <li class="dropdown-item"><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'system']), $s->slug) }}">{{ $s->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="products">
                <div class="products__wrap">
                    @foreach ($products as $product)
                        <div class="product slider__item">
                            @php
                                $productRoute = '#';
                                if (!empty($product->countryProduct->slug)) {
                                    $productRoute = route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'detail']), [($product->countryProduct->slug . '-' . $product->countryProduct->product->sku)]);
                                }
                            @endphp
                            <a class="product__link" href="{{ $productRoute }}">
                                <h3 class="product__name">{{ $product->countryProduct->name }}</h3>
                                <figure class="product__image"><img src="{{ asset($product->countryProduct->image) }}" alt=""/></figure>
                                <p class="product__description">{{ str_limit2($product->countryProduct->description, 74) }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                @empty ($products->items())
                    <h2 style="background: #FFF; padding: 40px 5px; margin: 0px;">{{ trans('cms::home_products.empty') }}</h2>
                @endempty

                @if (!empty($products->items()))
                    <div class="pager"><a class="pager__ctrl prev" href="{{ $products->previousPageUrl() }}"><span class="pager__arrow"></span><span class="pager__label">@lang('cms::cedis.general.prev_page')</span></a>
                        <ul class="pager__list list-nostyle">
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                <li class="pager__item {{ $page == $products->currentPage() ? 'active' : '' }}"> <a href="{{ $products->url($page) }}">{{ $page }}</a></li>
                            @endfor
                        </ul>
                        <a class="pager__ctrl next" href="{{ $products->nextPageUrl() }}"><span class="pager__label">@lang('cms::cedis.general.next_page')</span><span class="pager__arrow"></span></a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{!! PageBuilder::section('footer') !!}
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<script>
    $(document).ready(function () {
        document.products = {!! ShoppingCart::productsToJson(collect($products->items())) !!};

        document.systems = {};
        document.systems['{{ $system->id }}'] = {!! ShoppingCart::productsToJson($system->groupProducts->where('active', 1)) !!};
    });
</script>