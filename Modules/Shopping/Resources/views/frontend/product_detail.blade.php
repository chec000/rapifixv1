{!! PageBuilder::section('head', [
    'socialTags' => $socialTags,
    'title'      => $countryProduct->name
]) !!}

<div class="products-page inner {{ $backgroundColor }} detail">
    <!-- categories -->
    <header class="products-page__h">
        <div class="wrapper">
            <ul class="products-page__tabs list-nostyle">
                @foreach ($categories as $c)
                    <li class="products-page__tab @if (!is_null($category) && $c->id == $category->id) active @endif"><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $c->slug) }}">{{ $c->name }}</a></li>
                @endforeach
                @if ($showSystemTab)
                    <li class="products-page__tab"><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}#systems">@lang('shopping::products.systems.systems')</a></li>
                @endif
            </ul>
        </div>
    </header>
    <!-- end categories -->

    <!-- Product Main description -->
    <div id="product-detail" class="wrapper">
        <div class="principal">
            <figure class="principal__fig">
                <img src="{{ asset($countryProduct->image) }}">
            </figure>

            <div class="principal__desc">
                <ul class="list-nostyle principal__breadcrumbs">
                    <li><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'index'])) }}">@lang('shopping::products.detail.back_products')</a></li>
                    @if (!is_null($category))
                        <li><a href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug) }}">{{ $category->name }}</a></li>
                    @endif
                    <li><a href="#">{{ $countryProduct->name }}</a></li>
                </ul>

                <h1 class="principal__title">{{ $countryProduct->name }}</h1>
                <h2 class="principal__subtitle">{{ $countryProduct->short_description }}</h2>
                @if (show_price())
                    <p class="principal__price">{{ currency_format($countryProduct->price, $currency) }}</p>
                @endif

                @if (show_points())
                    <p class="principal__pts">{{ $countryProduct->points }} @lang('shopping::products.pts')</p>
                @endif

                @if (show_add_to_car())
                    <div class="principal__ctrls">
                        <div class="form-group numeric transparent principal__quantity">
                            <span class="minus">
                                <svg height="14" width="14">
                                    <line x1="0" y1="8" x2="14" y2="8"></line>
                                </svg>
                            </span>
                            <input min="0" max="9999" oninput="maxLengthCheck(this)" onkeypress="return isNumeric(event)" class="form-control" type="numeric" name="qty#{val}" value="1">
                            <span class="plus">
                                <svg height="14" width="14">
                                    <line x1="0" y1="7" x2="14" y2="7"></line>
                                    <line x1="7" y1="0" x2="7" y2="14"></line>
                                </svg>
                            </span>
                        </div>
                        <button data-id="{{ $countryProduct->id }}" id="add-product" class="button transparent small principal__addtocart">@lang('shopping::product_detail.add_to_cart')</button>
                    </div>
                @endif

                <p class="principal__text">{{ $countryProduct->description }}</p>
                @if (show_disclaimer())
                    @if (\App\Helpers\SessionHdl::hasEo())
                        <p class="disclaimer">@lang('shopping::products.disclaimer_eo')</p>
                    @else
                        <p class="disclaimer">@lang('shopping::products.disclaimer')</p>
                    @endif
                @endif

                <footer class="principal__footer">
                    <div class="principal__social dropdown light hasicons">
                        <span class="dropdown-toggle">
                            @if (!empty($countryProduct->nutritional_table) && in_array($category->brandGroup->brand_id, $nutritionalTableIds))
                                <a class="nutritional--btn" href="#nutritional" data-modal="true">
                                    <img class="icon icon-list" src="{{ asset('themes/omnilife2018/images/list2.svg') }}" alt=""><span>@lang('shopping::products.detail.nutritional_table')</span>
                                </a>
                            @endif
                            <svg class="icon icon-share" id="icon-share" viewBox="0 0 20 20" style="z-index: -1;">
                                <title>@lang('shopping::product_detail.share')</title>
                                <path fill-rule="nonzero" d="M16.575 13.034c-.977 0-1.855.418-2.479 1.086l-7.29-3.63a3.55 3.55 0 0 0 .043-.521 3.56 3.56 0 0 0-.04-.508l7.278-3.59a3.385 3.385 0 0 0 2.488 1.095c1.892 0 3.425-1.56 3.425-3.483C20 1.559 18.467 0 16.575 0c-1.891 0-3.424 1.559-3.424 3.483 0 .173.016.341.04.508L5.913 7.58a3.385 3.385 0 0 0-2.488-1.095C1.533 6.486 0 8.046 0 9.969c0 1.924 1.533 3.483 3.425 3.483.977 0 1.855-.418 2.479-1.085l7.29 3.63c-.026.17-.044.342-.044.52 0 1.924 1.533 3.483 3.425 3.483S20 18.441 20 16.517c0-1.924-1.533-3.483-3.425-3.483z"></path>
                            </svg>@lang('shopping::product_detail.share')
                            <div class="dropdown-list">
                                <ul class="list-nostyle">
                                    <li class="dropdown-item fb-share">
                                        <figure class="flag"><img src="{{ asset('themes/omnilife2018/images/facebook.svg') }}" alt="Facebook"></figure>Facebook
                                    </li>
                                    <li class="dropdown-item tw-share">
                                        <figure class="flag"><img src="{{ asset('themes/omnilife2018/images/twitter.svg') }}" alt="Twitter"></figure>Twitter
                                    </li>
                                </ul>
                            </div>
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- end Main description -->

    <!-- Detail body content -->
    <div class="wrapper full-size-mobile products-body">
        <!-- Info tabs -->
        <div class="tabs expanded products-tabs">
            <div class="tabs__header">
                <div class="tabs__item active"><a href="#ben">@lang('shopping::products.detail.benefits')</a></div>
                @if (!empty($countryProduct->ingredients))
                    <div class="tabs__item"><a href="#ing">@lang('shopping::products.detail.ingredients')</a></div>
                @endif
                @if (!empty($countryProduct->comments))
                    <div class="tabs__item"><a href="#com">@lang('shopping::products.detail.comments')</a></div>
                @endif
            </div>
            <div class="tabs__content">
                <div class="tabs__pane active" id="ben">
                    <p>{{ $countryProduct->benefits }}</p>
                </div>
                @if (!empty($countryProduct->ingredients))
                    <div class="tabs__pane" id="ing">
                        <p>{{ $countryProduct->ingredients }}</p>
                    </div>
                @endif
                @if (!empty($countryProduct->comments))
                    <div class="tabs__pane" id="com">
                        <p>{{ $countryProduct->comments }}</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- end Info tabs -->

        @if ($relatedProducts->count() >= 2)
            @php $cost = 0.0; @endphp

            <!-- Products block complement -->
            <div class="products-block complementary">
                <div class="products slider" id="products-complementary">
                    <div class="products__wrap slider__wrap">
                        @for ($i = 0; $i < $relatedProducts->count(); $i++)
                            @php $cost += $relatedProducts[$i]->relatedProduct->price; @endphp

                            <div class="product slider__item">
                                <a class="product__link" href="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'detail']), ($relatedProducts[$i]->relatedProduct->slug . '-' . $relatedProducts[$i]->relatedProduct->product->sku)) }}">
                                    <h3 class="product__name">{{ $relatedProducts[$i]->relatedProduct->name }}</h3>
                                    <figure class="product__image">
                                        <img src="{{ asset($relatedProducts[$i]->relatedProduct->image) }}" alt=""/>
                                    </figure>
                                    <span class="product__nums">
                                    @if (show_price())
                                            <span class="product__price">{{ currency_format($relatedProducts[$i]->relatedProduct->price, $currency) }}</span>
                                    @endif

                                    @if (show_points())
                                        <span class="product__pts">{{ $relatedProducts[$i]->relatedProduct->points }} @lang('shopping::products.pts')</span>
                                    @endif
                                </span>
                                </a>
                                @if (show_add_to_car())
                                    <footer class="product__f">
                                        <div class="product__sep"></div>
                                        <button onclick="ShoppingCart.add_one('{{ $relatedProducts[$i]->relatedProduct->id }}')" class="button clean" type="button">@lang('shopping::product_detail.add_to_cart')</button>
                                    </footer>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="products-desc wrapper">
                    <h1 class="products-desc__title purple">@lang('shopping::products.detail.complementary_products')</h1>
                    <p class="products-desc__description visible">@lang('shopping::products.detail.complementary_des')</p>
                    @if (show_price())
                        <span class="products-desc__price">{{ currency_format($cost, $currency) }}</span>
                    @endif

                    @if (show_add_to_car())
                        <a onclick="ShoppingCart.add_related_products('{{ $countryProduct->id }}')" class="button small visible" href="#">@lang('shopping::product_detail.add_to_cart')</a>
                    @endif

                    @if (show_disclaimer())
                        @if (\App\Helpers\SessionHdl::hasEo())
                            <p class="disclaimer">@lang('shopping::products.disclaimer_eo')</p>
                        @else
                            <p class="disclaimer">@lang('shopping::products.disclaimer')</p>
                        @endif
                    @endif
                </div>
            </div>
            <!-- end Products block complement -->
        @endif
    </div>
    <!-- end Detail body content -->
