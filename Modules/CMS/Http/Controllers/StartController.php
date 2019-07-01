<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\CMS\Http\Controllers;

/**
 * Description of StartController
 *
 * @author sergio
 */
use App\Helpers\RestWrapper;
use App\Helpers\SessionHdl;
use App\Helpers\ShoppingCart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\CountryLanguage;
use Modules\CMS\Entities\Page;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\Legal;
use Modules\CMS\Entities\PageLang;
use Modules\Shopping\Entities\PromoProd;
use View;
use Request;
use Illuminate\Http\Request as rqs;
use Illuminate\Http\Response as res;

class StartController extends Controller
{

    public function session(){
        return json_encode(session()->all());
    }

    public function index()
    {
        $this->getCountry(17);

        $brand_1 = session()->get('portal.main.brand');

        $cart=\session()->get('portal.cart');

        $categories=$this->getCategories();
        $categories=$categories->original['brandCategories'][0]['categories'];
        return View::make('shopping::frontend.products',['categories'=>$categories,
            'cart'=>$cart
            ]);

        //  return View::make('cms::frontend.index',['categories'=>$categories]);
    }


    public function getCategories()
    {

        $brand = Brand::find(1);
        $country_id=17;
        if ($brand->parent_brand_id != 0) {
            $brands = $brand->getParents();
        } else {
            $brands = [$brand];
        }

        $brandCategories = [];
        for ($i=0; $i < count($brands); $i++) {
            $categories         = GroupCountry::getByCountryAndBrand($country_id, $brands[$i]->id, 1, true);
            $categoriesFiltered = collect([]);

            foreach ($categories as $j => $category) {
                $categories[$j]['products']=$this->getProductByCategory($category->id);
                if ($categories[$j]->countHomeProducts > 0) {
                    $categories[$j]->url = $brands[$i]->domain . route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug, false);
                    $categories[$j]->home_products = $categories[$j]->countHomeProducts;

                    $categoriesFiltered->push($categories[$j]);
                }
            }

            if ($brands[$i]->belongsToCountry($country_id)) {
                $brandCategories[] = [
                    'brand'      => $brands[$i],
                    'categories' => $categoriesFiltered
                ];
            }
        }

        $corbiz=SessionHdl::getCorbizCountryKey();
        if($corbiz==null){
            $corbiz="";
        }

        $json = array(
            'brandCategories'    => $brandCategories,
            'json_shopping_cart' => ShoppingCart::sessionToJson($corbiz),
            'show_tabs'          => $brand->parent_brand_id != 0 ? true : false
        );


