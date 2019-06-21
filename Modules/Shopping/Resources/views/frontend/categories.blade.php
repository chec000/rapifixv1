{!! PageBuilder::section('head', [
    'title' => $category->name
]) !!}

<div class="products-page inner {{ $category->color }} category">
    <header class="products-page__h">
        <div class="wrapper">
            <ul class="products-page__tabs list-nostyle">
                @foreach ($categories as $c)
                    <li class="products-page__tab @if ($c->id == $category->id) active @endif">
                        <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $c->slug) }}">{{ $c->name }}</a>
                    </li>
                @endforeach
                @if ($showSystemTab)
                    <li class="products-page__tab">
                        <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}#systems">@lang('shopping::products.systems.systems')</a>
                    </li>
                @endif
            </ul>
        </div>
    </header>

    <div class="wrapper full-size-mobile">
        <div class="principal category__slider">
            <div class="principal__desc">
                @if ($category->link_banner) <a target="_blank" href="{{ $category->link_banner }}"> @endif
                    <img src="{{ asset($category->image_banner) }}" alt="">
                @if ($category->link_banner) </a> @endif
            </div>
        </div>

        <div class="products-block grid has-dropdown">
            <!-- Info Category -->
            <div class="products-desc wrapper">
                <h1 class="products-desc__title purple">{{ $category->name }}</h1>
                <p class="products-desc__description visible">{!!  $category->description !!}</p>

                @if ($filters->count() > 0)
                    <div class="products-filter">
                        <h2 class="products-filter__title">@lang('shopping::products.categories.filtered_by'):</h2>
                        <ul class="products-filter__list list-nostyle">
                            <li class="products-filter__item {{ empty(app('request')->input('f')) ? 'active' : '' }}">
                                <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug) }}">@lang('shopping::products.categories.all_products')</a>
                            </li>
                            @foreach ($filters as $filter)
                                <li class="products-filter__item {{ app('request')->input('f') == $filter->id ? 'active' : '' }}">
                                    <a data-id="{{ $filter->id }}" data-type="d" class="select-filter" href="?f={{ $filter->id }}">{{ $filter->filter->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="products-filter__dropdown dropdown light">
                            <span class="dropdown-toggle products-filter__dropdown">{{ $filters->first()->name }}
                                <div class="dropdown-list">
                                    <ul class="list-nostyle">
                                        <li class="dropdown-item" {{ empty(app('request')->input('f')) ? 'highlight' : '' }}>
                                            <a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug) }}">{{ $filter->filter->name }}</a>
                                        </li>
                                        @foreach ($filters as $filter)
                                            <li class="dropdown-item" {{ app('request')->input('f') == $filter->id ? 'highlight' : '' }}><a data-id="{{ $filter->id }}" data-type="m" class="select-filter" href="?f={{ $filter->id }}">{{ $filter->filter->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </span>
                        </div>
                    </div>
                @endif
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
                                <span class="product__nums">
                                    @if (show_price())
                                        <span class="product__price">{{ currency_format($product->countryProduct->price, $currency) }}</span>
                                    @endif

                                    @if (show_points())
                                        <span class="product__pts">{{ $product->countryProduct->points }} @lang('shopping::products.pts')</span>
                                    @endif
                                </span>
                            </a>
                            @if (show_add_to_car())
                                <footer class="product__f">
                                    <div class="product__sep"></div>
                                    <button onclick="ShoppingCart.add_one('{{ $product->countryProduct->id }}')" class="button clean" type="button">@lang('shopping::products.add_to_car')</button>
                                </footer>
                            @endif
                        </div>
                    @endforeach

                    @if (show_disclaimer() && $products->count() > 0)
                        @if (\App\Helpers\SessionHdl::hasEo())
                            <p class="disclaimer theme--white">@lang('shopping::products.disclaimer_eo')</p>
                        @else
                            <p class="disclaimer theme--white">@lang('shopping::products.disclaimer')</p>
                        @endif

                    @endif
                </div>

                @empty ($products->items())
                    <h2 style="background: #FFF; padding: 40px 5px; margin: 0px;">{{ trans('cms::home_products.empty') }}</h2>
                @endempty

                @if (!empty($products->items()))
                    <div class="pager"><a class="pager__ctrl prev" href="{{ $products->previousPageUrl() }}{{ (app('request')->has('f') && !empty($products->previousPageUrl())) ? '&f='.app('request')->input('f') : '' }}"><span class="pager__arrow"></span><span class="pager__label">@lang('cms::cedis.general.prev_page')</span></a>
                        <ul class="pager__list list-nostyle">
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                <li class="pager__item {{ $page == $products->currentPage() ? 'active' : '' }}"> <a href="{{ $products->url($page) }}{{ app('request')->has('f') ? '&f='.app('request')->input('f') : '' }}">{{ $page }}</a></li>
                            @endfor
                        </ul>
                        <a class="pager__ctrl next" href="{{ $products->nextPageUrl() }}{{ (app('request')->has('f') && !empty($products->nextPageUrl())) ? '&f='.app('request')->input('f') : '' }}"><span class="pager__label">@lang('cms::cedis.general.next_page')</span><span class="pager__arrow"></span></a>
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
    });
</script>