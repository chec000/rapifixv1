<?php

namespace Modules\Shopping\Http\Controllers;

use App\Helpers\CommonMethods;
use App\Helpers\SessionHdl;
use App\Helpers\ShoppingCart;
use App\Helpers\TranslatableUrlPrefix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\Country;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Shopping\Entities\CategoryFilter;
use Modules\Shopping\Entities\ComplementaryProducts;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\GroupProduct;
use PageBuilder;
use Response;
use View;

class ProductController extends Controller {

    public function __construct() {
        parent::__construct();
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


    public function procuctsByCategory($category_id){

        $category         = GroupCountry::find($category_id);

        $warehouse        = SessionHdl::getWarehouse();
        $sesionCorbiz="";
        if(SessionHdl::getCorbizCountryKey()!=null){
            $sesionCorbiz=SessionHdl::getCorbizCountryKey();
        }
        ShoppingCart::validateProductWarehouse($sesionCorbiz, $warehouse);
        $products        = [];
        //$countryProducts = CountryProduct::getAllByCategory($category->id, $category->country_id, App()->getLocale(), true, false);

$countryProducts = CountryProduct::getAllByCategoryPaginated($category->id, $category->country_id, App()->getLocale(), true, false);
      //  echo json_encode($countryProducts);
        //die();
    
        foreach ($countryProducts as $countryProduct) {
        


            if ($countryProduct->product->is_kit == 0) {
             //   $countryProduct->url         = $category->brandGroup->brand->domain . route(\App\Helpers\TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'detail']), [($countryProduct->slug . '-' . $countryProduct->product->sku)], false);
               // $countryProduct->price       = !hide_price() ? currency_format($countryProduct->price, Session::get('portal.main.currency_key')) : '';
                //$countryProduct->description = str_limit2($countryProduct->description, 74);
                
                $products[] = $countryProduct;

            }
        }
        //var_dump($countryProducts);
        //die();
        $categories=$this->category();
        $categories=$categories->original['brandCategories'][0]['categories'];
        $cart=\session()->get('portal.cart');

        return View::make('shopping::frontend.products_category', [
            'categories'=> $categories,
            'cart'=>$cart,
            'category'=>$category,
            'products'=>$countryProducts
        ]);
    }

    public function products() {
        session()->put('portal.main.varsChangeLangStart.changeStartLocale', 0);
        $cart=\session()->get('portal.cart');

        $categories=$this->category();
        $categories=$categories->original['brandCategories'][0]['categories'];
        return View::make('shopping::frontend.products',['categories'=>$categories,
            'cart'=>$cart
        ]);

    }

        public  function getSession(){
                return json_encode(session()->all());
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

    public function system(Request $request, $system_slug) {
        $config      = country_config(SessionHdl::getCorbizCountryKey());
        $system      = GroupCountry::whereTranslation('slug', $system_slug)->where('country_id', SessionHdl::getCountryID())->where('group_id', 2)->first();

        ShoppingCart::validateProductWarehouse(SessionHdl::getCorbizCountryKey(), SessionHdl::getWarehouse());

        $isShoppingActive = $config['shopping_active'];
        $isWSActive       = $config['webservices_active'];
        $state            = $this->getState();

        if ($system == null || $system->active == 0 || $system->group_id != 2 || !$system->areAllProductsActive($state)) {
            return redirect()->route(TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', 'index']));
        }

        if (SessionHdl::getBrandID() != $system->brandGroup->brand->id) {
            return redirect(str_replace(SessionHdl::getBrandUrl(), $system->brandGroup->brand->domain, url()->current()));
        }

        $categories  = GroupCountry::getByCountryAndBrand(SessionHdl::getCountryID(), SessionHdl::getBrandID(), 1);
        $products    = CountryProduct::getFilteredByGroup($system->id);
        $systems     = GroupCountry::getByCountryAndBrand(SessionHdl::getCountryID(), SessionHdl::getBrandID(), 2);

        foreach ($systems as $i => $s) {
            if (!$s->areAllProductsActive($state)) {
                $systems->forget($i);
            }
        }

        $showSystemTab = GroupCountry::getByCountryAndBrand(SessionHdl::getCountryID(), SessionHdl::getBrandID(), 2)->count() > 0;

        return View::make('shopping::frontend.systems', [
            'categories'       => $categories,
            'system'           => $system,
            'systems'          => $systems,
            'products'         => $products,
            'url'=>"",
            'currency'         => SessionHdl::getCurrencyKey(),
            'isShoppingActive' => $isShoppingActive,
            'isWSActive'       => $isWSActive,
            'showSystemTab'    => $showSystemTab,
        ]);
    }

    public function detail($product_slug) {

        $locale= app()->getLocale();
        $country_id=17;
        $brand_id=1;

        $countryProducts=CountryProduct::where('country_id', $country_id)->get();

        $countryProduct  = null;
        foreach ($countryProducts as $cp) {
            if ($cp->slug == $product_slug) {
                $countryProduct = $cp;
            }
        }

        if ($countryProduct == null) {
            return redirect()->route(TranslatableUrlPrefix::getRouteName($locale, ['products', 'index']));
        }


        $category = $countryProduct->productGroups->where('active', 1)->where('country_id',$country_id)->where('group_id', 1)->pop();

        if ($brand_id != $countryProduct->product->brandProduct->brand->id) {
            return redirect(str_replace(SessionHdl::getBrandUrl(), $countryProduct->product->brandProduct->brand->domain, url()->current()));
        }

        # Categorías y productos relacionados
        $categories      = GroupCountry::getByCountryAndBrand($country_id, $brand_id, 1);
        $relatedProducts = $countryProduct->getRelatedProducts();

        # Background color
        $backgroundColor = '';
        $segments = explode('/', url()->previous());
        if (isset($segments[4]) && isset($segments[5]) && in_array($segments[4], \App\Helpers\TranslatableUrlPrefix::getTranslatablePrefixesByIndex('system'))) {
            $system = GroupCountry::whereTranslation('slug', $segments[5])->where('country_id', $country_id)->where('group_id', 2)->first();
            $backgroundColor = $system->color;
        } else {
            if (!is_null($category)) {
                $backgroundColor = $category->color;
            } else {
                $system = $countryProduct->productGroups->where('active', 1)->where('country_id', $country_id)->where('group_id', 2)->pop();
                if (!is_null($system)) {
                    $backgroundColor = $system->color;
                }
            }
        }

        # Social meta info
        //$urlSocialTag = \Request::url() . '?' . \App\Helpers\ShareSession::getShareArrayEncoded();
        $socialTags = [
            'facebook' => [
                'title'       => $countryProduct->name,
                'type'        => 'website',
                'description' => $countryProduct->description,
                'url'         => "",
                'image'       => asset($countryProduct->image),
                'site_name'   => $countryProduct->name,
            ],
            'twitter' => [
                'card'        => 'summary',
                'title'       => $countryProduct->name,
                'image'       => asset($countryProduct->image),
                'site'        => 'https://twitter.com/omnilife',
                'creator'     => 'Omnilife',
                'url'         => "",
                'domain'      => \Request::root(),
                'description' => $countryProduct->description,
            ]
        ];
        $showSystemTab = GroupCountry::getByCountryAndBrand(SessionHdl::getCountryID(), SessionHdl::getBrandID(), 2)->count() > 0;
        $nutritionalTableIds = !empty(config('settings::frontend.frontend.img_nutrimental')) ? explode(',', config('settings::frontend.frontend.img_nutrimental')) : [1];

        $categories=$this->category();

        $categories=$categories->original['brandCategories'][0]['categories'];

        $categories=$this->category();
        $categories=$categories->original['brandCategories'][0]['categories'];
        $cart=\session()->get('portal.cart');
        $latest=CountryProduct::getAllLatest( session()->get('portal.main.country_id'), App()->getLocale(), true, false);
        return View::make('shopping::frontend.product_detail', [
            'categories'          => $categories,
            'cart'=>$cart,
            'latest'=>$latest,
            'category'            => $category,
            'countryProduct'      => $countryProduct,
            'relatedProducts'     => $relatedProducts,
            'currency'            => SessionHdl::getCurrencyKey(),
            'socialTags'          => $socialTags,
            'showSystemTab'       => $showSystemTab,
            'nutritionalTableIds' => $nutritionalTableIds,
            'backgroundColor'     => $backgroundColor
        ]);
    }

    public function getCountryGroup(Request $request) {
        $response  = ['status' => false];
        $warehouse = SessionHdl::getWarehouse();

        if ($request->has('id')) {
            $countryGroup = GroupCountry::find($request->input('id'));
            $groupType    = $countryGroup->group_id == 2 ? 'system' : 'category';
            $totalPrice   = 0.0;

            if ($countryGroup != null) {

                $products = [];
                foreach ($countryGroup->groupProducts->where('active', 1) as $groupProduct) {
                    if ($groupProduct->countryProduct->product->is_kit == 0) {
                        $products[] = [
                            'name'   => $groupProduct->countryProduct->name,
                            'sku'    => $groupProduct->countryProduct->sku,
                            'price'  => $groupProduct->countryProduct->price,
                            'points' => $groupProduct->countryProduct->points,
                        ];

                        if (showCountryProduct($groupProduct->countryProduct, $warehouse) || showCountryProductByIP($groupProduct->countryProduct, $warehouse)) {
                            $totalPrice += $groupProduct->countryProduct->price;
                        }
                    }
                }

                $response['data'] = [
                    'id'          => $countryGroup->id,
                    'name'        => $countryGroup->name,
                    'description' => strip_tags($countryGroup->description),
                    'benefits'    => strip_tags($countryGroup->benefit),
                    'banner'      => asset($countryGroup->image),
                    'link'        => $countryGroup->link_banner_two,
                    'products'    => $products,
                    'total_price' => currency_format($totalPrice, SessionHdl::getCurrencyKey()),
                    'url_group'   => route(TranslatableUrlPrefix::getRouteName(SessionHdl::getLocale(), ['products', $groupType]), $countryGroup->slug),
                 ];
                $response['status'] = true;
            }
        }

        return $response;
    }

    private function getState() {
        if (SessionHdl::hasTypeWarehouse() && SessionHdl::getTypeWarehouse() == 'CITY') {
            return SessionHdl::getCorbizStateKey();
        } else {
            $common  = new CommonMethods();
            $country = Country::find(SessionHdl::getCountryID());

            $response = $common->getZipCodesFromCorbiz($country->webservice, $country->corbiz_key, SessionHdl::getCorbizLanguage(), SessionHdl::getZipCode());

            if ($response['status'] && isset($response['suggestions'][0]['data']['idState'])) {
                return $response['suggestions'][0]['data']['idState'];
            }
        }
    }
}
