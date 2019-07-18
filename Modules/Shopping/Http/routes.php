<?php

use App\Helpers\TranslatableUrlPrefix;

foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('shopping') as $lang => $prefix) {

    Route::group(['middleware' => ['web'], 'prefix' => $prefix,
        'namespace' => 'Modules\Shopping\Http\Controllers'], function () use($lang, $prefix) {

        $prefixCheckout = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('checkout', $lang);
        $prefixCheckoutUrl = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('checkout_url', $lang);
        $prefixConfirmation= TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('confirmation', $lang);
        /*if($lang == "es"){
            dd($prefixCheckout.'.'.$prefixConfirmation);
        }*/


        Route::get('/', 'CheckoutController@redirect');
        Route::get('/'.$prefixCheckoutUrl,['as' => $prefixCheckout.'.index','uses' =>'CheckoutController@index']);

        Route::get('/'.$prefixCheckoutUrl.'/'.$prefixConfirmation.'/', ['as' => $prefixCheckout.'.'.$prefixConfirmation, 'uses' => 'CheckoutController@confirmation']);
        Route::post('/'.$prefixCheckoutUrl.'/'.$prefixConfirmation.'/', ['as' => $prefixCheckout.'.'.$prefixConfirmation, 'uses' => 'CheckoutController@confirmation']);
    });
}




Route::group(['middleware' => ['web'], 'prefix' => 'shopping',
    'namespace' => 'Modules\Shopping\Http\Controllers'], function () {
    Route::get('/checkout/getShippingAddress/{getFromWs}', ['as' => 'checkout.getShippingAddress', 'uses' => 'CheckoutController@getShippingAddress']);
    Route::post('/checkout/shippingAddress/states', ['as' => 'checkout.shippingAddress.states', 'uses' => 'CheckoutController@states']);
    Route::post('/checkout/shippingAddress/cities', ['as' => 'checkout.shippingAddress.cities', 'uses' => 'CheckoutController@cities']);
    Route::post('/checkout/shippingAddress/citiesUSA', ['as' => 'checkout.shippingAddress.citiesUSA', 'uses' => 'CheckoutController@citiesUSA']);
    Route::post('/checkout/shippingAddress/zipcode', ['as' => 'checkout.shippingAddress.zipcode', 'uses' => 'CheckoutController@zipcode']);
    Route::post('/checkout/shippingAddress/shippingCompanies', ['as' => 'checkout.shippingAddress.shippingCompanies', 'uses' => 'CheckoutController@shippingCompanies']);
    Route::post('/checkout/shippingAddress/addShippingAddress', ['as' => 'checkout.shippingAddress.addShippingAddress', 'uses' => 'CheckoutController@addShippingAddress']);
    Route::post('/checkout/shippingAddress/validateAddShippingAddress', ['as' => 'checkout.shippingAddress.validateAddShippingAddress',
        'uses' => 'CheckoutController@postValidateAddShippinAddress']);
    Route::post('/checkout/shippingAddress/deleteShipmentAddress', ['as' => 'checkout.shippingAddress.deleteShipmentAddress',
        'uses' => 'CheckoutController@deleteShipmentAddress']);
    Route::post('/checkout/shippingAddress/getEditShipmentAddress', ['as' => 'checkout.shippingAddress.getEditShipmentAddress',
        'uses' => 'CheckoutController@getEditShipmentAddress']);
    Route::post('/checkout/shippingAddress/validateEditShippingAddress', ['as' => 'checkout.shippingAddress.validateEditShippingAddress',
        'uses' => 'CheckoutController@postValidateEditShippinAddress']);
    Route::post('/checkout/shippingAddress/editShippingAddress', ['as' => 'checkout.shippingAddress.editShippingAddress',
        'uses' => 'CheckoutController@editShippingAddress']);
    Route::get('/checkout/selectShippingAddress/{folio}', ['as' => 'checkout.selectShippingAddress', 'uses' => 'CheckoutController@selectShippingAddress']);
    Route::get('/checkout/quotation/getCartPreviewQuotation', ['as' => 'checkout.quotation.getCartPreviewQuotation',
        'uses' => 'CheckoutController@getResumeCartViewAfterQuotation']);
    Route::get('/checkout/quotation/setChangePeriodSession/{change_period}', ['as' => 'checkout.quotation.setChangePeriodSession',
        'uses' => 'CheckoutController@setChangePeriodSession']);
    Route::get('/checkout/quotation/getInitQuotation/{process}', ['as' => 'checkout.quotation.getInitQuotation', 'uses' => 'CheckoutController@getInitQuotation']);
    Route::get('/checkout/quotation/getViewModalPromotions/{process}', ['as' => 'checkout.quotation.getViewModalPromotions', 'uses' => 'CheckoutController@getViewModalPromotions']);
    Route::post('/checkout/quotation/validateQuantityPromos', ['as' => 'checkout.quotation.validateQuantityPromos', 'uses' => 'PromotionController@validateQuantityPromos']);
    Route::get('/checkout/quotation/getInitQuotationPromos/{process}', ['as' => 'checkout.quotation.getInitQuotation', 'uses' => 'CheckoutController@getInitQuotationPromos']);

    Route::get('/checkout/quotation/validateDataQuotationToStep2', ['as' => 'checkout.quotation.validateDataQuotationToStep2', 'uses' => 'CheckoutController@validateDataQuotationToStep2']);

    Route::post('/checkout/get-payment-view', 'CheckoutController@getPaymentView')->name('checkout.getPaymentView');
    Route::post('/checkout/get-cart-preview', 'CheckoutController@getCartPreview')->name('checkout.getCartPreview');
    Route::post('/checkout/process-transaction/', 'CheckoutController@processCorbizTransaction')->name('checkout.processTransaction');

    Route::get('/checkout/tests', 'CheckoutController@tests');


});

foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('register') as $lang => $prefix) {

    Route::group(['middleware' => ['web', 'cms.brand_middleware', 'prefix_translate'], 'prefix' => $prefix, 'namespace' => 'Modules\Shopping\Http\Controllers'],
        function () use ($lang, $prefix) {

        $prefixConfirmation = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('confirmation', $lang);

        Route::get('/', ['as' => $prefix, 'uses' => 'RegisterController@register']);
        Route::any('/' . $prefixConfirmation, ['as' => $prefix . '.' . $prefixConfirmation, 'uses' => 'RegisterController@confirmation']);
    });

}
    Route::group(['middleware' => ['web'], 'prefix' => 'register', 'namespace' => 'Modules\Shopping\Http\Controllers'],
        function () {
        Route::post('/references', ['as' => 'register.references', 'uses' => 'RegisterController@references']);
        Route::post('/pool', ['as' => 'register.pool', 'uses' => 'RegisterController@pool']);
        Route::post('/questions', ['as' => 'register.questions', 'uses' => 'RegisterController@questions']);
        Route::post('/validateEo', ['as' => 'register.validateeo', 'uses' => 'RegisterController@validateEo']);
        Route::post('/parameters', ['as' => 'register.parameters', 'uses' => 'RegisterController@parameters']);
        Route::post('/banks', ['as' => 'register.banks', 'uses' => 'RegisterController@banks']);
        Route::post('/kits', ['as' => 'register.kits', 'uses' => 'RegisterController@kits']);
        Route::post('/documents', ['as' => 'register.documents', 'uses' => 'RegisterController@documents']);
        Route::post('/updateSession', ['as' => 'register.updatesession', 'uses' => 'RegisterController@updateSession']);
        Route::post('/changeViews', ['as' => 'register.changeViews', 'uses' => 'RegisterController@changeViews']);
        Route::post('/validate_step1', ['as' => 'register.validate_step1', 'uses' => 'RegisterController@postValidateStep1']);
        Route::post('/validate_step2', ['as' => 'register.validate_step2', 'uses' => 'RegisterController@postValidateStep2']);
        Route::post('/validate_step3', ['as' => 'register.validate_step3', 'uses' => 'RegisterController@postValidateStep3']);
        Route::post('/states', ['as' => 'register.states', 'uses' => 'RegisterController@states']);
        Route::post('/cities', ['as' => 'register.cities', 'uses' => 'RegisterController@cities']);
        Route::post('/zipcode', ['as' => 'register.zipcode', 'uses' => 'RegisterController@zipcode']);
        Route::post('/legals', ['as' => 'register.legals', 'uses' => 'RegisterController@legals']);
        Route::post('/checkedterms', ['as' => 'register.checkedterms', 'uses' => 'RegisterController@checkedterms']);
        Route::post('/shippingCompanies', ['as' => 'register.shippingCompanies', 'uses' => 'RegisterController@shippingCompanies']);
        Route::post('/validateFormCorbiz', ['as' => 'register.validateFormCorbiz', 'uses' => 'RegisterController@validateFormCorbiz']);
        Route::post('/exit', ['as' => 'register.exit', 'uses' => 'RegisterController@postExit']);
        Route::post('/warehouse', ['as' => 'register.warehouse', 'uses' => 'RegisterController@getWarehouse']);
        Route::post('/transactionFromCorbiz', ['as' => 'register.transactionFromCorbiz', 'uses' => 'RegisterController@transactionFromCorbiz']);


        Route::post('/setcompany', ['as' => 'register.setcompany', 'uses' => 'RegisterController@setcompany']);

        Route::get('/checkout/quotation/getViewModalPromotions/{process}', ['as' => 'checkout.quotation.getViewModalPromotions', 'uses' => 'CheckoutController@getViewModalPromotions']);
        Route::post('/checkout/quotation/validateQuantityPromos', ['as' => 'checkout.quotation.validateQuantityPromos', 'uses' => 'PromotionController@validateQuantityPromos']);
        Route::post('/getInitQuotationPromos', ['as' => 'register.getInitQuotationPromos', 'uses' => 'RegisterController@getInitQuotationPromos']);
        Route::post('/quotation', ['as' => 'register.quotation', 'uses' => 'RegisterController@initQuotation']);
        Route::get('/quotation/getCartPreviewQuotation', ['as' => 'register.quotation.getCartPreviewQuotation', 'uses' => 'RegisterController@getResumeCartViewAfterQuotation']);
        Route::post('/initQuotation', ['as' => 'register.kitinitiquotation', 'uses' => 'RegisterController@kitInitQuotation']);
        Route::post('/flushRegisterTransaction', ['as' => 'register.flushRegisterTransaction', 'uses' => 'RegisterController@flushRegisterTransaction']);
        Route::post('/backStep2', ['as' => 'register.backStep2', 'uses' => 'RegisterController@backStep2']);
        Route::post('/validatestreet', ['as' => 'register.validatestreet', 'uses' => 'RegisterController@validateStreet']);


    });

foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('client-register') as $lang => $prefix) {
    Route::group(['middleware' => ['web', 'cms.brand_middleware', 'prefix_translate'], 'prefix' => $prefix, 'namespace' => 'Modules\Shopping\Http\Controllers'],
        function () use ($lang, $prefix) {

        $prefixRegistercustomer = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('registercustomer', $lang);
        $prefixActivation = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('activation', $lang);

        Route::get('/', ['as' => $prefixRegistercustomer, 'uses' => 'RegisterCustomerController@index']);
        Route::get('/' . $prefixActivation, ['as' => $prefixRegistercustomer.'.'.$prefixActivation, 'uses' => 'RegisterCustomerController@getActivation']);
    });
}
    Route::group(['middleware' => ['web'], 'prefix' => 'client-register', 'namespace' => 'Modules\Shopping\Http\Controllers'], function () {
        Route::post('/validate_step1', ['as' => 'registercustomer.validate_step1', 'uses' => 'RegisterCustomerController@postValidateStep1']);
        Route::post('/validate_step2', ['as' => 'registercustomer.validate_step2', 'uses' => 'RegisterCustomerController@postValidateStep2']);
        Route::post('/validate_step3', ['as' => 'registercustomer.validate_step3', 'uses' => 'RegisterCustomerController@postValidateStep3']);
        Route::get('/send_mail', ['as' => 'registercustomer.send_mail', 'uses' => 'RegisterCustomerController@getSendMail']);
        Route::post('/references', ['as' => 'registercustomer.references', 'uses' => 'RegisterCustomerController@postReferences']);
        Route::post('/pool', ['as' => 'registercustomer.pool', 'uses' => 'RegisterCustomerController@postPool']);
        Route::post('/validate_eo', ['as' => 'registercustomer.validateeo', 'uses' => 'RegisterCustomerController@postValidateEo']);
        Route::post('/parameters', ['as' => 'registercustomer.parameters', 'uses' => 'RegisterCustomerController@postParameters']);
        Route::post('/documents', ['as' => 'registercustomer.documents', 'uses' => 'RegisterCustomerController@postDocuments']);
        Route::post('/change_view', ['as' => 'registercustomer.changeview', 'uses' => 'RegisterCustomerController@postChangeView']);
        Route::post('/states', ['as' => 'registercustomer.states', 'uses' => 'RegisterCustomerController@postStates']);
        Route::post('/cities', ['as' => 'registercustomer.cities', 'uses' => 'RegisterCustomerController@postCities']);
        Route::post('/zipcode', ['as' => 'registercustomer.zipcode', 'uses' => 'RegisterCustomerController@postZipCode']);
        Route::post('/shippingCompanies', ['as' => 'registercustomer.shippingCompanies', 'uses' => 'RegisterCustomerController@postShippingCompanies']);
        Route::post('/save', ['as' => 'registercustomer.save', 'uses' => 'RegisterCustomerController@postSave']);
        Route::post('/update', ['as' => 'registercustomer.update', 'uses' => 'RegisterCustomerController@postUpdate']);

        Route::post('/exit', ['as' => 'registercustomer.exit', 'uses' => 'RegisterCustomerController@postExit']);
        Route::post('/validate_corbiz', ['as' => 'registercustomer.validate_corbiz', 'uses' => 'RegisterCustomerController@postValidateCustomer']);
        Route::post('/generate_transaction', ['as' => 'registercustomer.generate_transaction', 'uses' => 'RegisterCustomerController@postGenerateTransactionCustomer']);
        Route::post('/backStep2', ['as' => 'registercustomer.backStep2', 'uses' => 'RegisterCustomerController@backStep2']);
        Route::post('/validatestreet', ['as' => 'registercustomer.validatestreet', 'uses' => 'RegisterCustomerController@validateStreet']);
    });


