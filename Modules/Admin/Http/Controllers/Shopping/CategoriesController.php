<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Modules\Admin\Entities\BrandCountry;
use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\Group;
use Modules\Shopping\Entities\BrandGroup;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\GroupProduct;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
      
        $categories                  = GroupCountry::where('group_id', 1)->where('active', '!=', -1)->groupBy('code')->get();

        $this->layoutData['modals']  = View::make('admin::shopping.products.modals.confirm');
        $this->layoutData['content'] = View::make('admin::shopping.categories.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {

        $userBrands = Auth::user()->userBrandsPermission();
        $locale     = Auth::user()->language->locale_key;
        $title      = trans('admin::shopping.categories.add.view.form-brand');

            $categories                  = GroupCountry::where('group_id', 1)->where('active', '!=', -1)->groupBy('code')->get();
      

        $countriesByBrand = [];
        foreach ($userBrands as $ub) {
            $countriesByBrand[$ub['id']] = [];
            foreach (BrandCountry::where('brand_id', $ub['id'])->get() as $country) {
                $countriesByBrand[$ub['id']][] = $country->country_id;
            }
        }
        $countriesByBrand = \GuzzleHttp\json_encode($countriesByBrand);

        $colorsOmnilife = !empty(config('settings::frontend.color.omnilife')) ? explode(',', config('settings::frontend.color.omnilife')) : [];
        $colorsSeytu    = !empty(config('settings::frontend.color.seytu')) ? explode(',', config('settings::frontend.color.seytu')) : [];
        
        $this->layoutData['modals']  = View::make('admin::shopping.categories.modals.brand', compact('userBrands', 'title'));
        $this->layoutData['content'] = View::make('admin::shopping.categories.create', compact('locale', 'countriesByBrand', 'colorsSeytu', 'colorsOmnilife','categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        $codeCat    = "";



        foreach (Auth::user()->countries as $uC) {
            $products   = "products_".$uC->id;
            $active     = "active_".$uC->id;
            $bannerLink = "bannerLink_".$uC->id;
            $order      = "order_".$uC->id;

            if ($request->$active != null) {
                $idCat = $this->saveCategoryCountry($uC->id, $request->$bannerLink, $request->$active, $request->$order,$request->parent_category);
                if ($idCat > 0) {
                    if ($codeCat == "") {
                        $codeCat = $idCat;
                    }

                    GroupCountry::where('id', $idCat)->update(['code'=> 'CAT'.$codeCat, 'global_name' => $request->input('global_name'), 'color' => $request->input('color_'.$uC->id)]);
                    $idCategoryBrand = BrandGroup::saveInfo($request->brand_id,$idCat, 1);

                    if (isset($idCategoryBrand)) {
                        $resInfoCategory = $this->saveInfoCategory($uC->id, $idCat, $request, $active, $products);
                        if ($resInfoCategory != 1) {
                            return back()->withInput()->withErrors(array('msg' => $resInfoCategory));
                        }
                    }

                } else {
                    return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.categories.add.error.controller-country')));
                }
            }
        }
        return redirect()->route('admin.categories.index')->with('msg', trans('admin::shopping.categories.add.error.controller-success'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {
        $categoriesByCountry = GroupCountry::where('code', $id)->whereIn('country_id', User::userCountriesPermission())->get();
        $code                = $id;
        $globalName          = $categoriesByCountry->first()->global_name;
        $brand               = $categoriesByCountry->first()->brandGroup->brand;

        $title = trans('admin::shopping.categories.add.view.form-countries');

        $colors = [];
        if ($brand->id == 1) {
            $colors = !empty(config('settings::frontend.color.omnilife')) ? explode(',', config('settings::frontend.color.omnilife')) : [];
        } else if ($brand->id == 2) {
            $colors = !empty(config('settings::frontend.color.seytu')) ? explode(',', config('settings::frontend.color.seytu')) : [];
        }

        $countriesByBrand = [];
        foreach (BrandCountry::where('brand_id', $brand->id)->get() as $country) {
            $countriesByBrand[] = $country->country_id;
        }

        $anotherCountries = Auth::user()->countries;
        $anotherCountries = $anotherCountries->reject(function ($country) use ($categoriesByCountry, $countriesByBrand) {
            foreach ($categoriesByCountry as $categoryByCountry) {
                if ($country->id == $categoryByCountry->country_id) {
                    return true;
                }

                if (!in_array($country->id, $countriesByBrand)) {
                    return true;
                }
            }
        });

        $products = [];
        foreach ($categoriesByCountry as $categoryByCountry) {
            $productsJSON = [];
            foreach ($categoryByCountry->groupProducts->where('active', 1) as $p) {
                //var_dump($p->product_id);
                //die();
                $object = (object) [
                    'id'       => $p->product_id,
                    'sku'      => $p->countryProduct->product->sku,
                    'favorite' => $p->product_home,
                    'home'     => 0,
                    'category' => $p->product_category,
                ];
                if ($categoryByCountry->product_id_featured == $p->product_id){
                    $object->home = 1;
                }
                array_push($productsJSON, $object);
            }
            $products[$categoryByCountry->country_id] = json_encode($productsJSON);
        }

        $this->layoutData['modals']  = View::make('admin::shopping.categories.modals.country', ['title' => $title, 'groupsByCountry' => $categoriesByCountry, 'anotherCountries' => $anotherCountries]);
        $this->layoutData['content'] = View::make('admin::shopping.categories.edit', compact('categoriesByCountry', 'code', 'brand', 'products', 'countriesByBrand', 'anotherCountries', 'globalName', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $countryGroup = GroupCountry::whereIn('country_id', User::userCountriesPermission())->where('group_id', 1)->get();

        foreach (Auth::user()->countries as $uC)
        {
            $code         = "code_".$uC->id;
            $active       = "active_".$uC->id;
            $bannerLink   = "bannerLink_".$uC->id;
            $product      = "products_".$uC->id;
            $order        = "order_".$uC->id;
            $infoCategory = GroupCountry::where('country_id', $uC->id)->where('code', $request->$code)->first();

            if (isset($infoCategory)) {
                GroupCountry::where('id', $infoCategory->id)->update(['link_banner' => $request->$bannerLink, 'global_name' => $request->input('global_name'),
                    'color' => $request->input('color_'.$uC->id), 'order' => $request->$order, 'active' => $request->$active]);

                BrandGroup::where('country_group_id', $infoCategory->id)->update(['brand_id' => $request->brand_id]);

                $resProductCat = $this->updateCategoryProduct($infoCategory->id, json_decode($request->$product),$request->$active);
                if ($resProductCat != 1){
                    return back()->withInput()->withErrors(array('msg' => $resProductCat));
                }

                foreach ($uC->languages as $countryLang) {
                    $name        = 'category_'.$uC->id.'_'.$countryLang->language->id;
                    $description = 'description_'.$uC->id.'_'.$countryLang->language->id;
                    $imageBanner = 'image_'.$uC->id.'_'.$countryLang->language->id;

                    if (!empty($request->$name)) {
                        $infoCategory->translateOrNew($countryLang->language->locale_key)->name         = $request->$name;
                        $infoCategory->translateOrNew($countryLang->language->locale_key)->description  = nl2br($request->$description);
                        $infoCategory->translateOrNew($countryLang->language->locale_key)->image_banner = $request->$imageBanner;
                        $infoCategory->translateOrNew($countryLang->language->locale_key)->slug         = str_slug(strip_tags($request->$name), '-', $countryLang->language->locale_key);
                    }
                }

                $infoCategory->update();
            } else {
                if ($request->$active != null) {
                    $idCat = $this->saveCategoryCountry($uC->id, $request->$bannerLink, $request->$active, $request->$order,$request->parent_category);
                    if ($idCat > 0) {
                        GroupCountry::where('id', $idCat)->update(['code'=> $request->input('code'), 'color' => $request->input('color_'.$uC->id)]);
                        $idCategoryBrand = BrandGroup::saveInfo($request->brand_id, $idCat, 1);

                        if (isset($idCategoryBrand)) {
                            $resInfoCategory = $this->saveInfoCategory($uC->id, $idCat, $request, $active, $product);
                            if ($resInfoCategory != 1) {
                                return back()->withInput()->withErrors(array('msg' => $resInfoCategory));
                            }
                        }
                    } else {
                        return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.categories.edit.error.controller-success')));
                    }
                }
            }
        }
        return redirect()->route('admin.categories.index')->with('msg', trans('admin::shopping.categories.edit.error.controller-success'));
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {
        $category = GroupCountry::where('code', $request->code)->get();
        foreach ($category as $c){
            $c->last_modifier_id = Auth::user()->id;
            $c->active = -1;
            $c->save();
        }
        return redirect()->route('admin.categories.index')->with('msg', trans('admin::shopping.categories.edit.error.controller-success'));
    }

    public function changeStatus(Request $request) {
        if ($request->has('code') && $request->has('type')) {
            $category = GroupCountry::where('code', $request->input('code'))->get();

            if ($request->input('type') == 'activate') {
                foreach ($category as $c){
                    $c->last_modifier_id = Auth::user()->id;
                    $c->active = 1;
                    $c->save();
                }
            } else if ($request->input('type') == 'deactivate') {
                foreach ($category as $c){
                    $c->last_modifier_id = Auth::user()->id;
                    $c->active = 0;
                    $c->save();
                }
            }

            return redirect()->route('admin.categories.index')->with('msg', trans('admin::shopping.categories.edit.error.controller-success'));
        }
    }

    /**
     * @param $idCategory
     * @param $product
     * @param $active
     * @return array|\Illuminate\Contracts\Translation\Translator|int|null|string
     */
    private function updateCategoryProduct($idCategory, $product, $active)
    {
        GroupProduct::where('country_group_id',$idCategory)->update(['active' => 0]);
        foreach ($product as $p){
            if($p->home == 1){
                GroupCountry::where('id', $idCategory)->update(['product_id_featured' => $p->id, 'active' => $active]);
            }
            $idCategoryProduct = GroupProduct::saveInfo($idCategory,$p->id,$p->favorite,$p->category,1);
            if(!isset($idCategoryProduct)){
                return trans('admin::shopping.categories.edit.error.controller-category-product');
            }
        }
        return 1;
    }

    /**
     * @param $idCountry
     * @param $idCountryCategory
     * @param $request
     * @param $active
     * @param $product
     * @return int|string
     */
    private function saveInfoCategory($idCountry , $idCountryCategory, $request, $active, $product)
    {
        $category = GroupCountry::find($idCountryCategory);

        foreach(Auth::user()->getCountryLang($idCountry) as $langCountry) {
            $name        = 'category_'.$idCountry.'_'.$langCountry->id;
            $description = 'description_'.$idCountry.'_'.$langCountry->id;
            $imageBanner = 'image_'.$idCountry.'_'.$langCountry->id;

            if (!empty($request->$name)) {
                $category->translateOrNew($langCountry->locale_key)->name         = $request->$name;
                $category->translateOrNew($langCountry->locale_key)->description  = nl2br($request->$description);
                $category->translateOrNew($langCountry->locale_key)->image_banner = $request->$imageBanner;
                $category->translateOrNew($langCountry->locale_key)->slug         = str_slug(strip_tags($request->$name), '-', $langCountry->locale_key);
                $idCategoryTranslation = $category->id;
            } else {
                $idCategoryTranslation = 1;
            }

            $category->save();

            if (isset($idCategoryTranslation)) {
                if ($request->$product != null) {
                    $resProdCat = $this->saveProductCategory($idCountryCategory, json_decode($request->$product));
                    if ($resProdCat != 1){
                        return $resProdCat;
                    }
                }
            } else {
                return trans('admin::shopping.categories.add.error.controller-info');
            }
        }
        return 1;
    }

    /**
     * @param $idCountryCategory
     * @param $product
     * @return int
     */
    private function saveProductCategory($idCountryCategory, $product)
    {
        foreach ($product as $prodCat)
        {
            if($prodCat->home == 1){
                GroupCountry::where('id', $idCountryCategory)->update(['product_id_featured' => $prodCat->id]);
            }
            $idCategoryProduct = GroupProduct::saveInfo($idCountryCategory,$prodCat->id,$prodCat->favorite,$prodCat->category,1);
            if($idCategoryProduct == null)
                return trans('admin::shopping.categories.add.error.controller-product');
        }
        return 1;
    }

    /**
     * @param $countryId
     * @param $active
     * @return int
     */
    
    private function saveCategoryCountry($countryId, $bannerLink, $active, $order,$parent_id=0)
    {
        $groupCountry = new GroupCountry();       
        $groupCountry->country_id = $countryId;
        $groupCountry->group_id = $this->getIdCategories();
        $groupCountry->link_banner = $bannerLink;
        $groupCountry->order = $order;
        $groupCountry->parent=$parent_id;
        $groupCountry->active = $active;
        $groupCountry->last_modifier_id = Auth::user()->id;
        $groupCountry->save();
        return $groupCountry->id;
    }

    /**
     * @return mixed
     */
    private function getIdCategories()
    {
        $catId = Group::where('type', 'Categories')->first();
        return $catId->id;
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //return view('admin::show');
    }

    public function getProductsByBrandAndCountry(Request $request) {
        $response = ['status' => false];

        if ($request->has('brand_id')) {
            $countries = [];
            foreach (Auth::user()->countries as $country) {
                $countries[] = [
                    'countryId' => $country->id,
                    'brandId'   => $request->input('brand_id'),
                    'products'  => Auth::user()->activeProductsByCountryAndBrand($country->id, $request->input('brand_id'))
                ];
            }

            $response['status'] = true;
            $response['data']   = $countries;
        }

        return $response;
    }

    public function getCountriesByBrandAndUser(Request $request) {
        $response = ['status' => false];

        if ($request->has('brand_id')) {
            $countriesByBrand = [];
            foreach (BrandCountry::where('brand_id', $request->input('brand_id'))->get() as $country) {
                if (in_array($country->country_id, User::userCountriesPermission())) {
                    $langs = [];
                    foreach ($country->country->languages as $l) {
                        $langs[] = [
                            'id'        => $l->language->id,
                            'name'      => $l->language->language,
                            'localeKey' => $l->language->locale_key,
                        ];
                    }

                    $countriesByBrand[] = [
                        'id'        => $country->country_id,
                        'name'      => $country->country->name,
                        'languages' => htmlspecialchars(json_encode($langs)),
                    ];
                }
            }

            $response['status'] = true;
            $response['countriesByBrand'] = $countriesByBrand;
        }

        return $response;
    }
}
