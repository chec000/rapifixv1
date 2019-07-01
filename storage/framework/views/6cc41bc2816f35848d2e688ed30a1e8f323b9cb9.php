<?php \App\Helpers\ShoppingCart::validateProductWarehouse(\App\Helpers\SessionHdl::getCorbizCountryKey(), \App\Helpers\SessionHdl::getWarehouse()) ?>

<?php echo PageBuilder::section('head', [
'shoppingCart' => ShoppingCart::getItems(session()->get('portal.main.country_corbiz')),
'currency'     => session()->get('portal.main.currency_key'),
'subtotal'     => ShoppingCart::getSubtotalFormatted(session()->get('portal.main.country_corbiz'), session()->get('portal.main.currency_key')),
'points'       => ShoppingCart::getPoints(session()->get('portal.main.country_corbiz'))
]); ?>


<!-- Main slider home markup-->
<?php echo PageBuilder::block('main_slider', [
'view' => PageBuilder::block('main_slider_view'),
'gradient_theme' => PageBuilder::block('main_slider_gradient_theme'),
'signal_title' => PageBuilder::block('signal_title'),
'signal_title_highlight' => PageBuilder::block('signal_title_highlight')
]); ?>

<!-- end Main slider home markup-->

<?php echo Form::open(array('id'=>'save_cookies','url' => 'save_read_cookies')); ?>

<input type="hidden"  name="type_option"  id="type_option" value="" >
<input type="hidden"  name="country_selected"  id="country_selected" value="" >
<?php echo Form::close(); ?>


<?php echo PageBuilder::section('footer'); ?>


<script type="text/javascript">
    var GET_CATEGORIES_URL = "<?php echo e(url('/web_api/categories')); ?>";
    var GET_PRODUCTS_URL = "<?php echo e(url('/web_api/products')); ?>";
    var PUBLIC_URL = "<?php echo e(asset('/')); ?>";
    var BRAND_ID = "<?php echo e(session()->get('portal.main.brand.id')); ?>";
    var COUNTRY_ID = "<?php echo e(session()->get('portal.main.country_id')); ?>";
    var BUTTON_LANG = "<?php echo e(trans('cms::home_products.add_product')); ?>";
</script>
<input type="hidden" id="shop_secret" value="<?php echo e(csrf_token()); ?>">
<script src="<?php echo e(PageBuilder::js('shopping_cart_old_browsers')); ?>"></script>

<script type="text/javascript" src="<?php echo e(PageBuilder::js('home_products')); ?>"></script>
