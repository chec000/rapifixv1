<?php

namespace Modules\CMS\Http\Controllers;

use App\Helpers\SessionHdl;
use App\Helpers\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Brand;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\GroupCountry;

class ProductsApiController extends Controller
{
    public function getCategories(Request $request)
    {
        $data = $request->all();
        $brand = Brand::find($data['brand_id']);
        if ($brand->parent_brand_id != 0) {
            $brands = $brand->getParents();
        } else {
            $brands = [$brand];
        }

        $brandCategories = [];
        for ($i=0; $i < count($brands); $i++) {
            $categories         = GroupCountry::getByCountryAndBrand($data['country_id'], $brands[$i]->id, 1, true);
            $categoriesFiltered = collect([]);

            foreach ($categories as $j => $category) {
                if ($categories[$j]->countHomeProducts > 0) {
                    $categories[$j]->url = $brands[$i]->domain . route(\App\Helpers\TranslatableUrlPrefix::getRouteName(session()->get('portal.main.app_locale'), ['products', 'category']), $category->slug, false);
                    $categories[$j]->home_products = $categories[$j]->countHomeProducts;

                    $categoriesFiltered->push($categories[$j]);
                }
            }

            if ($brands[$i]->belongsToCountry($data['country_id'])) {
                $brandCategories[] = [
                    'brand'      => $brands[$i],
                    'categories' => $categoriesFiltered
                ];
            }
        }

        $json = array(
            'brandCategories'    => $brandCategories,
            'json_shopping_cart' => ShoppingCart::sessionToJson(SessionHdl::getCorbizCountryKey()),
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
