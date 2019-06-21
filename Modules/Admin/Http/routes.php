<?php

/*  === ADMIN ROUTES === */
Route::group(['middleware' => ['web','admin.auth', 'admin.langLocale'], 'prefix' => 'admin', 'as'=> 'admin.', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    /*  === GENERAL ROUTES === */

    Route::get('/', ['uses' => 'HomeController@getIndex', 'as' => 'home']); // default home route

    Route::get('logout', ['uses' => 'AuthController@logout', 'as' => 'logout']);

    Route::get('account', ['uses' => 'AccountController@getIndex', 'as' => 'account.index']);
    Route::get('account/password', ['uses' => 'AccountController@getPassword', 'as' => 'account.password']);
    Route::post('account/password', ['uses' => 'AccountController@postPassword', 'as' => 'account.password.post']);
    Route::get('account/blog', ['uses' => 'AccountController@getBlog', 'as' => 'account.blog']);
    Route::post('account/blog', ['uses' => 'AccountController@postBlog', 'as' => 'account.blog.post']);
    Route::get('account/language', ['uses' => 'AccountController@getLanguage', 'as' => 'account.language']);
    Route::post('account/language', ['uses' => 'AccountController@postLanguage', 'as' => 'account.language.post']);
    Route::post('account/page-state', ['uses' => 'AccountController@postPageState', 'as' => 'account.page-state']);
    Route::get('account/name', ['uses' => 'AccountController@getName', 'as' => 'account.name']);
    Route::post('account/name', ['uses' => 'AccountController@postName', 'as' => 'account.name.post']);

    Route::get('testSession', ['uses' => 'AccountController@testSession', 'as' => 'testSession']);

    Route::get('home', ['uses' => 'HomeController@getIndex', 'as' => 'home.index']);
    Route::get('home/logs', ['uses' => 'HomeController@getLogs', 'as' => 'home.logs']);
    Route::get('home/requests', ['uses' => 'HomeController@getRequests', 'as' => 'home.requests']);
    Route::get('home/your-requests', ['uses' => 'HomeController@getYourRequests', 'as' => 'home.your-requests']);

    /*  === CMS ROUTES === */

     /*===Brands routes==*/
    Route::get('brands',['uses'=>'BrandController@showListBrands','as'=>'brand.list']);
    Route::get('brands/addBrand/{message?}/{validacion?}',['uses'=>'BrandController@indexBrand', 'as' => 'brand.add']);
    Route::get('brands/edit/{bread_id?}/{message?}/{validacion?}',['uses'=>'BrandController@getBrand', 'as' => 'brand.editBrand']);
    Route::post('brands/edit/{bread_id}',['uses'=>'BrandController@updataBrand', 'as' => 'brand.editBrand']);
    Route::post('brands/addBrand/{message?}',['uses'=>'BrandController@saveBrand', 'as'=>'brand.add']);
    Route::post('brands/activeBrand',['uses'=>'BrandController@activeBrand','as'=> 'bread.activeBrand']);

    Route::post('brands/delete/{brand}', 'BrandController@delete')->name('brand.delete');


    Route::get('system', ['uses' => 'CMS\SystemController@getIndex', 'as' => 'system.index']);
    Route::post('system', ['uses' => 'CMS\SystemController@postIndex', 'as' => 'system.index.post']);
    Route::get('system/wp-login', ['uses' => 'CMS\SystemController@getWpLogin', 'as' => 'system.wp-login']);
    Route::get('system/search', ['uses' => 'CMS\SystemController@getSearch', 'as' => 'system.search']);
    Route::get('system/validate-db/{fix?}', ['uses' => 'CMS\SystemController@getValidateDb', 'as' => 'system.validate-db']);
    Route::get('system/upgrade/{update?}', ['uses' => 'CMS\SystemController@getUpgrade', 'as' => 'system.upgrade']);
    Route::post('system/keys/{key?}', ['uses' => 'CMS\SystemController@postKeys', 'as' => 'system.keys']);

    Route::get('pages/list', ['uses' => 'CMS\PagesController@getPages', 'as' => 'pages.list']);
    Route::post('pages/get', ['uses' => 'CMS\PagesController@getPagesByParameters', 'as' => 'pages.get.pages']);
    Route::post('pages/search', ['uses' => 'CMS\PagesController@searchPages', 'as' => 'pages.search']);
    Route::post('pages/showPreviewPage', ['uses' => 'CMS\PagesController@goToPreviewPage', 'as' => 'pages.preview']);

    Route::get('pages', ['uses' => 'CMS\PagesController@getIndex', 'as' => 'pages.index']);
    Route::get('pages/add/{pageId?}/{groupId?}', ['uses' => 'CMS\PagesController@getAdd', 'as' => 'pages.add']);
    Route::post('pages/add/{pageId?}/{groupId?}', ['uses' => 'CMS\PagesController@postAdd', 'as' => 'pages.add.post']);
    Route::get('pages/edit/{pageId}/{version?}/{language?}', ['uses' => 'CMS\PagesController@getEdit', 'as' => 'pages.edit'])->where(['pageId' => '\w+', 'version' => '\w+']);
    Route::post('pages/edit/{pageId}/{version?}/{language?}', ['uses' => 'CMS\PagesController@postEdit', 'as' => 'pages.edit.post']);
    Route::post('pages/sort', ['uses' => 'CMS\PagesController@postSort', 'as' => 'pages.sort']);
    Route::post('pages/delete/{pageId}', ['uses' => 'CMS\PagesController@postDelete', 'as' => 'pages.delete']);
    Route::post('pages/versions/{pageId}', ['uses' => 'CMS\PagesController@postVersions', 'as' => 'pages.versions']);
    Route::post('pages/version-schedule/{pageId}', ['uses' => 'CMS\PagesController@postVersionSchedule', 'as' => 'pages.version-schedule']);
    Route::post('pages/version-rename/{pageId}', ['uses' => 'CMS\PagesController@postVersionRename', 'as' => 'pages.version-rename']);
    Route::post('pages/version-publish/{pageId}', ['uses' => 'CMS\PagesController@postVersionPublish', 'as' => 'pages.version-publish']);
    Route::post('pages/requests/{pageId}', ['uses' => 'CMS\PagesController@postRequests', 'as' => 'pages.requests']);
    Route::post('pages/request-publish/{pageId}', ['uses' => 'CMS\PagesController@postRequestPublish', 'as' => 'pages.request-publish']);
    Route::post('pages/request-publish-action/{pageId}', ['uses' => 'CMS\PagesController@postRequestPublishAction', 'as' => 'pages.request-publish-action']);
    Route::get('pages/tinymce-page-list', ['uses' => 'CMS\PagesController@getTinymcePageList', 'as' => 'pages.tinymce-page-list']);

    Route::get('groups/pages/{groupId}', ['uses' => 'CMS\GroupsController@getPages', 'as' => 'groups.pages']);
    Route::get('groups/edit/{groupId}', ['uses' => 'CMS\GroupsController@getEdit', 'as' => 'groups.edit']);
    Route::post('groups/edit/{groupId}', ['uses' => 'CMS\GroupsController@postEdit', 'as' => 'groups.edit.post']);

    Route::get('menus', ['uses' => 'CMS\MenusController@getIndex', 'as' => 'menus.index']);
    Route::get('menus/filters', ['uses' => 'CMS\MenusController@getIndex', 'as' => 'menus.index.filters']);
    Route::post('menus/add', ['uses' => 'CMS\MenusController@postAdd', 'as' => 'menus.add']);
    Route::post('menus/delete/{itemId}', ['uses' => 'CMS\MenusController@postDelete', 'as' => 'menus.delete']);
    Route::post('menus/sort', ['uses' => 'CMS\MenusController@postSort', 'as' => 'menus.sort']);
    Route::post('menus/get-levels', ['uses' => 'CMS\MenusController@postGetLevels', 'as' => 'menus.get-levels']);
    Route::post('menus/save-levels', ['uses' => 'CMS\MenusController@postSaveLevels', 'as' => 'menus.save-levels']);
    Route::post('menus/rename', ['uses' => 'CMS\MenusController@postRename', 'as' => 'menus.rename']);
    Route::post('menus/renamev2', ['uses' => 'CMS\MenusController@postRenameV2', 'as' => 'menus.renamev2']);

    Route::post('menus/hide-page', ['uses' => 'CMS\MenusController@postHidePage', 'as' => 'menus.hide-page']);
    Route::get('menus/testStats', ['uses' => 'CMS\MenusController@getDataStatsMenus', 'as' => 'menus.testStats']);

    Route::get('blocks/testStats', ['uses' => 'CMS\BlocksController@getDataStatsBlocks', 'as' => 'blocks.testStats']);
    Route::get('blocks', ['uses' => 'CMS\BlocksController@getIndex', 'as' => 'blocks.index']);
    Route::post('blocks/filters', ['uses' => 'CMS\BlocksController@getIndex', 'as' => 'blocks.index.filters']);
    Route::post('blocks', ['uses' => 'CMS\BlocksController@postIndex', 'as' => 'blocks.index.post']);

    Route::post('selecFiltersUpdate', ['uses' => 'CMS\BlocksController@postChangeSelectFilter', 'as' => 'blocks.selecFiltersUpdate']);

    Route::get('filemanager', ['uses' => 'CMS\FilemanagerController@getIndex', 'as' => 'filemanager.index']);

    Route::get('redirects', ['uses' => 'CMS\RedirectsController@getIndex', 'as' => 'redirects.index']);
    Route::post('redirects', ['uses' => 'CMS\RedirectsController@postIndex', 'as' => 'redirects.index.post']);
    Route::get('redirects/url-decode', ['uses' => 'CMS\RedirectsController@getUrlDecode', 'as' => 'redirects.url-decode']);
    Route::post('redirects/edit', ['uses' => 'CMS\RedirectsController@postEdit', 'as' => 'redirects.edit']);
    Route::get('redirects/import', ['uses' => 'CMS\RedirectsController@getImport', 'as' => 'redirects.import']);

    Route::get('themes', ['uses' => 'CMS\ThemesController@getIndex', 'as' => 'themes.index']);
    Route::get('themes/list', ['uses' => 'CMS\ThemesController@getList', 'as' => 'themes.list']);
    Route::post('themes/manage', ['uses' => 'CMS\ThemesController@postManage', 'as' => 'themes.manage']);
    Route::get('themes/export/{themeId}/{withPageData?}', ['uses' => 'CMS\ThemesController@getExport', 'as' => 'themes.export'])->where(['themeId' => '\w+', 'withPageData' => '\w+']);
    Route::get('themes/beacons', ['uses' => 'CMS\ThemesController@getBeacons', 'as' => 'themes.beacons']);
    Route::post('themes/beacons', ['uses' => 'CMS\ThemesController@postBeacons', 'as' => 'themes.beacons.post']);
    Route::get('themes/edit/{themeId}', ['uses' => 'CMS\ThemesController@getEdit', 'as' => 'themes.edit']);
    Route::post('themes/edit/{themeId}', ['uses' => 'CMS\ThemesController@postEdit', 'as' => 'themes.edit.post']);
    Route::post('themes/loadtemplatefile', ['uses' => 'CMS\ThemesController@loadTemplateFile', 'as' => 'themes.edit.loadfile']);
    Route::get('themes/update/{themeId}', ['uses' => 'CMS\ThemesController@getUpdate', 'as' => 'themes.update']);
    Route::post('themes/update/{themeId}', ['uses' => 'CMS\ThemesController@postUpdate', 'as' => 'themes.update.post']);
    Route::get('themes/forms/{template?}', ['uses' => 'CMS\ThemesController@getForms', 'as' => 'themes.forms']);
    Route::post('themes/forms/{template}', ['uses' => 'CMS\ThemesController@postForms', 'as' => 'themes.forms.post']);
    Route::get('themes/selects/{blockId?}/{import?}', ['uses' => 'CMS\ThemesController@getSelects', 'as' => 'themes.selects'])->where(['blockId' => '\w+', 'import' => '\w+']);
    Route::post('themes/selects/{blockId}/{import?}', ['uses' => 'CMS\ThemesController@postSelects', 'as' => 'themes.selects.post'])->where(['blockId' => '\w+', 'import' => '\w+']);

    Route::get('gallery/list/{pageId?}', ['uses' => 'CMS\GalleryController@getList', 'as' => 'gallery.list']);
    Route::get('gallery/edit/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@getEdit', 'as' => 'gallery.edit'])->where(['pageId' => '\w+', 'blockId' => '\w+']);
    Route::get('gallery/update/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@getUpdate', 'as' => 'gallery.update'])->where(['pageId' => '\w+', 'blockId' => '\w+']);
    Route::post('gallery/caption/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@postCaption', 'as' => 'gallery.caption'])->where(['pageId' => '\w+', 'blockId' => '\w+']);
    Route::post('gallery/sort/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@postSort', 'as' => 'gallery.sort'])->where(['pageId' => '\w+', 'blockId' => '\w+']);;
    Route::post('gallery/update/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@postUpdate', 'as' => 'gallery.update'])->where(['pageId' => '\w+', 'blockId' => '\w+']);
    Route::delete('gallery/update/{pageId?}/{blockId?}', ['uses' => 'CMS\GalleryController@deleteUpdate', 'as' => 'gallery.update.post'])->where(['pageId' => '\w+', 'blockId' => '\w+']);

    Route::get('forms/list/{pageId?}', ['uses' => 'CMS\FormsController@getList', 'as' => 'forms.list']);
    Route::get('forms/submissions/{pageId?}/{blockId?}', ['uses' => 'CMS\FormsController@getSubmissions', 'as' => 'forms.submissions'])->where(['pageId' => '\w+', 'blockId' => '\w+']);
    Route::get('forms/csv/{pageId?}/{blockId?}', ['uses' => 'CMS\FormsController@getCsv', 'as' => 'forms.csv'])->where(['pageId' => '\w+', 'blockId' => '\w+']);

    Route::post('backups/undo', ['uses' => 'CMS\BackupsController@postUndo', 'as' => 'backups.undo']);

    Route::post('repeaters', ['uses' => 'CMS\RepeatersController@postIndex', 'as' => 'repeaters.index']);

    Route::get('search', ['uses' => 'CMS\SearchController@getIndex', 'as' => 'search.index']);

    Route::get('import/wp-blog', ['uses' => 'CMS\ImportWpController@getImport', 'as' => 'wpimport']);
    Route::post('import/wp-blog', ['uses' => 'CMS\ImportWpController@postImport', 'as' => 'wpimport.post']);

    Route::post('adminsearch', ['uses' => 'CMS\AdminSearchController@search', 'as' => 'adminsearch.index']);

    /*  === ACL ROUTES === */

    Route::get('users', ['uses' => 'ACL\UsersController@getIndex', 'as' => 'users.index']);
    Route::get('users/edit/{userId?}/{action?}', ['uses' => 'ACL\UsersController@getEdit', 'as' => 'users.edit'])->where(['userId' => '\w+', 'action' => '\w+']);
    Route::post('users/edit/{userId?}/{action?}', ['uses' => 'ACL\UsersController@postEdit', 'as' => 'users.edit.post'])->where(['userId' => '\w+', 'action' => '\w+']);
    Route::get('users/add', ['uses' => 'ACL\UsersController@getAdd', 'as' => 'users.add']);
    Route::post('users/add', ['uses' => 'ACL\UsersController@postAdd', 'as' => 'users.add.post']);
    Route::post('users/delete/{userId?}', ['uses' => 'ACL\UsersController@postDelete', 'as' => 'users.delete']);

    Route::post('selecFiltersBrandsUpdate', ['uses' => 'ACL\UsersController@postChangeSelectBrandFilter', 'as' => 'users.selecFiltersBrandsUpdate']);
    Route::post('users/remove/{user}', 'ACL\UsersController@remove')->name('users.remove');

    /*  === ROLES ROUTES === */
    Route::get('roles', ['uses' => 'ACL\RolesController@getIndex', 'as' => 'roles.index']);
    Route::post('roles/actions/{roleId?}', ['uses' => 'ACL\RolesController@postActions', 'as' => 'roles.actions']);
    Route::post('roles/add', ['uses' => 'ACL\RolesController@postAdd', 'as' => 'roles.add']);
    Route::get('roles/editTranslates/{roleId}', ['uses' => 'ACL\RolesController@getEditRoleTranslation', 'as' => 'roles.edit.translates']);
    Route::post('roles/editRole', ['uses' => 'ACL\RolesController@postEditRoleTranslations', 'as' => 'roles.editRole']);
    Route::post('roles/delete', ['uses' => 'ACL\RolesController@postDelete', 'as' => 'roles.delete']);
    Route::post('roles/active', ['uses' => 'ACL\RolesController@postActivated', 'as' => 'roles.active']);
    Route::post('roles/edit', ['uses' => 'ACL\RolesController@postEdit', 'as' => 'roles.edit']);
    Route::get('roles/pages/{roleId}', ['uses' => 'ACL\RolesController@getPages', 'as' => 'roles.pages']);
    Route::post('roles/pages/{roleId}', ['uses' => 'ACL\RolesController@postPages', 'as' => 'roles.pages.post']);

    /*  === LANGUAGES ROUTES === */
    Route::get('languages', ['uses' => 'LanguagesController@getIndex', 'as' => 'languages.list']);
    Route::get('languages/add', ['uses' => 'LanguagesController@getAdd', 'as' => 'languages.add']);
    Route::post('languages/add', ['uses' => 'LanguagesController@postAdd', 'as' => 'languages.add.post']);
    Route::get('languages/edit/{langId?}', ['uses' => 'LanguagesController@getEdit', 'as' => 'languages.edit'])->where(['langId' => '\w+']);
    Route::post('languages/edit/{langId?}/{action?}', ['uses' => 'LanguagesController@postEdit', 'as' => 'languages.edit.post'])->where(['langId' => '\w+', 'action' => '\w+']);

    Route::post('languages/delete/{lang}', 'LanguagesController@delete')->name('languages.delete');
    /*====Menus Routes===*/

     Route::get('menuAdmin/add/{mensage?}', ['uses' => 'MenusController@indexMenu', 'as' => 'menuadmin.add']);
     Route::get('menuAdmin/update/{id_menu}/{mensage?}', ['uses' => 'MenusController@getMenu', 'as' => 'menuadmin.update']);
     Route::post('menuAdmin/update/{id_menu}', ['uses' => 'MenusController@updateMenu', 'as' => 'menuadmin.update']);
     Route::post('menuAdmin/add', ['uses' => 'MenusController@saveMenu', 'as' => 'menuadmin.add']);
     Route::post('menuAdmin/order', ['uses' => 'MenusController@getMenuById', 'as' => 'menuadmin.order']);
     Route::get('menuAdmin', ['uses' => 'MenusController@getListMenus', 'as' => 'menuadmin.list']);
     Route::post('menuAdmin/active', ['uses' => 'MenusController@activeMenu', 'as' => 'menuadmin.active']);

      /*===Controllers Routes===*/
       Route::get('controllers/add/{message?}', ['uses' => 'ControlController@getIndex', 'as' => 'controller.add']);
       Route::get('controllers', ['uses' => 'ControlController@getListController', 'as' => 'controller.list']);
       Route::post('controllers/active', ['uses' => 'ControlController@activateController', 'as' => 'controller.active']);
       Route::get('controllers/update/{controller_id}/{mesage?}', ['uses' => 'ControlController@getController', 'as' => 'controller.update']);
       Route::post('controllers/update/{controller_id}', ['uses' => 'ControlController@updateController', 'as' => 'controller.update']);
       Route::post('controllers/add', ['uses' => 'ControlController@saveController', 'as' => 'controller.add']);

       /*====Actions Routes ===*/
       Route::get('actions/add/{message?}', ['uses' => 'ActionController@indexFunction', 'as' => 'action.add']);
       Route::get('actions', ['uses' => 'ActionController@listFunction', 'as' => 'action.list']);
       Route::post('actions/active', ['uses' => 'ActionController@activateFunction', 'as' => 'action.active']);
       Route::get('actions/update/{controller_id}/{mesage?}', ['uses' => 'ActionController@getFunction', 'as' => 'action.update']);
       Route::post('actions/update/{controller_id}', ['uses' => 'ActionController@updateFunction', 'as' => 'action.update']);
       Route::post('actions/add', ['uses' => 'ActionController@saveFunction', 'as' => 'action.add']);

       /**/
       Route::get('templates/add/{message?}', ['uses' => 'TemplateController@indexTemplate', 'as' => 'template.add']);
        Route::post('templates/add', ['uses' => 'TemplateController@addTemplate', 'as' => 'template.add.save']);
        Route::get('templates', ['uses' => 'TemplateController@listTemplates', 'as' => 'template.list']);
        Route::post('templates/active', ['uses' => 'TemplateController@activateTemplate', 'as' => 'template.active']);
        Route::get('templates/update/{template_id}/{mesage?}', ['uses' => 'TemplateController@getTemplate', 'as' => 'template.update']);
        Route::post('templates/update/{template_id}', ['uses' => 'TemplateController@updateTemplate', 'as' => 'template.update']);

    /*  === COUNTRIES ROUTES === */
    Route::get('countries', ['uses' => 'CountriesController@getIndex', 'as' => 'countries.list']);
    Route::get('countries/add/{mensage?}/{validacion?}', ['uses' => 'CountriesController@getAdd', 'as' => 'countries.add']);
    Route::post('countries/add', ['uses' => 'CountriesController@postAdd', 'as' => 'countries.add']);
    Route::get('countries/edit/{countryId?}/{mensage?}', ['uses' => 'CountriesController@getEdit', 'as' => 'countries.edit'])->where(['countryId' => '\w+']);
    Route::post('countries/edit/{countryId?}', ['uses' => 'CountriesController@postEdit', 'as' => 'countries.edit']);
    Route::post('countries/active',['uses' => 'CountriesController@activeCountry', 'as' => 'countries.active']);

    Route::post('countries/delete/{country}', 'CountriesController@delete')->name('countries.delete');

    /*  === VARS SETTINGS ROUTES === */
    Route::get('vars/', ['uses' => 'VarsSettingController@getSettings', 'as' => 'vars.list']);
    Route::post('vars', ['uses' => 'VarsSettingController@postSettings', 'as' => 'vars.save']);
    Route::post('vars/delete', ['uses' => 'VarsSettingController@deleteSettings', 'as' => 'vars.delete']);
    Route::get('load_traslate', ['uses' => 'VarsSettingController@uploadFileSVG', 'as' => 'vars.saveFile']);

    /*KIOSCO SETTINGS */
    Route::get('kiosco', ['uses' => 'KioscoController@index', 'as' => 'kiosco.index']);

    Route::get('kiosco/crateBanner', 'KioscoController@createBanner')->name('kiosco.createBanner');
    Route::get('kiosco/editBanner/{id_banner}', 'KioscoController@editBanner')->name('kiosco.editBanner');
    Route::post('kiosco/addBanners', 'KioscoController@storeBanners')->name('kiosco.addBanners');
    Route::post('kiosco/switchBanner', 'KioscoController@changeStatusBanner')->name('kiosco.changeStatusBanner');
    Route::put('kiosco/banner', 'KioscoController@updateBanner')->name('kiosco.updateBanner');
    Route::delete('kiosco/banner', 'KioscoController@destroyBanner')->name('kiosco.destroyBanner');
    /*KIOSCO TERMS */
    Route::resource('kiosco/disclaimer', 'Kiosco\DisclaimerController', ['names' => [
        'index'   => 'kiosco.disclaimer.index',
        'store'   => 'kiosco.disclaimer.store',
        'create'  => 'kiosco.disclaimer.create',
        'update'  => 'kiosco.disclaimer.update',
        'edit'    => 'kiosco.disclaimer.edit',
        'destroy' => 'kiosco.disclaimer.destroy'
    ]]);
    Route::post('kiosco/disclaimer/change-status', 'Kiosco\DisclaimerController@changeStatus')->name('kiosco.disclaimer.changeStatus');


    Route::resource('products', 'Shopping\ProductsController');
    Route::post('/products/change-status', ['as'=>'products.changeStatus','uses'=>'Shopping\ProductsController@changeStatus']);

    Route::post('/products/upload-file', ['as'=>'products.uploadfile','uses'=>'Shopping\ProductsController@uploadFile']);
    //Route::post('/distributors-pool/upload-file', 'DistributorsPoolController@uploadFile')->name('pool.uploadfile');
    Route::post('/products/obtain', ['as'=>'products.obtain','uses'=>'Shopping\ProductsController@obtainComplementary']);
    Route::post('/products/obtainSelected', ['as'=>'products.obtainselected','uses'=>'Shopping\ProductsController@obtainSelectedComplementary']);
    Route::post('/products/delete/{product}', ['as'=>'products.destroy','uses'=>'Shopping\ProductsController@delete']);
    Route::post('/products/getProducts', ['as' => 'products.getproducts', 'uses' => 'Shopping\ProductsController@getProductsByBrandAndCountry']);
    Route::post('/products/existSKU', ['as' => 'products.existSKU', 'uses' => 'Shopping\ProductsController@existSKU']);

    Route::get('/products/warehouses/{id}', ['as'=>'products.listWarehouses','uses'=>'Shopping\ProductsController@listWarehouses']);
    Route::post('/products/warehouses/create', ['as'=>'products.warehousecreate','uses'=>'Shopping\ProductsController@warehousesCreate']);
    Route::post('/products/warehouses/list', ['as'=>'products.warehouselist','uses'=>'Shopping\ProductsController@warehousesList']);
    Route::post('/products/warehouses/off', ['as'=>'products.warehouseoff','uses'=>'Shopping\ProductsController@warehousesOff']);
    Route::post('/products/warehouses/on', ['as'=>'products.warehouseon','uses'=>'Shopping\ProductsController@warehousesOn']);
    Route::post('/products/warehouses/delete', ['as'=>'products.warehousedelete','uses'=>'Shopping\ProductsController@warehousesDelete']);

    //Estatus Orders Routes
    Route::get('estatusOrders',['uses'=>'Shopping\OrderEstatusController@showListOrderEstatus','as'=>'orderestatus.list']);
    Route::get('estatusOrders/addEstatus/{message?}/{validacion?}',['uses'=>'Shopping\OrderEstatusController@indexOrderEstatus', 'as' => 'orderestatus.add']);
    Route::get('estatusOrders/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\OrderEstatusController@getOrderEstatus', 'as' => 'orderestatus.editOe']);
    Route::post('estatusOrders/edit/{estatus_id}',['uses'=>'Shopping\OrderEstatusController@updateOrderEstatus', 'as' => 'orderestatus.edit']);
    Route::post('estatusOrders/addEstatus/{message?}',['uses'=>'Shopping\OrderEstatusController@saveOrderStatus', 'as'=>'orderestatus.add']);
    Route::post('estatusOrders/activeEstatus',['uses'=>'Shopping\OrderEstatusController@activeOrderStatus','as'=> 'orderestatus.active']);
    Route::post('estatusOrders/deleteEstatus',['uses'=>'Shopping\OrderEstatusController@deleteOrderStatus','as'=> 'orderestatus.delete']);
    Route::post('estatusOrders/countriesReference',['uses'=>'Shopping\OrderEstatusController@CountriesReference','as'=> 'orderestatus.countries']);
    Route::post('estatusOrders/updateCountries',['uses'=>'Shopping\OrderEstatusController@updatesCountries','as'=> 'orderestatus.updatecountries']);

    //Registration references
    Route::get('registrationReferences',['uses'=>'Shopping\RegistrationReferencesController@showListRegistrationReferences','as'=>'registrationreferences.list']);
    Route::get('registrationReferences/addReference/{message?}/{validacion?}',['uses'=>'Shopping\RegistrationReferencesController@indexRegistrationReferences', 'as' => 'registrationreferences.add']);
    Route::get('registrationReferences/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\RegistrationReferencesController@getRegistrationReferences', 'as' => 'registrationreferences.edit']);
    Route::post('registrationReferences/edit/{estatus_id}',['uses'=>'Shopping\RegistrationReferencesController@updateRegistrationReferences', 'as' => 'registrationreferences.edit']);
    Route::post('registrationReferences/addReference/{message?}',['uses'=>'Shopping\RegistrationReferencesController@saveRegistrationReferences', 'as'=>'registrationreferences.add']);
    Route::post('registrationReferences/activeReference',['uses'=>'Shopping\RegistrationReferencesController@activeRegistrationReferences','as'=> 'registrationreferences.active']);
    Route::post('registrationReferences/deleteReference',['uses'=>'Shopping\RegistrationReferencesController@deleteRegistrationReferences','as'=> 'registrationreferences.delete']);
    Route::post('registrationReferences/countriesReference',['uses'=>'Shopping\RegistrationReferencesController@CountriesReference','as'=> 'registrationreferences.countries']);
    Route::post('registrationReferences/updateCountries',['uses'=>'Shopping\RegistrationReferencesController@updatesCountries','as'=> 'registrationreferences.updatecountries']);
    //SecurityQuestions changed
    Route::get('securityQuestions',['uses'=>'Shopping\SecurityQuestionsController@showListSecurityQuestions','as'=>'securityquestions.list']);
    Route::get('securityQuestions/addQuestion/{message?}/{validacion?}',['uses'=>'Shopping\SecurityQuestionsController@indexSecurityQuestions', 'as' => 'securityquestions.add']);
    Route::get('securityQuestions/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\SecurityQuestionsController@getSecurityQuestions', 'as' => 'securityquestions.edit']);
    Route::post('securityQuestions/edit/{estatus_id}',['uses'=>'Shopping\SecurityQuestionsController@updateSecurityQuestions', 'as' => 'securityquestions.edit']);
    Route::post('securityQuestions/addQuestion/{message?}',['uses'=>'Shopping\SecurityQuestionsController@saveSecurityQuestions', 'as'=>'securityquestions.add']);
    Route::post('securityQuestions/activeQuestion',['uses'=>'Shopping\SecurityQuestionsController@activeSecurityQuestions','as'=> 'securityquestions.active']);
    Route::post('securityQuestions/deleteQuestion',['uses'=>'Shopping\SecurityQuestionsController@deleteSecurityQuestions','as'=> 'securityquestions.delete']);
    Route::post('securityQuestions/countriesQuestions',['uses'=>'Shopping\SecurityQuestionsController@CountriesQuestions','as'=> 'securityquestions.countries']);
    Route::post('securityQuestions/updateCountries',['uses'=>'Shopping\SecurityQuestionsController@updatesCountries','as'=> 'securityquestions.updatecountries']);


    //Registration parameters
    Route::get('registrationParameters',['uses'=>'Shopping\RegistrationParametersController@showListRegistrationParameters','as'=>'registrationparameters.list']);
    Route::get('registrationParameters/addParameter/{message?}/{validacion?}',['uses'=>'Shopping\RegistrationParametersController@indexRegistrationParameters', 'as' => 'registrationparameters.add']);
    Route::get('registrationParameters/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\RegistrationParametersController@getRegistrationParameters', 'as' => 'registrationparameters.edit']);
    Route::post('registrationParameters/edit/{estatus_id}',['uses'=>'Shopping\RegistrationParametersController@updateRegistrationParameters', 'as' => 'registrationparameters.edit']);
    Route::post('registrationParameters/addParameter/{message?}',['uses'=>'Shopping\RegistrationParametersController@saveRegistrationParameters', 'as'=>'registrationparameters.add']);
    Route::post('registrationParameters/activeParameter',['uses'=>'Shopping\RegistrationParametersController@activeRegistrationParameters','as'=> 'registrationparameters.active']);
    Route::post('registrationParameters/deleteParameter',['uses'=>'Shopping\RegistrationParametersController@deleteRegistrationParameters','as'=> 'registrationparameters.delete']);


    //Blacklist
    Route::get('Blacklists',['uses'=>'Shopping\BlacklistController@showListBlacklist','as'=>'blacklist.list']);
    Route::get('Blacklists/addEo/{message?}/{validacion?}',['uses'=>'Shopping\BlacklistController@indexBlacklist', 'as' => 'blacklist.add']);
    Route::get('Blacklists/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\BlacklistController@getBlacklist', 'as' => 'blacklist.edit']);
    Route::post('Blacklists/edit/{estatus_id}',['uses'=>'Shopping\BlacklistController@updateBlacklist', 'as' => 'blacklist.edit']);
    Route::post('Blacklists/addEo/{message?}',['uses'=>'Shopping\BlacklistController@saveBlacklist', 'as'=>'blacklist.add']);
    Route::post('Blacklists/activeEo',['uses'=>'Shopping\BlacklistController@activeBlacklist','as'=> 'blacklist.active']);
    Route::post('Blacklists/deleteEo',['uses'=>'Shopping\BlacklistController@deleteBlacklist','as'=> 'blacklist.delete']);


    //Banks
    Route::get('banks',['uses'=>'Shopping\BanksController@showListBanks','as'=>'banks.list']);
    Route::get('banks/addBank/{message?}/{validacion?}',['uses'=>'Shopping\BanksController@indexBanks', 'as' => 'banks.add']);
    Route::get('banks/edit/{estatus_id?}/{message?}/{validacion?}',['uses'=>'Shopping\BanksController@getBanks', 'as' => 'banks.edit']);
    Route::post('banks/edit/{estatus_id}',['uses'=>'Shopping\BanksController@updateBanks', 'as' => 'banks.edit']);
    Route::post('banks/addBank/{message?}',['uses'=>'Shopping\BanksController@saveBanks', 'as'=>'banks.add']);
    Route::post('banks/activeBank',['uses'=>'Shopping\BanksController@activeBanks','as'=> 'banks.active']);
    Route::post('banks/deleteBank',['uses'=>'Shopping\BanksController@deleteBanks','as'=> 'banks.delete']);
    Route::post('banks/countriesBank',['uses'=>'Shopping\BanksController@CountriesBank','as'=> 'banks.countries']);
    Route::post('banks/updateCountries',['uses'=>'Shopping\BanksController@updatesCountries','as'=> 'banks.updatecountries']);

    //Orders
    Route::get('orders',['uses'=>'Shopping\OrderController@showOrders','as'=>'orders.list']);
    Route::get('orders/detail/{order_id?}/{message?}/{validacion?}',['uses'=>'Shopping\OrderController@getOrdersDetail', 'as' => 'orders.detail']);
    Route::get('orders/logs/{order_id}',['uses'=>'Shopping\OrderController@getLogDetail', 'as' => 'orders.logs']);
    Route::post('orders/edit/{order_id}',['uses'=>'Shopping\OrderController@updateOrders', 'as' => 'orders.edit']);
    Route::post('orders/changestatus',['uses'=>'Shopping\OrderController@activeOrders','as'=> 'orders.active']);
    Route::post('orders/removeProduct',['uses'=>'Shopping\OrderController@removeProduct','as'=> 'orders.remove']);
    Route::post('orders/savenew',['uses'=>'Shopping\OrderController@saveNew','as'=> 'orders.savenew']);

    //customers
    Route::get('customers',['uses'=>'Shopping\CustomerController@showCustomers','as'=>'customers.list']);
    Route::get('customers/detail/{id?}/{message?}/{validacion?}',['uses'=>'Shopping\CustomerController@getCustomersDetail', 'as' => 'customers.detail']);


    Route::resource('categories', 'Shopping\CategoriesController');
    Route::post('/categories/change-status', ['as'=>'categories.changeStatus','uses'=>'Shopping\CategoriesController@changeStatus']);
    Route::post('/categories/getProducts', ['as' => 'categories.getproducts', 'uses' => 'Shopping\CategoriesController@getProductsByBrandAndCountry']);
    Route::post('/categories/getCountriesByBrand', ['as' => 'categories.getcountries', 'uses' => 'Shopping\CategoriesController@getCountriesByBrandAndUser']);

    Route::resource('systems', 'Shopping\SystemsController');
    #Route::post('/systems/off', ['as'=>'systems.off','uses'=>'Shopping\SystemsController@off']);
    #Route::post('/systems/on', ['as'=>'systems.on','uses'=>'Shopping\SystemsController@on']);
    Route::post('/systems/change-status', ['as'=>'systems.changeStatus','uses'=>'Shopping\SystemsController@changeStatus']);

    Route::resource('warehouses', 'Shopping\WarehousesController');
    Route::post('/warehouses/change-status', ['as'=>'warehouses.changeStatus','uses'=>'Shopping\WarehousesController@changeStatus']);

    Route::resource('productRestrictions', 'Shopping\ProductRestrictionsController');
    Route::post('/productRestrictions/off', ['as'=>'productRestrictions.off','uses'=>'Shopping\ProductRestrictionsController@off']);
    Route::post('/productRestrictions/on', ['as'=>'productRestrictions.on','uses'=>'Shopping\ProductRestrictionsController@on']);

    Route::resource('filters', 'Shopping\FiltersController');
    Route::post('/filters/change-status', ['as'=>'filters.changeStatus','uses'=>'Shopping\FiltersController@changeStatus']);

    Route::get('/filters/categories/{code}/{idCountry?}/{idCategory?}', ['as'=>'filters.categoriesshow','uses'=>'Shopping\FiltersController@filtersShow']);
    Route::post('/filters/categories/create', ['as'=>'filters.categoriescreate','uses'=>'Shopping\FiltersController@filtersCreate']);
    Route::post('/filters/categories/delete', ['as'=>'filters.categoriesdelete','uses'=>'Shopping\FiltersController@filtersDelete']);

    Route::get('/bulk-load', ['as'=>'load.index','uses'=>'Shopping\BulkLoadController@index']);
    Route::post('/bulk-load/category', ['as'=>'load.category','uses'=>'Shopping\BulkLoadController@category']);
    Route::post('/bulk-load/product', ['as'=>'load.product','uses'=>'Shopping\BulkLoadController@product']);
    Route::post('/bulk-load/related', ['as'=>'load.related','uses'=>'Shopping\BulkLoadController@related']);
    Route::post('/bulk-load/system', ['as'=>'load.system','uses'=>'Shopping\BulkLoadController@system']);
    Route::post('/bulk-load/products-by-warehouse', ['as'=>'load.warehouses','uses'=>'Shopping\BulkLoadController@uploadProductsByWarehouse']);

    Route::get('/reports', ['as'=>'report.index','uses'=>'Shopping\ReportsController@index']);
    Route::get('/reports/orders', ['as'=>'report.orders','uses'=>'Shopping\ReportsController@orders']);
    Route::post('/reports/orders', ['as'=>'report.ordersgenerate','uses'=>'Shopping\ReportsController@getOrders']);
    Route::get('/reports/survey-report', ['as'=>'report.surveyindex','uses'=>'Shopping\SurveyReportsController@index']);
     Route::post('/reports/survey-report', ['as'=>'report.surveygenerate','uses'=>'Shopping\SurveyReportsController@generateReport']);
     

    //Legals
    Route::resource('legals', 'Shopping\LegalsController');
    Route::post('/legals/change-status', ['as'=>'legals.changeStatus','uses'=>'Shopping\LegalsController@changeStatus']);
    Route::post('/legals/getCountriesByBrand', ['as' => 'legals.getcountries', 'uses' => 'Shopping\LegalsController@getCountriesByBrandAndUser']);
    Route::get('/legals/edit/{type?}/',['uses'=>'Shopping\LegalsController@edit', 'as' => 'legals.edit']);
    Route::post('/legals/update/{type}/',['uses'=>'Shopping\LegalsController@update', 'as' => 'legals.update']);


    /*  === PROMO PRODS === */
    Route::resource('promoprods', 'Shopping\PromoProdsController');
    Route::post('/promoprods/change-status', ['as'=>'promoprods.changeStatus','uses'=>'Shopping\PromoProdsController@changeStatus']);
    Route::post('/promoprods/getCountriesByBrand', ['as' => 'promoprods.getcountries', 'uses' => 'Shopping\PromoProdsController@getCountriesByBrandAndUser']);
    Route::get('/promoprods/edit/{id?}/',['uses'=>'Shopping\PromoProdsController@edit', 'as' => 'promoprods.edit']);
    Route::post('/promoprods/update/',['uses'=>'Shopping\PromoProdsController@update', 'as' => 'promoprods.update']);
    Route::post('/promoprods/saveProdPromo/',['uses'=>'Shopping\PromoProdsController@saveProdPromo', 'as' => 'promoprods.saveProdPromo']);
    Route::post('/promoprods/updateProdPromo/',['uses'=>'Shopping\PromoProdsController@updateProdPromo', 'as' => 'promoprods.updateProdPromo']);

    //COnfirmation banners
    Route::resource('confirmationbanners', 'Shopping\ConfirmationBannerController');
    Route::post('/confirmationbanners/change-status', ['as'=>'confirmationbanners.changeStatus','uses'=>'Shopping\ConfirmationBannerController@changeStatus']);
    Route::post('/confirmationbanners/getCountriesByBrand', ['as' => 'confirmationbanners.getcountries', 'uses' => 'Shopping\ConfirmationBannerController@getCountriesByBrandAndUser']);
    Route::get('/confirmationbanners/edit/{global_name?}/',['uses'=>'Shopping\ConfirmationBannerController@edit', 'as' => 'confirmationbanners.edit']);
    Route::post('/confirmationbanners/update/{global_name}/',['uses'=>'Shopping\ConfirmationBannerController@update', 'as' => 'confirmationbanners.update']);

    # CEDIS ROUTES INIT
    Route::get('/cedis', 'CedisController@index')->name('cedis.index');
    Route::get('/cedis/add', 'CedisController@add')->name('cedis.add');
    Route::get('/cedis/edit/{cedis}', 'CedisController@edit')->name('cedis.edit');

    Route::post('/cedis/save', 'CedisController@save')->name('cedis.save');
    Route::post('/cedis/update/{cedis}', 'CedisController@update')->name('cedis.update');
    Route::post('/cedis/delete/{cedis}', 'CedisController@delete')->name('cedis.delete');

    Route::post('/cedis/change-status/', 'CedisController@changeStatus')->name('cedis.changeStatus');

    Route::post('/cedis/getStates', 'CedisController@getStates')->name('cedis.getStates');
    Route::post('/cedis/getCities', 'CedisController@getCities')->name('cedis.getCities');
    # CEDIS ROUTES END

    # DISTRIBUTORS POOL ROUTES INIT
    Route::get('/distributors-pool', 'DistributorsPoolController@index')->name('pool.index');
    Route::get('/distributors-pool/add', 'DistributorsPoolController@add')->name('pool.add');
    Route::get('/distributors-pool/edit/{code}/{country}', 'DistributorsPoolController@edit')->name('pool.edit');

    Route::post('/distributors-pool/save', 'DistributorsPoolController@save')->name('pool.save');
    Route::post('/distributors-pool/update/{code}/{country}', 'DistributorsPoolController@update')->name('pool.update');
    Route::post('/distributors-pool/delete/{code}/{country}', 'DistributorsPoolController@delete')->name('pool.delete');

    Route::post('/distributors-pool/upload-file', 'DistributorsPoolController@uploadFile')->name('pool.uploadfile');
    Route::post('/distributors-pool/validate-sponsor', 'DistributorsPoolController@validateSponsor')->name('pool.validatesponsor');
    # DISTRIBUTORS POOL ROUTES END GYM
    //REPORTES