</div>

@if (!empty($countryProduct->nutritional_table) && $category->brandGroup->brand_id == 1)
    <div class="modal alert" id="nutritional">
        <div class="modal__inner ps-container ps">
            <header class="modal__head">
                <h5 class="modal__title highlight">@lang('shopping::products.detail.nutritional_table')</h5>
            </header>
            <div class="modal__body">
                <p><img src="{{ asset($countryProduct->nutritional_table) }}" alt=""></p>
            </div>
            <footer class="modal__foot">
                <div class="buttons-container">
                    <button class="button secondary close" type="button">@lang('shopping::products.close_m')</button>
                </div>
            </footer>
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
    </div>
@endif

{!! PageBuilder::section('footer') !!}
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<script>
    var SHARE_URL = "{{ $socialTags['facebook']['url'] ?: '' }}";
    $(document).ready(function () {
        $('.fb-share').click(function(e) {
            e.preventDefault();
            window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURI(SHARE_URL), 'shareWindow',
                'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' +
                ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });

        $('.tw-share').click(function(e) {
            e.preventDefault();
            window.open('http://twitter.com/share?text={{ $countryProduct->name }}&url='+encodeURI(SHARE_URL), 'shareWindow',
                'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) +
                ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });

        document.products = {};
        var products = {!! ShoppingCart::productsToJson(\Modules\Shopping\Entities\GroupProduct::where('product_id', $countryProduct->id)->get()) !!};
        $.each(products, function (i, product) {
            document.products[i] = product;
        });

        document.related_products = {};
        @if ($relatedProducts->count() >= $relatedProducts->count())
            document.related_products['{{ $countryProduct->id }}'] = {!! ShoppingCart::relatedProductsToJson($relatedProducts) !!};

            var productsRel = {!! ShoppingCart::relatedProductsToJson($relatedProducts) !!};
            $.each(productsRel, function (i, product) {
                document.products[i] = product;
            });
        @endif
    });
</script>