        return response()->json($json);
    }

    public function getProducts($category_id) {

        $category         = GroupCountry::find($category_id);
        $categoryProducts = $category->groupProducts->where('active', 1)->where('product_home', 1);
        $jsonProducts     = ShoppingCart::productsToJson($categoryProducts);
        $config           = country_config(SessionHdl::getCorbizCountryKey());

        $isShoppingActive = $config['shopping_active'];
        $isWSActive       = $config['webservices_active'];
        $warehouse        = SessionHdl::getWarehouse();
        $sesionCorbiz="";
        if(SessionHdl::getCorbizCountryKey()!=null){
            $sesionCorbiz=SessionHdl::getCorbizCountryKey();
        }
        ShoppingCart::validateProductWarehouse($sesionCorbiz, $warehouse);
        $products        = [];
        $countryProducts = CountryProduct::getAllByCategory($category->id, $category->country_id, App()->getLocale(), true, false);
        foreach ($countryProducts as $countryProduct) {
            if ($countryProduct->product->is_kit == 0) {
                $countryProduct->url         = $category->brandGroup->brand->domain . route(\App\Helpers\TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'detail']), [($countryProduct->slug . '-' . $countryProduct->product->sku)], false);
                $countryProduct->price       = !hide_price() ? currency_format($countryProduct->price, Session::get('portal.main.currency_key')) : '';
                $countryProduct->description = str_limit2($countryProduct->description, 74);

                if (($isShoppingActive and $isWSActive and $countryProduct->belongsToWarehouse($warehouse)) xor (!$isShoppingActive or !$isWSActive)) {
                    $products[] = $countryProduct;
                }
            }
        }

        $json = [
            'products'           => $products,
            'shopping_active'    => $isShoppingActive,
            'is_ws_active'       => $isWSActive,
            'is_logged'          => SessionHdl::hasEo(),
            'json_products'      => $jsonProducts,
        ];

        return response()->json($json);
    }

    private function getProductByCategory($category_id){

        $category         = GroupCountry::find($category_id);
        $warehouse        = SessionHdl::getWarehouse();
        $sesionCorbiz="";
        if(SessionHdl::getCorbizCountryKey()!=null){
            $sesionCorbiz=SessionHdl::getCorbizCountryKey();
        }
        ShoppingCart::validateProductWarehouse($sesionCorbiz, $warehouse);
        $products        = [];
        $countryProducts = CountryProduct::getAllByCategory($category->id, $category->country_id, App()->getLocale(), true, false);
        foreach ($countryProducts as $countryProduct) {
            if ($countryProduct->product->is_kit == 0) {
                $countryProduct->url         = $category->brandGroup->brand->domain . route(\App\Helpers\TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'detail']), [($countryProduct->slug . '-' . $countryProduct->product->sku)], false);
                $countryProduct->price       = !hide_price() ? currency_format($countryProduct->price, Session::get('portal.main.currency_key')) : '';
                $countryProduct->description = str_limit2($countryProduct->description, 74);
                $products[] = $countryProduct;

            }
        }

        return $products;
    }



    /**
     * Descripción: codigo 200 cuando trae mas de un lenguaje
     * codigo 300 solo un lenguaje
     * codigo 500 existio un error
     */
    public function getCountryLanguages($country_id, $saveWHSessionGeoLoc = 0) {

        $country = $this->getCountry($country_id);
        try {
            session()->forget('portal.main.corbiz_warehouse');
            session()->forget('portal.main.corbiz_distCenter');

            $languajes = CountryLanguage::where('country_id', '=', $country_id)->select('language_id')->groupBy('language_id')->get();
            $lan_array = array();
            foreach ($languajes as $lan) {
                array_push($lan_array, $lan->language_id);
            }

            $useZipCodeOrCity = false;
            $languages_list = Language::whereIn('id', $lan_array)->get();
            $lanDefault = Language::select('id', 'locale_key', 'corbiz_key')->where('locale_key', '=', $country['data']->default_locale)->first();

            if ($lanDefault != null) {
                app()->setLocale($lanDefault->locale_key);
                session()->put('portal.main.language_id', $lanDefault->id);
                session()->put('portal.main.language_name', $lanDefault->language_country);
                session()->put('portal.main.language_corbiz', $lanDefault->corbiz_key);
                session()->put('portal.main.app_locale', $lanDefault->locale_key);

                //Implementacion de WEB Service getCountryConfiguration
                if (config('settings::frontend.webservices') == 1 && (session()->has("portal.main.shopping_active") && session()->get("portal.main.shopping_active") == 1) && $saveWHSessionGeoLoc == 1) {
                    if ($this->existSession()) {
                        $useZipCodeOrCity = $this->getCountryConfigurationService(session()->get('portal.main.country_corbiz')
                            , session()->get('portal.main.language_corbiz'), true);
                    }
                }
            }
            if (count($languages_list) > 1) {
                return $response = array(
                    'code' => 200,
                    'data' => Language::whereIn('id', $lan_array)->get(),
                    'country' => $country['data'],
                    'url' => route('admin.home'),
                    'useZipCodeOrCity' => $useZipCodeOrCity,
                    'shopping_active' => $country['data']->shopping_active,
                    'dataSession' => SESSION::all()
                );
            } else {
                //Implementacion de WEB Service getCountryConfiguration
                if (config('settings::frontend.webservices') == 1 && (session()->has("portal.main.shopping_active") && session()->get("portal.main.shopping_active") == 1) && $saveWHSessionGeoLoc == 0) {
                    if ($this->existSession()) {
                        $useZipCodeOrCity = $this->getCountryConfigurationService(session()->get('portal.main.country_corbiz')
                            , session()->get('portal.main.language_corbiz'), false);
                    }
                }
                return $response = array(
                    'code' => 300,
                    'data' => Language::whereIn('id', $lan_array)->get(),
                    'country' => $country['data'],
                    'url' => route('admin.home'),
                    'useZipCodeOrCity' => $useZipCodeOrCity,
                    'shopping_active' => $country['data']->shopping_active,
                );
            }
        } catch (Exception $ex) {
            return $response = array(
                'code' => 500,
                'data' => $ex->getMessage(),
                'country' => $country['data'],
                'shopping_active' => $country['data']->shopping_active,
            );
        }
    }

    /* Codigo 200 se guarda la variable pais en sesión en sesion
     * codigo 300 ya existe el pais en sesión
     * codigo 500 existio un error
     */

    public function saveCountry($lat = "", $lon = "") {

//    $lat=35.114351;
//    $lon=-106.593404;
//

        try {
            //if (session()->has('portal.main.country_id') != true) {
            session()->put('portal.main.useGeolocalization', 1);
            $httpClient = new \Http\Adapter\Guzzle6\Client();
            $provider = new \Geocoder\Provider\GoogleMaps\GoogleMaps($httpClient, null, 'AIzaSyBBmgIlPaMOTALtAFrpNzOSEpxEJHyoce4');
            $geocoder = new \Geocoder\StatefulGeocoder($provider, 'en');
            $location = $geocoder->reverse($lat, $lon)->first()->toArray();
            //dd($location);
            if ($location != null) {
                $countryKey = $this->is_uecountry($location['countryCode']) ? config('cms.countryKey_ue') : $location['countryCode'];
                $country = Country::where('country_key', 'like', '%' . $countryKey . '%')->first();
                session()->put('portal.main.zipCode', $location['postalCode']);
                if ($country != null) {
                    app()->setLocale($country->default_locale);
                    session()->put('portal.main.app_locale', $country->default_locale);
                    session()->put('portal.main.countryCode', $location['countryCode']);
                    session()->put('portal.main.country_id', $country->id);
                    session()->put('portal.main.country_name', $country->name);
                    session()->put('portal.main.time_zone', $country->timezone);
                    session()->put('portal.main.shopping_active', $country->shopping_active);
                    session()->put('portal.main.inscription_active', $country->inscription_active);
                    session()->put('portal.main.customer_active', $country->customer_active);
                    session()->put('portal.main.currency_key', $country->currency_key);
                    session()->put('portal.main.country_corbiz', $country->corbiz_key);
                    session()->put('portal.main.flag', $country->flag);
                    session()->put('portal.main.webservice', $country->webservice);
                    $this->getDocumentByCountry($country->id);
                    return $response = array(
                        'code' => 200,
                        'data' => $country
                    );
                } else {
                    return $response = array(
                        'code' => 500,
                        'data' => session()->get('portal.main.country_id')
                    );
                }
            } else {
                return $response = array(
                    'code' => 500,
                    'data' => null
                );
            }
        } catch (Exception $ex) {
            return $response = array(
                'code' => 500,
                'data' => $ex->getMessage()
            );
        }
    }

    public function getCountry($id_country) {
        try {
            $country = Country::where('id', '=', $id_country)->first();
            if ($country != null) {
                app()->setLocale($country->default_locale);
                session()->put('portal.main.app_locale', $country->default_locale);
                session()->put('portal.main.countryCode', $country->country_key);
                session()->put('portal.main.country_id', $country->id);
                session()->put('portal.main.country_name', $country->name);
                session()->put('portal.main.time_zone', $country->timezone);
                session()->put('portal.main.shopping_active', $country->shopping_active);
                session()->put('portal.main.inscription_active', $country->inscription_active);
                session()->put('portal.main.customer_active', $country->customer_active);
                session()->put('portal.main.currency_key', $country->currency_key);
                session()->put('portal.main.country_corbiz', $country->corbiz_key);
                session()->put('portal.main.flag', $country->flag);
                session()->put('portal.main.webservice', $country->webservice);
                $this->getDocumentByCountry($country->id);

                $this->getVariablesMenuSession();
                return $response = array(
                    'code' => 200,
                    'data' => $country
                );
            } else {
                return $response = array(
                    'code' => 300,
                    'data' => null
                );
            }
        } catch (Exception $ex) {
            return $response = array(
                'code' => 500,
                'data' => null
            );
        }
    }

    public function saveCountryId($id) {
        try {
            $country = Country::find($id);
            if ($country != null) {
                app()->setLocale($country->default_locale);
                session()->put('portal.main.countryCode', $country->country_key);
                session()->put('portal.main.country_id', $country->id);
                session()->put('portal.main.country_name', $country->name);
                session()->put('portal.main.time_zone', $country->timezone);
                session()->put('portal.main.shopping_active', $country->shopping_active);
                session()->put('portal.main.inscription_active', $country->inscription_active);
                session()->put('portal.main.customer_active', $country->customer_active);
                session()->put('portal.main.currency_key', $country->currency_key);
                session()->put('portal.main.country_corbiz', $country->corbiz_key);
                session()->put('portal.main.webservice', $country->webservice);
                session()->put('portal.main.flag', $country->flag);
                $this->getDocumentByCountry($country->id);
                return $country;
            } else {
                return $response = array(
                    'code' => 300,
                    'data' => null
                );
            }
        } catch (Exception $ex) {
            $response = array(
                'code' => 500,
                'data' => null
            );
        }
    }

    private function is_uecountry($country) {
        $ue_countries = config('cms.countries_ue');
        $filtered_array = array_filter($ue_countries, function ($element) use ($country) {
            return ($element == $country);
        });
        if (count($filtered_array) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getLanguageId($language_id) {
        try {
            $lanDefault = Language::find($language_id);
            $useZipCodeOrCity = false;

            if (!session()->has('portal.main.changeLanguageId')) {
                session()->forget('portal.main.corbiz_warehouse');
                session()->forget('portal.main.corbiz_distCenter');
            }

            if ($lanDefault != null) {
                app()->setLocale($lanDefault->locale_key);
                session()->put('portal.main.app_locale', $lanDefault->locale_key);
                //session()->put('portal.main.language_id', 1);
                session()->put('portal.main.language_id', $lanDefault->id);
                session()->put('portal.main.language_name', $lanDefault->language_country);
                session()->put('portal.main.language_corbiz', $lanDefault->corbiz_key);
                $this->getDocumentByCountry(session()->get('portal.main.country_id'));

                //Implementacion de WEB Service getCountryConfiguration
                if (config('settings::frontend.webservices') == 1 && (session()->has("portal.main.shopping_active") && session()->get("portal.main.shopping_active") == 1)) {
                    if ($this->existSession()) {
                        $useZipCodeOrCity = $this->getCountryConfigurationService(session()->get('portal.main.country_corbiz')
                            , session()->get('portal.main.language_corbiz'), false);
                    }
                }
                return $response = array(
                    'code' => 200,
                    'data' => session()->all(),
                    'useZipCodeOrCity' => $useZipCodeOrCity,
                );
            } else {
                //Implementacion de WEB Service getCountryConfiguration
                if (config('settings::frontend.webservices') == 1 && (session()->has("portal.main.shopping_active") && session()->get("portal.main.shopping_active") == 1)) {
                    if ($this->existSession()) {
                        $useZipCodeOrCity = $this->getCountryConfigurationService(session()->get('portal.main.country_corbiz')
                            , session()->get('portal.main.language_corbiz'), false);
                    }
                }
                return $response = array(
                    'code' => 300,
                    'data' => session()->all(),
                    'useZipCodeOrCity' => $useZipCodeOrCity,
                );
            }
        } catch (Exception $ex) {
            return $response = array(
                'code' => 500,
                'data' => null
            );
        }
    }

    public function sessionData() {

        //     app()->getTimeZone();
        dd(session()->all());
        return json_encode(session()->all());
    }

    public function existSession() {
        if (session()->has('portal.main.country_id') && session()->has('portal.main.country_corbiz') && session()->has('portal.main.brand.id')) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getVariablesMenuSession() {

        session()->forget('portal.main.varsMenu.otherBrands');
        //$countryIdSession = Session::get('portal.main.country_id');
        if (!empty(Session::get('portal.main.brand.id'))) {
            $brands = Brand::select('glob_brands.*')
                ->join('glob_brand_countries', 'glob_brand_countries.brand_id', '=', 'glob_brands.id')
                ->where('glob_brand_countries.active', '=', 1)
                ->where('glob_brand_countries.country_id', '=', Session::get('portal.main.country_id'))
                ->where('glob_brands.id', '<>', Session::get('portal.main.brand.id'))
                ->where('glob_brands.active', '=', 1)
                ->orderBy('glob_brands.id', 'ASC')
                ->get();

            session()->put('portal.main.varsMenu.otherBrands', $brands);
        }

        session()->forget('portal.main.varsMenu.parentBrands');
        if (!empty(Session::get('portal.main.brand.parent_brand_id'))) {
            $explode_id = array_map('intval', explode(',', Session::get('portal.main.brand.parent_brand_id')));

            $parentBrands =  Brand::select('glob_brands.*')
                ->join('glob_brand_countries', 'glob_brand_countries.brand_id', '=', 'glob_brands.id')
                ->where('glob_brand_countries.active', '=', 1)
                ->where('glob_brand_countries.country_id', '=', Session::get('portal.main.country_id'))
                ->whereIn('glob_brands.id', $explode_id)
                ->where('glob_brands.active', '=', 1)
                ->orderBy('glob_brands.id', 'ASC')
                ->get();
            //dd(Brand::whereIn('id', $explode_id)->get());
            //session()->put('portal.main.varsMenu.parentBrands', Brand::whereIn('id', $explode_id)->get());
            session()->put('portal.main.varsMenu.parentBrands', $parentBrands);
        }

        session()->forget('portal.main.varsMenu.countryLangs');
        if (!empty(Session::get('portal.main.country_id'))) {
            $langs = CountryLanguage::selectArrayActiveById(Session::get('portal.main.country_id'));
            session()->put('portal.main.varsMenu.countryLangs', $langs);
        }
    }

    public function changeCountryLanguage() {

        $typeChange = Request::get('typeChange');
        $idData = Request::get('idData');

        if (empty($typeChange) || empty($idData)) {
            return redirect('/');
        }

        switch ($typeChange) {
            case 'country':
                $oldIdData = Session::get('portal.main.country_id');

                //dd("Session forget");
                Session::forget('portal.main.country_id');
                $result = $this->getCountryLanguages($idData);
                $result['url'] = Request::get('url');
                if ($result['code'] == 500) {
                    $this->getCountryLanguages($oldIdData);
                } else {
                    session()->forget('portal.main.zipCode');
                    session()->forget('portal.main.corbiz_warehouse');
                    session()->forget('portal.main.corbiz_distCenter');

                    session()->put('portal.main.changeCountryId', $idData);

                    if (Request::get('templateId') != null) {
                        $dataUrl = array(
                            'templateId' => Request::get('templateId'),
                            'pageId' => Request::get('pageId'),
                            'oldCountryId' => $oldIdData,
                            'newCountryId' => $idData
                        );
                        $resultUrl = $this->findNewPageOnChangeCountryLang('country', $dataUrl);
                        $result['url'] = $resultUrl ? $resultUrl : Request::get('url');

                        session()->put('portal.main.changeCountryURL', $result['url']);
                        //dd($result['url']);

                        $this->getWHCountryUniqueOnChangeCountry(session()->get('portal.main.country_corbiz')
                            , session()->get('portal.main.language_corbiz'));

                        session()->forget('portal.main.corbiz_distCenter');
                    }
                }
                break;
            case 'language':
                $oldIdData = Session::get('portal.main.language_id');

                session()->put('portal.main.changeLanguageId', $idData);
                $result = $this->getLanguageId($idData);
                $result['url'] = Request::get('url');
                if ($result['code'] == 500) {
                    $this->getLanguageId($oldIdData);
                } else {
                    if (Request::get('pageId') != null) {
                        $dataUrl = array(
                            'pageId' => Request::get('pageId'),
                            'oldLangId' => $oldIdData,
                            'newLangId' => $idData,
                        );
                        $resultUrl = $this->findNewPageOnChangeCountryLang('language', $dataUrl);

                        $result['url'] = $resultUrl ? $resultUrl : Request::get('url');
                    }
                }
                $this->getVariablesMenuSession();
                break;
        }

        //var_dump(Request::all(), $result); exit();
        return $result;
    }

    function getWHCountryUniqueOnChangeCountry($countryKey, $lang) {
        if (config('settings::frontend.webservices') == 1 && (session()->has("portal.main.shopping_active") && session()->get("portal.main.shopping_active") == 1)) {

            $resultConf = $this->getWebServiceRestGet(session()->get('portal.main.webservice'), "getCountryConfiguration"
                , "CountryKey=" . $countryKey . "&Lang=" . $lang);

            if ($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['WHUnique']) {
                session()->put('portal.main.corbiz_warehouse', trim($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['idWH']));
            }
        }
    }

    private function findNewPageOnChangeCountryLang($typeChange, $data) {
        switch ($typeChange) {
            case "country":
                $newUrl = false;
                $pageInfo = Page::find($data['pageId']);
                $lang = session()->get('portal.main.language_id');
                $pageCountry = PageLang::
                join('cms_pages', 'cms_page_lang.page_id', '=', 'cms_pages.id')
                    ->where('cms_pages.template', '=', $data['templateId'])
                    ->where('cms_pages.brand_id', '=', session()->get('portal.main.brand.id'))
                    ->where('cms_pages.country_id', '=', session()->get('portal.main.country_id'))
                    ->where('cms_page_lang.language_id', '=', session()->get('portal.main.language_id'))
                    ->select('cms_page_lang.url', 'cms_page_lang.language_id', 'cms_pages.code')->get();
                $qtyPages = $pageCountry->count();
                if ($qtyPages > 0) {
                    $this->getDocumentByCountry(session()->get('portal.main.country_id'));
                    if($qtyPages == 1){
                        $newUrl = $pageCountry[0]->url;
                    }else{
                        if($pageInfo != null){
                            foreach ($pageCountry as $pCountry){
                                if($pCountry->code == $pageInfo->code && $pCountry->language_id == session()->get('portal.main.language_id')){
                                    $newUrl = $pCountry->url;
                                }
                            }
                        }
                    }
                }
                return $newUrl;
                break;
            case "language":
                $newUrl = false;
                $pagesLang = PageLang::where('page_id', '=', $data['pageId'])->where('language_id', '=', $data['newLangId'])->first();
                if (!empty($pagesLang)) {
                    $newUrl = $pagesLang->url;
                }
                return $newUrl;
                break;
        }

        return 0;
    }

    public function getCountryConfigurationService($countryKey = "", $lang = "", $useGeolocalization = false) {
        //$countryKey = "CHI";
        //$lang = "ESP";

        $resultConf = $this->getWebServiceRestGet(session()->get('portal.main.webservice'), "getCountryConfiguration"
            , "CountryKey=" . $countryKey . "&Lang=" . $lang);

        if ($resultConf['success']) {
            if (isset($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0])) {
                //hardcode para forzar a pruebas

                if ($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['WHUnique']) {
                    session()->put('portal.main.corbiz_warehouse', trim($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['idWH']));
                    session()->put('portal.main.type_warehouse', "UNIQUE");
                    return array(
                        'code' => 200,
                        'type' => "COUNTRY",
                    );
                } elseif ($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['UseZipCode']) {
                    session()->put('portal.main.type_warehouse', "ZIPCODE");
                    if ($useGeolocalization || (session()->has('portal.main.useGeolocalization') && session()->get('portal.main.useGeolocalization') == 1)) {
                        //session()->put('portal.main.zipCode', '000');
                        $result = $this->getWHService("ZIPCODE");
                        return $result;
                    } else {
                        return array(
                            'code' => 200,
                            'type' => "ZIPCODE",
                        );
                    }
                } elseif ($resultConf['responseWS']['response']['CountryConfiguration']['dsCountryConfiguration']['ttCountryConfiguration'][0]['UseCity']) {
                    session()->put('portal.main.type_warehouse', "CITY");
                    $urlService = session()->get('portal.main.webservice');
                    $nameService = "getState";
                    $paramsService = "CountryKey=" . $countryKey . "&Lang="
                        . $lang;
                    $resultStates = $this->getWebServiceRestGet($urlService, $nameService
                        , $paramsService);
                    //dd($resultStates);
                    if ($resultStates['success']) {
                        $arrayStates = $resultStates['responseWS']['response']['State']['dsState']['ttState'];
                        return array(
                            'code' => 200,
                            'type' => "CITY",
                            'arrayStates' => $arrayStates
                        );
                    } else {
                        //Aqui van los errores del WS
                        return array(
                            'code' => 500,
                            'success' => false,
                            'type' => "CITY",
                            'data' => $resultStates['responseWS']['response']['Error']['dsError']['ttError'][0]
                        );
                    }
                }
            }
        } else {
            //Pintar mensajes de Error
            session()->put('portal.main.type_warehouse', 0);
            return array(
                'code' => 500,
                'success' => false,
                'data' => $resultConf['responseWS']['response']['Error']['dsError']['ttError'][0]
            );
        }
        return false;
    }

    public function getCitiesWs($stateKey) {
        session()->put('portal.main.stateKey_corbiz', trim($stateKey));
        $urlService = session()->get('portal.main.webservice');
        $nameService = "getCity";
        $paramsService = "CountryKey=" . session()->get('portal.main.country_corbiz') . "&Lang="
            . session()->get('portal.main.language_corbiz') . "&StateKey=" . $stateKey;
        $resultCities = $this->getWebServiceRestGet($urlService, $nameService
            , $paramsService);
        if ($resultCities['success']) {
            $arrayCities = $resultCities['responseWS']['response']['City']['dsCity']['ttCity'];
            return array(
                'code' => 200,
                'arrayCities' => $arrayCities
            );
        } else {
            //Aqui van los errores del WS
            return array(
                'code' => 500,
                'success' => false,
                'data' => $resultCities['responseWS']['response']['Error']['dsError']['ttError'][0]
            );
        }
    }

    public function setVariablesWareHouse() {
        $type = Request::get('type');
        $city = Request::get('city');
        $zipCode = Request::get('zipcode');
        switch ($type) {
            case 'ZIPCODE':
                session()->put('portal.main.zipCode', $zipCode);
                break;
            case 'CITY':
                session()->put('portal.main.cityKey_corbiz', $city);
                break;
        }
        /* return array(
          Request::all(),
          session()->get('portal.main.stateKey_corbiz'),
          session()->get('portal.main.cityKey')
          ); */
        $resultWSWarehouse = $this->getWHService($type);

        return $resultWSWarehouse;
    }

    private function getWHService($type = "") {

        $urlService = session()->get('portal.main.webservice');
        $nameService = "getAvailableWH";
        switch ($type) {
            case 'ZIPCODE':
                $paramsService = "CountryKey=" . session()->get('portal.main.country_corbiz') . "&Lang="
                    . session()->get('portal.main.language_corbiz') . "&StateKey=&CityKey=&ZipCode=" . session()->get('portal.main.zipCode');
                break;
            case 'CITY':
                $paramsService = "CountryKey=" . session()->get('portal.main.country_corbiz') . "&Lang="
                    . session()->get('portal.main.language_corbiz') . "&StateKey=" . session()->get('portal.main.stateKey_corbiz')
                    . "&CityKey=" . session()->get('portal.main.cityKey_corbiz') . "&ZipCode=";
                break;
            case 'COUNTRY':
                $paramsService = "CountryKey=" . session()->get('portal.main.country_corbiz') . "&Lang="
                    . session()->get('portal.main.language_corbiz') . "&StateKey=CityKey=&ZipCode=";
                break;
            default:
                return false;
        }

        //return Session::all();
        $resultAvailableWH = $this->getWebServiceRestGet($urlService, $nameService
            , $paramsService);



        if ($resultAvailableWH['success']) {
            session()->put('portal.main.corbiz_warehouse', trim($resultAvailableWH['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0]['warehouse']));
            session()->put('portal.main.corbiz_distCenter', trim($resultAvailableWH['responseWS']['response']['Warehouse']['dsWarehouse']['ttWarehouse'][0]['distCenter']));
            //dd($resultAvailableWH, session()->get('portal.main.corbiz_warehouse'), session()->get('portal.main.corbiz_distCenter'), $type);
            return array(
                'code' => 200,
                'success' => true,
                'data' => "",
                'type' => $type
            );
        } else {
            return array(
                'code' => 500,
                'success' => false,
                'type' => $type,
                'data' => $resultAvailableWH['responseWS']['response']['Error']['dsError']['ttError'][0]
            );
        }
    }

    private function getWebServiceRestGet($urlService = "", $nameService = "", $paramsService = "", $httpErrors = false) {

        $restWrapper = new RestWrapper($urlService . $nameService . "?" . $paramsService);
        $resultService = $restWrapper->call("GET", [], 'json', ['http_errors' => $httpErrors]);

        return $resultService;
    }

    private function existVariablesSessionWareHouse() {
        if (session()->has('portal.main.corbiz_warehouse') && session()->get('portal.main.corbiz_warehouse') != "") {
            return true;
        }
        return false;
    }

    public function getTestFunction() {
        session()->flush();
        return Session::all();

        $promotionsSent = Session::get('portal.checkout.USA.promotionsSent') != null ?
            Session::get('portal.checkout.USA.promotionsSent') : array();
        $existPromotion = array(
            "C295-N" => false,
            "295-BR" => false,
        );
        foreach($promotionsSent as $ps){
            if($ps === "C295-N") {
                $existPromotion['C295-N'] = true;
                break;
            }
        }
        foreach($promotionsSent as $ps){
            if($ps == "295-BR") {
                $existPromotion['295-BR'] = true;
                break;
            }
        }

        dd($existPromotion, $promotionsSent );
        return $existPromotion;
        //return response()->json($result);
    }

    private function getDocumentByCountry($country_id) {
        try {

            $lengal_document = Legal::where([['country_id', '=', $country_id], ['active', '=', 1], ['delete', '=', 0], ['active_policies', '=', 1]])->first();
            if ($lengal_document != null) {
                $document = Legal::find($lengal_document->id)->policies_pdf;
                if ($document != null) {
                    session()->put('portal.main.country_policies', $document);
                } else {
                    session()->forget('portal.main.country_policies');
                }
            } else {
                session()->forget('portal.main.country_policies');
            }
        } catch (Exception $ex) {
            session()->forget('portal.main.country_policies');
        }
    }

    public function saveReadCookies(rqs $request) {
        $countries = config('cms.countries_policies_except');
        $country = session()->get('portal.main.country_corbiz');
        if (!array_key_exists($request->country_selected, $countries)) {
//            $cookie = cookie('country_cookie' . $request->country_selected, $country, 10080);
            $response = new res(json_encode(true));
            return    $response->withCookie(cookie()->forever('country_cookie' . $request->country_selected, $country));
            //    return $response->withCookie($cookie);
        } else {
            if ($request->type_option == 2) {
                Session::put('portal.main.has_read_cookies', true);
                return json_encode(true);
            } else {

                if ($country != "ESP") {
                    session()->forget('portal.main.has_read_cookies');
                }
                return json_encode(false);
            }
        }
    }


}