Route::get('reports/reporte-ventas', 'Gym\VentaController@reporteVenta')->name('shopping-report.reporte');
Route::post('filter/ventas', 'Gym\VentaController@filterVentas')->name('filter.ventas');

Route::post('reports/reporte-clientes', 'Gym\ReportController@reportClientes')->name('shopping-report.reporte.clientes');
//Route::get('/admin/venta/reportes/index', 'gym\ReportController@index')->name('report.index');
Route::get('reports', 'Gym\ReportController@index')->name('shopping-report.index');
Route::post('reports/general', 'Gym\ReportController@reporteGeneral')->name('shopping-report.reporte-general');

Route::get('clientes/addonly', 'Gym\ClienteController@getAddCliente')->name('cliente.add_only_cliente');
Route::get('clientes/addCliente', 'Gym\ClienteController@addClienteGet')->name('client.add_cliente');
Route::post('clientes/add', 'Gym\ClienteController@saveCliente')->name('client.save_cliente');
Route::get('clientes/list', 'Gym\ClienteController@index')->name('client.list_clientes');
Route::get('clientes/edit/{id}', 'Gym\ClienteController@updateCliente')->name('client.edit_cliente');
Route::post('clientes/edit', 'Gym\ClienteController@saveUpdateCliente')->name('client.update_cliente');
Route::post('cliente/changeStatus', 'Gym\ClienteController@deleteCliente')->name('client.activeInactive_cliente');
Route::get('clientes/delete/{id}', 'Gym\ClienteController@eraseCliente')->name('client.delete_cliente');
Route::post('cliente/add_membresia', 'Gym\ClienteController@saveMembresia')->name('client.add_membresia');
Route::get('cliente/detalle_venta', 'Gym\ClienteController@detalleVenta')->name('client.detalle_venta');
Route::post('cliente/add_membresia_cliente', 'Gym\ClienteController@addMembresiaCliente')->name('client.add_less_membresia');
Route::post('cliente/getCliente', 'Gym\ClienteController@getCliente')->name('client.getClienteByName');
Route::post('cliente/listFilterClientes', 'Gym\ClienteController@getUsersAsCliente')->name('client.getListClientes');
Route::get('cliente/detalle_venta_checkout', 'Gym\ClienteController@getDetalleVenta')->name('client.detalle_venta_checkout');
Route::post('cliente/finalizar_compra', 'Gym\ClienteController@finalizarCompra')->name('client.finalizar_compra');
Route::post('membresia/membresia/view', 'Gym\ClienteController@listMembresias')->name('client.list_view');



    
    
    
    
    
    
    
    
    
    
    
    
    
});

