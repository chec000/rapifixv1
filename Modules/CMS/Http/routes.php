<?php

use App\Helpers\TranslatableUrlPrefix;

Route::group(['middleware' => ['web', 'cms.brand_middleware'], 'prefix' => 'web_api', 'namespace' => 'Modules\CMS\Http\Controllers'], function ()
{
    Route::post('categories', ['uses' => 'ProductsApiController@getCategories']);
    Route::post('products', ['uses' => 'ProductsApiController@getProducts']);
    Route::post('global_search', ['uses' => 'SearchApiController@globalSearch']);
});

//Login Routes
Route::group(['middleware' => ['web', 'cms.brand_middleware'], 'prefix' => 'login', 'namespace' => 'Modules\CMS\Http\Controllers'], function()
{
    Route::get('/', ['as' => 'login.index','uses' => 'LoginController@getLogin']);
    Route::post('/auth', ['as' => 'login.auth', 'uses' => 'LoginController@postAuth']);
    Route::get('/logout', ['as' =>  'login.logout', 'uses' => 'LoginController@getLogout']);
    Route::post('/notification_exit', ['as' => 'login.notification_exit', 'uses' => 'LoginController@postNotificationExit']);
});


//Reset Password Routes
foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('reset-password') as $lang => $prefix) {
    Route::group(['middleware' => ['web', 'cms.brand_middleware','prefix_translate'], 'prefix' => $prefix,
        'namespace' => 'Modules\CMS\Http\Controllers'], function () use($lang, $prefix){

        $prefixOption = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('option', $lang);
        $prefixBorndate = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('birthdate', $lang);
        $prefixQuestion = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('question', $lang);
        $prefixNewpassword = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('new_password', $lang);
        $prefixLoggin = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('login', $lang);
        $prefixCode = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('code', $lang);

        //Step 1
        Route::get('/', ['as' => $prefix.'.index', 'uses' => 'ResetPasswordController@index']);
        //Step 2
        Route::get('/'.$prefixOption, ['as' => $prefix.'.'.$prefixOption, 'uses' => 'ResetPasswordController@getOption']);
        //Step 3_1
        Route::get('/'.$prefixCode, ['as' => $prefix.'.'.$prefixCode, 'uses' => 'ResetPasswordController@getVerificationCode']);
        //Step 3_2
        Route::get('/'.$prefixBorndate, ['as' => $prefix.'.'.$prefixBorndate, 'uses' => 'ResetPasswordController@getBornDate']);
        //Step 4
        Route::get('/'.$prefixQuestion, ['as' => $prefix.'.'.$prefixQuestion, 'uses' => 'ResetPasswordController@getQuestion']);
        //Step 5
        Route::get('/'.$prefixNewpassword, ['as' => $prefix.'.'.$prefixNewpassword, 'uses' => 'ResetPasswordController@getNewPassword']);
        //Step 6
        Route::get('/'.$prefixLoggin, ['as' => $prefix.'.'.$prefixLoggin, 'uses' => 'ResetPasswordController@getLogin']);
    });
}

Route::group(['middleware' => ['web', 'cms.brand_middleware'], 'prefix' => 'reset-password', 'namespace' => 'Modules\CMS\Http\Controllers'], function() {
    //Step 1
    Route::post('/validate_dist', ['as' => 'reset-password.validate_dist', 'uses' => 'ResetPasswordController@postValidateDist']);

    //Step 2
    Route::post('/method', ['as' => 'reset-password.method', 'uses' => 'ResetPasswordController@postOption']);
    Route::get('/back', ['as' => 'reset-password.back', 'uses' => 'ResetPasswordController@getBack']);

    //Step 3_1
    Route::post('/verification_code', ['as' => 'reset-password.verification_code', 'uses' => 'ResetPasswordController@postVerificationCode']);
    Route::get('/back_code', ['as' => 'reset-password.back_code', 'uses' => 'ResetPasswordController@getBackCode']);

    //Step 3_2
    Route::post('/validate_borndate', ['as' => 'reset-password.validate_borndate', 'uses' => 'ResetPasswordController@postBornDate']);
    Route::post('/parameters', ['as' =>'reset-password.parameters', 'uses' => 'ResetPasswordController@postParameters']);

    //Step 4
    Route::post('/validate_question', ['as' => 'reset-password.validate_question', 'uses' => 'ResetPasswordController@postQuestion']);

    //Step 5
    Route::post('/validate_new_password', ['as' => 'reset-password.validate_new_password', 'uses' => 'ResetPasswordController@postNewPassword']);
    Route::get('/back_new_password', ['as' => 'reset-password.back_new_password', 'uses' => 'ResetPasswordController@getBackNewPassword']);
    Route::get('/send_code', ['as' => 'reset-password.send_code', 'uses' => 'ResetPasswordController@getSendCode']);

    //Step 6
    Route::get('/info_user', ['as' => 'reset-password.info_user', 'uses' => 'ResetPasswordController@getInfoUser']);
});