Route::group(['middleware' => 'web', 'prefix' => 'customer', 'namespace' => 'Modules\Shopping\Http\Controllers'], function()
{
    Route::get('/', 'RegisterController@register');

});


foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('products') as $lang => $prefix) {
    Route::group(['middleware' => ['web', 'cms.brand_middleware', 'prefix_translate', 'exit.eo'], 'prefix' => $prefix, 'namespace' => 'Modules\Shopping\Http\Controllers'], function () use ($prefix, $lang) {

        $prefixCat = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('category', $lang);

        $prefixSys = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('system', $lang);

        # Index
        Route::get('/', 'ProductController@products')
            ->name($prefix.'.'.'index');

        Route::get('/'.$prefixCat.'/{id}', 'ProductController@category')
            ->name($prefix.'.'.$prefixCat);

        # Category
        Route::get('/'.$prefixCat.'/{category_slug}', 'ProductController@category')
            ->name($prefix.'.'.$prefixCat)
            ->where('category_slug', '[A-Za-z0-9-]+');

        # System
        Route::get('/'.$prefixSys.'/{system_slug}', 'ProductController@system')
            ->name($prefix.'.'.$prefixSys)
            ->where('system_slug', '[A-Za-z0-9-]+');

        # Detail
        Route::get('/{product_slug}', 'ProductController@detail')
            ->name($prefix.'.'.'detail')
            ->where('product_slug', '[A-Za-z0-9-]+');

        Route::get('/session', 'ProductController@session')
            ->name($prefix.'.'.'session');


    });
}



Route::group(['middleware' => ['web'], 'prefix' => 'products', 'namespace' => 'Modules\Shopping\Http\Controllers'], function () {

    Route::post('products/getGroup', 'ProductController@getCountryGroup')->name('products.getGroup');
    # Index
    Route::get('/', 'ProductController@products')
        ->name('products.index');

    Route::get('/', 'ProductController@products')
        ->name('productos.index');

    Route::get('/products/category/{id}', 'ProductController@procuctsByCategory')
        ->name('products.category');



    Route::get('/products/detail{id}', 'ProductController@detail')
        ->name('detail');
    Route::get('/products/session', 'ProductController@getSession')
        ->name('detail');

    Route::get('/{product_slug}', 'ProductController@detail')
        ->name('products.detail')
        ->where('product_slug', '[A-Za-z0-9-]+');


    # Category
    Route::get('/products/{category_slug}', 'ProductController@category')
        ->name('products.category')
        ->where('category_slug', '[A-Za-z0-9-]+');

});

Route::group(['middleware' => 'web', 'prefix' => 'shopping-cart', 'namespace' => 'Modules\Shopping\Http\Controllers'], function() {
    Route::post('/add-one', 'ShoppingCartController@addOneItem')->name('cart.add_one');
    Route::post('/add-many', 'ShoppingCartController@addManyItems')->name('cart.add_many');
    Route::post('/change-quantity', 'ShoppingCartController@changeItemQuantity')->name('cart.change_quantity');
    Route::post('/remove-one', 'ShoppingCartController@removeOneItem')->name('cart.remove_one');
    Route::post('/remove-all-from-item', 'ShoppingCartController@removeAllFromItem')->name('cart.remove_all_from_item');
    Route::post('/remove-all', 'ShoppingCartController@removeAll')->name('cart.remove_all');
    Route::post('/remove-all-resume-cart', 'ShoppingCartController@removeAllResumeCart')->name('cart.remove_all_resume_cart');


    Route::get('/cart-list', ['as' => 'cart.list', 'uses' => 'ShoppingCartController@listProductsCart']);

    Route::get('/cart_products', ['as' => 'cart.list_products', 'uses' => 'ShoppingCartController@getCarrito']);

    
    Route::get('/categories/{id}', 'ProductController@procuctsByCategory')
        ->name('category.products');

        Route::get('/cart-report', 'ShoppingController@export_cart')
        ->name('cart.report');


        Route::get('/send-mail', 'ShoppingController@sendEmailShopping')
        ->name('cart.send_mail');





});


/* * * Routes Cron * * */
Route::group(['middleware' => 'web', 'prefix' => 'cron', 'namespace' => 'Modules\Shopping\Http\Controllers'], function() {
    Route::get('/', ['as' => 'cron.process', 'uses' => 'CronController@getProcess']);

    Route::get('/pending-orders', ['as' => 'cron.pending', 'uses' => 'CronController@processPaypalPendingOrders']);
});