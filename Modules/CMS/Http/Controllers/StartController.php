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

    public function index()
    {
        session()->put('portal.main.varsChangeLangStart.changeStartLocale', 0);
        $categories=$this->getCategories();
        $categories=$categories->original['brandCategories'][0]['categories'];
        return View::make('cms::frontend.index',['categories'=>$categories]);
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

    public function getProducts(Request $request) {
        $data             = $request->all();
        $category         = GroupCountry::find($data['category_id']);
        $categoryProducts = $category->groupProducts->where('active', 1)->where('product_home', 1);
        $jsonProducts     = ShoppingCart::productsToJson($categoryProducts);
        $config           = country_config(SessionHdl::getCorbizCountryKey());

        $isShoppingActive = $config['shopping_active'];
        $isWSActive       = $config['webservices_active'];
        $warehouse        = SessionHdl::getWarehouse();

        ShoppingCart::validateProductWarehouse(SessionHdl::getCorbizCountryKey(), $warehouse);

        $products        = [];
        $countryProducts = CountryProduct::getAllByCategory($category->id, $category->country_id, SessionHdl::getLocale(), true, false);
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


}