Route::group(['middleware' => ['web', 'cms.brand_middleware']], function()
{
    Route::get('delete_session', function () {
        Session::flush();
        return 'session deleted';
    });
    Route::get('var_session_delete/{var}', function ($var) {
        $varParts = explode('-', $var);
        $reVar = implode('.', $varParts);
        session()->forget($reVar);
        return 'destroy = ' . $reVar;
    });
    Route::get('translate', function () {
        return mb_strtolower('ДЦ', 'UTF-8');
    });
});
Route::group(['middleware' => ['web']], function()
{
    Route::get('test_session', function () {
        $session = Session::all();
        //devolver con dd() puede provocar errores con las variables de sesion, usar con cuidado
        return response()->json($session);
    });
});

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\CMS\Http\Controllers'], function()
{

    Route::get('saveCountry/{lat?}/{lon?}', ['uses' => 'StartController@saveCountry','as'=>'save_country']);
    Route::get('getLanguages/{id}/{saveWHSession?}', ['uses' => 'StartController@getCountryLanguages','as'=>'index']);
    Route::get('saveCountryId/{id}', ['uses' => 'StartController@getCountry','as'=>'save_country_id']);
    Route::get('language/{id}', ['uses' => 'StartController@getLanguageId','as'=>'save_language_id']);
    Route::get('sessionData', ['uses' => 'StartController@sessionData','as'=>'data']);
    Route::get('existSession', ['uses' => 'StartController@existSession','as'=>'exist.session']);
    Route::get('varsMenuSession', ['uses' => 'StartController@getVariablesMenuSession','as'=>'test.varsMenuSession']);
    Route::get('getCitiesWs/{StateKey}', ['uses' => 'StartController@getCitiesWs','as'=>'getCitiesWs']);
    Route::post('setVariablesStartWH', ['uses' => 'StartController@setVariablesWareHouse','as'=>'setVariablesStartWH']);

    Route::get('testFunction', ['uses' => 'StartController@getTestFunction','as'=>'test.testFunction']);
    Route::get('getIP', ['uses' => 'StartController@getGetIP','as'=>'test.testFunction']);
    Route::post('changeCountryLang', ['uses' => 'StartController@changeCountryLanguage','as'=>'country_language.change']);

    Route::get('reportDetail', ['uses' => 'SurveyController@getReportWithDetails','as'=>'report.survey']);
    Route::get('report', ['uses' => 'SurveyController@getReport','as'=>'report.survey']);

    Route::post('getCuestionsSurvey', ['uses' => 'SurveyController@saveSurvey','as'=>'get.survey']);
    Route::post('getActiveSurvey', ['uses' => 'SurveyController@getActiveSurvey','as'=>'exist.survey']);
    Route::post('saveSurvey', ['uses' => 'SurveyController@setSurrveyToSave','as'=>'save.survey']);
    Route::post('upload_image_inspire', ['uses' => 'InspireController@uploadImage', 'as' => 'upload.inspire.image']);
    Route::post('remove_image_inspire', ['uses' => 'InspireController@removeImage', 'as' => 'remove.inspire.image']);
    Route::post('inspire/legals', ['uses' => 'InspireController@legals', 'as' => 'inspire.legals']);

    /** Complementos*/
        Route::get('contact', ['uses' => 'StartController@showContact','as'=>'complement.contact']);
        Route::get('about', ['uses' => 'StartController@showAbout','as'=>'complement.about']);

        Route::get('sendemail/news', ['uses' => 'StartController@sendEmailContact','as'=>'complement.sendEmail']);
        
        Route::get('/send-mail-contact', 'StartController@sendEmailNewContact')
        ->name('complement.send_mail.contact');

});

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\CMS\Http\Controllers'], function()
{
    # CEDIS ROUTES INIT
    Route::get('/cedis', 'CedisController@index')->name('cedis.index');
    Route::get('/cedis/{slug}', 'CedisController@detail')->name('cedis.detail')->where('slug', '[A-Za-z0-9-]+');
    # CEDIS ROUTES END
    Route::get('inicio', ['uses' => 'StartController@index','as'=>'index']);
    Route::get('index_session', ['uses' => 'StartController@session','as'=>'index_session']);

    Route::post('save_read_cookies', ['uses' => 'StartController@saveReadCookies', 'as' => 'vars.save_read_cokies']);
});

//Inspire Form
foreach (TranslatableUrlPrefix::getTranslatablePrefixesByIndex('inspire') as $lang => $prefix) {
    Route::group(['middleware' => ['web', 'cms.brand_middleware', 'prefix_translate', 'auth.eo'], 'prefix' => $prefix,
    'namespace' => 'Modules\CMS\Http\Controllers'], function () use ($prefix, $lang) {
        $prefixThanks = TranslatableUrlPrefix::getTranslatablePrefixByIndexAndLang('thanks', $lang);
        # Create form
        Route::get('/', 'InspireController@create')->name($prefix . '.' . 'index');
        # Thanks view
        Route::get('/' . $prefixThanks, 'InspireController@thanks')->name($prefix . '.' . $prefixThanks);
    });
}
Route::group(['middleware' => ['web', 'cms.brand_middleware', 'auth.eo'], 'namespace' => 'Modules\CMS\Http\Controllers'], function () {
    # Save form
    Route::post('inspire/store', 'InspireController@store')->name('inspire.store');
});

//cms routes
Route::group(['middleware' => ['web', 'cms.brand_middleware', 'exit.eo'], 'namespace' => 'Modules\CMS\Http\Controllers'], function()
{
    Route::any('{other}', ['uses' => 'CmsController@generatePage'] )->where('other', '.*');
    Route::get('uploads/{filePath}', ['middleware' => 'admin.secure_upload', 'uses' => 'CmsController@getSecureUpload'])->where('filePath', '.*');
});
