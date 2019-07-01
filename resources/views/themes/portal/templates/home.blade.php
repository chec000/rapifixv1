@php \App\Helpers\ShoppingCart::validateProductWarehouse(\App\Helpers\SessionHdl::getCorbizCountryKey(), \App\Helpers\SessionHdl::getWarehouse()) @endphp

{!! PageBuilder::section('head', [
'shoppingCart' => ShoppingCart::getItems(session()->get('portal.main.country_corbiz')),
'currency'     => session()->get('portal.main.currency_key'),
'subtotal'     => ShoppingCart::getSubtotalFormatted(session()->get('portal.main.country_corbiz'), session()->get('portal.main.currency_key')),
'points'       => ShoppingCart::getPoints(session()->get('portal.main.country_corbiz'))
]) !!}

<!-- Main slider home markup-->
{!! PageBuilder::block('main_slider', [
'view' => PageBuilder::block('main_slider_view'),
'gradient_theme' => PageBuilder::block('main_slider_gradient_theme'),
'signal_title' => PageBuilder::block('signal_title'),
'signal_title_highlight' => PageBuilder::block('signal_title_highlight')
]) !!}
<!-- end Main slider home markup-->

{!! Form::open(array('id'=>'save_cookies','url' => 'save_read_cookies'))!!}
<input type="hidden"  name="type_option"  id="type_option" value="" >
<input type="hidden"  name="country_selected"  id="country_selected" value="" >
{!! Form::close() !!}

{!! PageBuilder::section('footer') !!}

<script type="text/javascript">
    var GET_CATEGORIES_URL = "{{ url('/web_api/categories') }}";
    var GET_PRODUCTS_URL = "{{ url('/web_api/products') }}";
    var PUBLIC_URL = "{{ asset('/') }}";
    var BRAND_ID = "{{ session()->get('portal.main.brand.id') }}";
    var COUNTRY_ID = "{{ session()->get('portal.main.country_id') }}";
    var BUTTON_LANG = "{{ trans('cms::home_products.add_product') }}";
</script>
<input type="hidden" id="shop_secret" value="{{ csrf_token() }}">
<script src="{{ PageBuilder::js('shopping_cart_old_browsers') }}"></script>

<script type="text/javascript" src="{{ PageBuilder::js('home_products') }}"></script>
