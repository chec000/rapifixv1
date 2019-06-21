<!-- product block-->
<div class="products-block home has-dropdown">
    <div class="products-desc withbg mid wrapper">
        <h1 class="products-desc__title">{{ trans('cms::home_products.title') }}</h1>
        <div id="categories-wrapper">
        </div>
        <a class="button button--products small" href="#">{{ trans('cms::home_products.show_all') }}</a>
    </div>
    <div id="products-slider" class="products slider">
        <div id="home-products" class="products__wrap slider__wrap"></div>
        <div id="home-products-empty" class="products-background" style="display: none">
            <h1 class="products-background-header">{{ trans('cms::home_products.empty') }}</h1>
        </div>
        <div id="home-products-loader" class="products-background" style="display: none">
            <h1 class="products-background-header">{{ trans('cms::home_products.loader') }}</h1>
        </div>
    </div>
</div>
<!-- end product block-->