/*  === ADMIN-GUEST ROUTES === */
Route::group(['middleware' => ['web','admin.guest'], 'prefix' => 'admin','as'=> 'admin.', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::any('login', ['uses' => 'AuthController@login', 'as' => 'login']);
    Route::any('forgotten-password', ['uses' => 'AccountController@forgottenPassword', 'as' => 'login.password.forgotten']);
    Route::any('change-password/{code}', ['uses' => 'AccountController@changePassword', 'as' =>  'login.password.change']);


});

Route::group(['middleware' =>['web','admin.auth', 'admin.langLocale'], 'prefix' => 'gym', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{

    
Route::get('gym', 'GymController@start')->name('admin.Gym.homegym');

Auth::routes(); 
  Route::get('countries', ['uses' => 'CountriesController@getIndex', 'as' => 'countries.list']);

Route::get('/admin', 'HomeController@home')->name('admin');


//Clientes
Route::get('clientes/addCliente', 'gym\ClienteController@addClienteGet')->name('admin.Cliente.add_cliente');


//admin.Cliente.list_clientes
Route::post('clientes/add', 'gym\ClienteController@saveCliente')->name('admin.Cliente.save_cliente');
Route::get('clientes/list', 'Gym\ClienteController@index')->name('admin.Cliente.list_clientes');
Route::get('clientes/edit/{id}', 'gym\ClienteController@updateCliente')->name('admin.Cliente.edit_cliente');
Route::post('clientes/edit', 'gym\ClienteController@saveUpdateCliente')->name('admin.Cliente.update_cliente');
Route::post('cliente/changeStatus', 'gym\ClienteController@deleteCliente')->name('admin.Cliente.activeInactive_cliente');
Route::get('clientes/delete/{id}', 'gym\ClienteController@eraseCliente')->name('admin.Cliente.delete_cliente');


Route::post('cliente/add_membresia', 'gym\ClienteController@saveMembresia')->name('admin.Cliente.add_membresia');
Route::get('cliente/detalle_venta', 'gym\ClienteController@detalleVenta')->name('admin.Cliente.detalle_venta');
Route::post('cliente/add_membresia_cliente', 'gym\ClienteController@addMembresiaCliente')->name('admin.Cliente.add_less_membresia');
Route::post('cliente/getCliente', 'gym\ClienteController@getCliente')->name('admin.Cliente.getClienteByName');

Route::post('cliente/listFilterClientes', 'gym\ClienteController@getUsersAsCliente')->name('admin.Cliente.getListClientes');



Route::get('cliente/detalle_venta_checkout', 'gym\ClienteController@getDetalleVenta')->name('admin.Cliente.detalle_venta_checkout');
Route::post('cliente/finalizar_compra', 'gym\ClienteController@finalizarCompra')->name('admin.Cliente.finalizar_compra');
Route::post('membresia/membresia/view', 'gym\ClienteController@listMembresias')->name('admin.Membresia.list_view');



Route::get('venta/index', 'gym\VentaController@index')->name('admin.venta.venta');
Route::get('venta/add', 'gym\VentaController@addVenta')->name('admin.venta.add');
Route::get('venta/detalle/{idVenta}', 'gym\VentaController@detalleVentaFactura')->name('admin.venta.detalle');
Route::post('venta/addPago', 'gym\VentaController@updateMembresiaClienteVenta')->name('admin.venta.addPago');

Route::get('venta/cliente/membresia/{id}', 'gym\VentaController@shoppMembresia')->name('admin.venta.addMembresia');
Route::get('venta/cliente/checkout-membresia', 'gym\VentaController@checkoutVentaMembresia')->name('admin.venta.cliente_checkout_membresia');
Route::get('venta/cliente/checkout-actividad', 'gym\VentaController@checkoutVentaActividad')->name('admin.venta.cliente_checkout_actividad');
Route::get('venta/cliente/actividad/{id}', 'gym\VentaController@shoppActividad')->name('admin.venta.addActividad');
Route::get('deporte/add', 'gym\DeporteController@addDeporte')->name('admin.Deporte.addDeporte');
Route::post('deporte/add', 'gym\DeporteController@saveDeporte')->name('admin.Deporte.save_deporte');
Route::get('deporte/list', 'Gym\DeporteController@index')->name('admin.Deporte.list_deportes');
Route::get('deporte/edit/{id}', 'gym\DeporteController@getDeporte')->name('admin.Deporte.get_deporte');
Route::post('deporte/update', 'gym\DeporteController@updateDeporte')->name('admin.Deporte.edit_deporte');
Route::post('deporte/changeStatus', 'gym\DeporteController@deleteDeporte')->name('admin.Deporte.active_inactive');
Route::get('deporte/detalle/{id}', 'gym\DeporteController@detailActividad')->name('admin.Deporte.detail');
Route::get('deporte/delete/{id}', 'gym\DeporteController@eraseDeporte')->name('admin.Deporte.delete_deporte');

Route::get('/changeLang/{lang}', 'gym\indexController@changeLang')->name('start');
Route::get('/usuarios', 'gym\UsuarioController@getUsuarios')->name('usuarios');
Route::post('/getEstados', 'gym\GymController@getEstados')->name('admin.Estados.estados');
Route::post('/getPais', 'gym\GymController@getPais')->name('pais');
//Membresia controller
Route::get('membresia/addMembresia', 'gym\MembresiaController@getAdd')->name('admin.Membresia.addMembresia');
Route::post('membresia/saveMembresia', 'gym\MembresiaController@addMebrecia')->name('admin.Membresia.saveMembresia');
Route::get('membresia/index', 'gym\MembresiaController@index')->name('admin.Membresia.list_membresia');
Route::post('membresia/changeStatus', 'gym\MembresiaController@activeInactiveMembresia')->name('admin.Membresia.activeInactive_membresia');
Route::get('membresia/membresia/{id}', 'gym\MembresiaController@getMembresiaById')->name('admin.Membresia.getMembresia');
Route::post('membresia/membresia/save', 'gym\MembresiaController@updateMembrecia')->name('admin.Membresia.editMembresia');
Route::get('membresia/detalle-membresia/{id}', 'gym\MembresiaController@detailMembresia')->name('admin.Membresia.detail-membresia');


//gastos
 Route::get('expenses/index',['uses'=>'gym\GastoController@index', 'as' => 'admin.Gasto.index']);
 Route::get('expenses/add',['uses'=>'gym\GastoController@getAdd', 'as' => 'admin.Gasto.add']);
Route::post('expenses/saveAdd', 'gym\GastoController@postAdd')->name('admin.Gasto.addCosto');




});
