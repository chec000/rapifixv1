<?php

namespace Modules\Shopping\Http\Controllers;

use App\Helpers\SessionHdl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\GroupCountry;
use PageBuilder;
use Response;
use View;
use App\Helpers\ShoppingCart;

class ShoppingCartController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function addOneItem(Request $request) {
    //hola
        ShoppingCart::createSession();
        $item    = $request->all();
        $newItem = ShoppingCart::addItem($item);

        return response()->json([
            'status'      => !empty($newItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(app()->getLocale()),
            'price'       => ShoppingCart::getPriceFormatted($newItem['sku'], Session::get('portal.main.currency_key')),
        ], 200);
    }

    public function removeOneItem(Request $request) {
      
        $corbizKey = Session::get('portal.main.country_corbiz');
        $item      = $request->all();

        $removed = ShoppingCart::removeItem($corbizKey, $item['sku']);

        return response()->json([
            'status'      => $removed,
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function removeAllFromItem(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $item      = $request->all();
        
        $removed = ShoppingCart::removeItem($item['sku'], true);

        return response()->json([
            'status'      => $removed,
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function removeAll(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        $removed   = ShoppingCart::deleteSession($corbizKey);

        return response()->json([
            'status'     => $removed,
            'translates' => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function addManyItems(Request $request) {
        $corbizKey = Session::get('portal.main.country_corbiz');
        ShoppingCart::createSession($corbizKey);

        $items  = $request->all();
        $prices = [];

        if (sizeof($items) > 0) {
            foreach ($items as $item) {
                $newItem = ShoppingCart::addItem($corbizKey, $item);
                $prices[$newItem['sku']] = ShoppingCart::getPriceFormatted($corbizKey, $newItem['sku'], Session::get('portal.main.currency_key'));
            }
        }

        return response()->json([
            'status'      => !empty($newItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale')),
            'prices'      => $prices,
        ], 200);

    }

    public function changeItemQuantity(Request $request) {

        ShoppingCart::createSession();

        $item        = $request->all();
        $updatedItem = ShoppingCart::updateItem($item['sku'], $item);

        return response()->json([
            'status'      => !empty($updatedItem),
            'cart_resume' => $this->getCartResume(),
            'translates'  => ShoppingCart::getProductTranslations(app()->getLocale())
        ], 200);
    }

    public function getCartResume() {
        $currency  = Session::get('portal.main.currency_key');
        if($currency==null){
            $currency="PAB";
        }

        return [
            'subtotal'            => ShoppingCart::getSubtotal(),
            'subtotal_formatted'  => ShoppingCart::getSubtotalFormatted($currency),
            'points'              => ShoppingCart::getPoints()
        ];
    }

    public function removeAllResumeCart(Request $request) {

        $removed   = ShoppingCart::deleteSessionResumeCart();

        return response()->json([
            'status'     => $removed,
            'translates' => ShoppingCart::getProductTranslations(Session::get('portal.main.app_locale'))
        ], 200);
    }

    public function listProductsCart(){

        $products=ShoppingCart::getItems();
        $subTotal=ShoppingCart::getSubtotal();
        $cart=\session()->get('portal.cart');

        $categories=$this->category();
        $categories=$categories->original['brandCategories'][0]['categories'];

        return View::make('shopping::frontend.shopping.shopping_cart_list', [
            'cart'=>$cart,
            'categories'=>$categories,
            'products'=>$products,
            'subtotal'=>$subTotal
        ]);

    }

    public function getCarrito(){
        $cart=\session()->get('portal.cart');

       $cartList= View('shopping::frontend.shopping.cart_list', [
            'cart'=>$cart,
        ]);
       return $cartList->render();
    }

    public function category($category_slug=null) {
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
}
