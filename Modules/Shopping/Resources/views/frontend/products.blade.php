{!! PageBuilder::section('head', [
    'title' => trans('shopping::products.products')
]) !!}

<div class="products-page general">
    <div class="wrapper full-size-mobile"><h1 class="products-maintitle">@lang('shopping::products.categories.title')</h1>
        <!-- products -->
        @php $i = 1; @endphp
        @foreach ($categories as $category)
            <div class="products-block">
                <div class="products-desc wrapper">
                    @php
                        $categoryRoute = '#';
                        if (!empty($category->slug)) {
                            $categoryRoute = route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug);
                        }
                    @endphp

                    <a href="{{ $categoryRoute }}"><h1 class="products-desc__title purple">{{ $category->name }}</h1></a>
                    <p class="products-desc__description">{{ $category->description }}</p>

                    <a class="button small" href="{{ $categoryRoute }}">@lang('shopping::products.see_all')</a>
                </div>

                <div class="products slider" id="products-slider{{ $i }}">
                    <div class="products__wrap slider__wrap">
                        @foreach ($products[$category->id] as $countryProduct)
                            @if (($countryProduct->product->is_kit == 0 && showCountryProduct($countryProduct)) || showCountryProductByIP($countryProduct))
                                <div class="product slider__item">
                                    @php
                                        $productRoute = '#';
                                        if (!empty($countryProduct->slug)) {
                                            $productRoute = route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'detail']), [($countryProduct->slug . '-' . $countryProduct->product->sku)]);
                                        }
                                    @endphp

                                    <a class="product__link" href="{{ $productRoute }}">
                                        <h3 class="product__name">{{ $countryProduct->name }}</h3>
                                        <figure class="product__image">
                                            <img src="{{ asset($countryProduct->image) }}" alt=""/>
                                        </figure>
                                        <p class="product__description">{{ str_limit2($countryProduct->description, 74) }}</p>
                                        <span class="product__nums">
                                            @if (show_price())
                                                <span class="product__price">{{ currency_format($countryProduct->price, $currency) }}</span>
                                            @endif

                                            @if (show_points())
                                                <span class="product__pts">{{ $countryProduct->points }} @lang('shopping::products.pts')</span>
                                            @endif
                                        </span>
                                    </a>

                                    @if (show_add_to_car())
                                        <footer class="product__f">
                                            <div class="product__sep"></div>
                                            <button class="button clean" type="button" onclick="ShoppingCart.add('{{ $countryProduct->id }}', 1)">@lang('shopping::products.add_to_car')</button>
                                        </footer>
                                    @endif
                                </div>
                            @endif
                        @endforeach

                        @if (show_disclaimer())
                            @if (\App\Helpers\SessionHdl::hasEo())
                                <p class="disclaimer theme--white">@lang('shopping::products.disclaimer_eo')</p>
                            @else
                                <p class="disclaimer theme--white">@lang('shopping::products.disclaimer')</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            @php $i++; @endphp
        @endforeach
        <!-- end products -->

        @if ($systems->count() > 0)
            <!-- system -->
            @if ($systems->first() != null)
                @php
                    $hasFirstProduct = false;
                @endphp
                @foreach ($systems as $system)
                    @php
                        if ($system->hasProducts && !$hasFirstProduct) {
                            $description = $system->description;
                            $benefits    = $system->benefit;
                            $banner      = $system->image;
                            $link        = $system->link_banner_two;
                            $price       = $system->systemPrice;
                            $url         = route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'system']), $system->slug);
                            $systemId    = $system->id;
                            $hasFirstProduct = true;
                        }
                    @endphp
                @endforeach
            @endif

            @if ($hasFirstProduct)
            <div id="systems" class="products-block sistem has-dropdown">
                <div id="productsCategory" class="products-desc banner withbg mid wrapper">
                    <h1 class="products-desc__title">@lang('shopping::products.systems.systems')</h1>
                    <div class="tools__form-group">
                        <div class="select select--categories">
                            <select class="form-control" name="system">
                                @foreach ($systems as $system)
                                    @if ($system->hasProducts)
                                        <option data-id="{{ $system->id }}" value="{{ route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'system']), $system->slug) }}">{{ $system->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p id="description" class="products-desc__description">{{ $description }}</p>
                    <a id="view-system" class="button small button--products" href="{{ $url }}">@lang('shopping::products.systems.view_system')</a>
                </div>

                <div class="products slider" id="products-slider{{ $i }}">
                    <div class="products__wrap slider__wrap">
                        <div class="product slider__item banner">
                            @if (!empty($link)) <a class="product__link" href="{{ $link }}" target="_blank"> @endif
                                <figure id="image_system" class="product__image">
                                    <img id="banner" src="{{ asset($banner) }}" alt=""/>
                                </figure>
                            @if (!empty($link)) </a> @endif
                        </div>

                        <div class="product product-sale banner">
                            <p id="benefits" class="product-sale__text">{{ $benefits }}</p>
                            @if (show_price())
                                <p class="product-sale__price">@lang('shopping::products.systems.system_price'): <span id="price">{{ currency_format($price, $currency) }}</span></p>
                            @endif

                            @if (show_add_to_car())
                                <button onclick="ShoppingCart.add_system('{{ $systemId }}')" class="button small button--products" type="button">@lang('shopping::products.systems.buy')</button>
                            @endif

                            @if (show_disclaimer())
                                @if (\App\Helpers\SessionHdl::hasEo())
                                    <p class="disclaimer theme--purple">@lang('shopping::products.disclaimer_eo')</p>
                                @else
                                    <p class="disclaimer theme--purple">@lang('shopping::products.disclaimer')</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end system -->
            @endif
        @endif
    </div>
</div>

{!! PageBuilder::section('footer') !!}
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<script type="application/javascript">
    $(document).ready(function () {
        var products;
        document.products = {};

        @foreach ($categories as $category)
            products = {!! ShoppingCart::productsToJson($category->groupProducts->where('active', 1)->where('product_category', 1)->where('delete', 0)) !!};
            $.each(products, function (i, product) {
                document.products[i] = product;
            });
        @endforeach


        @if ($systems->count() > 0)
            document.systems = {};
            @foreach ($systems as $system)
                @if ($system->hasProducts)
                    document.systems['{{ $system->id }}'] = {};
                    products = {!! ShoppingCart::productsToJson($system->groupProducts->where('active', 1)) !!};
                    $.each(products, function (i, product) {
                        document.systems['{{ $system->id }}'][i] = product;
                    });
                @endif
            @endforeach
        @endif

        $('[name=system]').change(function () {
            var id = $('[name=system]').find(':selected').data('id');

            $.ajax({
                url: '{{ route('products.getGroup') }}',
                method: 'POST',
                dataType: 'JSON',
                data: {id: id, _token: '{{ csrf_token() }}'},
                statusCode: { 419: function() {window.location.href = URL_PROJECT} }
            }).done(function (response, textStatus, jqXHR) {
                if (response.status) {
                    $('#description').text(response.data.description);
                    $('#benefits').text(response.data.benefits);
                    @if (show_price())
                        $('#price').text(response.data.total_price);
                    @endif

                    $('.product.product-sale.banner button').attr('onclick', 'ShoppingCart.add_system(\''+id+'\')');

                    $('#view-system').attr('href', response.data.url_group);

                    if (response.data.link != '' && response.data.link != undefined) {
                        $('#image_system').html('<a target="_blank" class="product__link" href="'+response.data.link+'"><figure class="product__image"><img id="banner" src="'+response.data.banner+'" alt=""/></figure></a>');
                    } else {
                        $('#image_system').html('<figure class="product__image"><img id="banner" src="'+response.data.banner+'" alt=""/></figure>');
                    }
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        });
    });
</script>
{{-- <script src="{{ PageBuilder::js('inactivity') }}"></script> --}}