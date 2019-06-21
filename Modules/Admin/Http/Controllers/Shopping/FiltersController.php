<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\CountryTranslation;
use Modules\Admin\Http\Requests\FiltersRequest;
use Modules\Shopping\Entities\CategoryFilter;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\WarehouseCountry;
use Modules\Shopping\Entities\WarehouseProduct;
use PhpParser\Node\Expr\Cast\Object_;
use View;
use Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Entities\ACL\User;
use Modules\Shopping\Entities\Group;
use Modules\Shopping\Entities\BrandGroup;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\GroupProduct;
use Modules\Shopping\Entities\GroupTranslations;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class FiltersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $filters                     = GroupCountry::getByCountriesAndBrands(User::userCountriesPermission(), User::userBrandId(), $this->getIdFilters());
        $this->layoutData['modals']  = View::make('admin::shopping.products.modals.confirm');
        $this->layoutData['content'] = View::make('admin::shopping.filters.index', compact('filters'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $userBrands = Auth::user()->userBrandsPermission();
        $locale     = Auth::user()->language->locale_key;
        $title      = trans('admin::shopping.filters.view.title_popup');

        $countriesByBrand = [];
        foreach ($userBrands as $ub) {
            $countriesByBrand[$ub['id']] = [];
            foreach (BrandCountry::where('brand_id', $ub['id'])->get() as $country) {
                $countriesByBrand[$ub['id']][] = $country->country_id;
            }
        }
        $countriesByBrand = \GuzzleHttp\json_encode($countriesByBrand);

        $this->layoutData['modals']  = View::make('admin::shopping.filters.modals.brand', compact('userBrands', 'title'));
        $this->layoutData['content'] = View::make('admin::shopping.filters.create', compact('locale', 'countriesByBrand'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $codeCat = "";
        $countries = explode(",", $request->countries_brand);
        foreach ($countries as $uC)
        {
            $idFilter = $this->saveFilterCountry($uC, null,null, null, $request->active[$uC]);
            if($idFilter > 0){
                if($codeCat == ""){ $codeCat = $idFilter; }
                GroupCountry::where('id', $idFilter)->update(['code'=> 'FIL'.$codeCat, 'global_name' => $request->input('global_name')]);
                BrandGroup::saveInfo($request->brand_id,$idFilter, 1);
                $resInfoCategory = $this->saveInfoFilter($uC, $idFilter, $request);
                if($resInfoCategory != 1){return back()->withInput()->withErrors(array('msg' => $resInfoCategory));}
            }else{
                return back()->withInput()->withErrors(array('msg' => trans('admin::shopping.filters.error.controller-country')));
            }
        }
        return redirect()->route('admin.filters.index')->with('msg', trans('admin::shopping.filters.error.controller-success'));
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
        $title = trans('admin::shopping.filters.view.title_edit');
        $anotherCountries = Auth::user()->countries;
        $anotherCountries = $anotherCountries->reject(function ($country) use ($categoriesByCountry) {
            foreach ($categoriesByCountry as $categoryByCountry) {
                if ($country->id == $categoryByCountry->country_id) {
                    return true;
                }
            }
        });
        $countriesByBrand = [];
        foreach (BrandCountry::where('brand_id', $brand->id)->get() as $country) {
            $countriesByBrand[] = $country->country_id;
        }
        $products = [];
        $this->layoutData['modals']  = View::make('admin::shopping.filters.modals.country', ['title' => $title, 'groupsByCountry' => $categoriesByCountry, 'anotherCountries' => $anotherCountries]);
        $this->layoutData['content'] = View::make('admin::shopping.filters.edit', compact('categoriesByCountry', 'code', 'brand', 'products', 'countriesByBrand', 'anotherCountries', 'globalName'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $countries = explode(",", $request->countries_brand);
        foreach ($countries as $uC)
        {
            $infoGroup = GroupCountry::where('country_id', $uC)->where('code', $request->code)->first();
            if (!isset($infoGroup)) {
                $idFilter = $this->saveFilterCountry($uC, $request->code, null, null, $request->active[$uC]);
                BrandGroup::saveInfo($request->brand_id,$idFilter, 1);
                $infoGroup = GroupCountry::where('country_id', $uC)->where('code', $request->code)->first();
            }
            GroupCountry::where('id',$infoGroup->id)->update(['active' => $request->active[$uC], 'global_name' => $request->input('global_name')]);
            foreach (Country::find($uC)->languages as $countryLang) {
                $name = $request->filter[$uC][$countryLang->language->id];
                if (!empty($name)) {
                    $infoGroup->translateOrNew($countryLang->language->locale_key)->name = $name;
                }
            }
            $infoGroup->save();
        }
        return redirect()->route('admin.filters.index')->with('msg', trans('admin::shopping.filters.error.controller-success'));
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {
        $system = GroupCountry::where('code', $request->code)->get();
        foreach ($system as $c){
            $c->last_modifier_id = Auth::user()->id;
            $c->active = -1;
            $c->save();
        }
        return redirect()->route('admin.filters.index')->with('msg', trans('admin::shopping.filters.error.controller-success'));
    }

    public function changeStatus(Request $request) {
        if ($request->has('code') && $request->has('type')) {
            $system = GroupCountry::where('code', $request->input('code'))->get();

            if ($request->input('type') == 'activate') {
                foreach ($system as $c){
                    $c->last_modifier_id = Auth::user()->id;
                    $c->active = 1;
                    $c->save();

                    CategoryFilter::where('filter_country_id', $c->id)->update(['active' => 1]);
                }
            } else if ($request->input('type') == 'deactivate') {
                foreach ($system as $c){
                    $c->last_modifier_id = Auth::user()->id;
                    $c->active = 0;
                    $c->save();

                    CategoryFilter::where('filter_country_id', $c->id)->update(['active' => 0]);
                }
            }

            return redirect()->route('admin.filters.index')->with('msg', trans('admin::shopping.filters.error.controller-success'));
        }
    }

    /**
     * @param $idCountry
     * @param $idCountryCategory
     * @param $request
     * @param $active
     * @param $product
     * @return int|string
     */
    private function saveInfoFilter($idCountry , $idCountryCategory, $request)
    {
        $filter = GroupCountry::find($idCountryCategory);
        foreach(Auth::user()->getCountryLang($idCountry) as $langCountry) {
            if (!empty($request->filter[$idCountry][$langCountry->id])) {
                $filter->translateOrNew($langCountry->locale_key)->name = $request->filter[$idCountry][$langCountry->id];
            } else {
            }
            $filter->save();
        }
        return 1;
    }

    /**
     * @param $countryId
     * @param $link_one
     * @param $link_two
     * @param $active
     * @return mixed
     */
    private function saveFilterCountry($countryId,$code, $link_one, $link_two, $active)
    {
        $groupCountry = new GroupCountry();
        $groupCountry->country_id = $countryId;
        $groupCountry->group_id = $this->getIdFilters();
        $groupCountry->code = $code;
        $groupCountry->link_banner = $link_one;
        $groupCountry->link_banner_two = $link_two;
        $groupCountry->active = $active;
        $groupCountry->last_modifier_id = Auth::user()->id;
        $groupCountry->save();
        return $groupCountry->id;
    }

    /**
     * @return mixed
     */
    private function getIdFilters()
    {
        $catId = Group::where('type', 'Filters')->first();
        return $catId->id;
    }

    /* Section to assign filters */
    /**
     * @param $code
     * @param $idCountry
     * @param $idCategory
     */
    public function filtersShow($code, $idCountry, $idCategory)
    {
        $filter = GroupCountry::where('code', $code)->first();

        // Array de paises donde esta activado el filtro
        $countryUser = $this->getArrayCountry(GroupCountry::whereIn('country_id', User::userCountriesPermission())->where('code',$code)->where('active',1)->get(), 'country');
        $countryUserSelected = $idCountry == 0 ? key($countryUser) : $idCountry;

        // Array de categorias del pais seleccionado
        $categoryXbrand = GroupCountry::select('shop_country_groups.*')->join('shop_brand_group','shop_country_groups.id','shop_brand_group.country_group_id')
            ->where('shop_brand_group.brand_id', $filter->brandGroup->brand_id)
            ->where('country_id', $countryUserSelected)
            ->where('shop_country_groups.active', 1)
            ->where('group_id',$this->getIdCategories())->get();

        $categoryCountry = $this->getArray($categoryXbrand, 'category');
        $categoryCountrySelected = $idCategory == 0 ? key($categoryCountry) : $idCategory;

        // Array de productos que ya estan en la categoria por pais
        $filter = GroupCountry::where('country_id' , $countryUserSelected)->where('code' , $code)->first();
        $filterProducts = GroupProduct::where('country_group_id' , $filter->id)->where('category_id' , $categoryCountrySelected)
            ->where('active' , 1)->get();
        $categoryProducts = $this->getArray($this->getArrayProductsCategory(GroupProduct::whereHas('countryProduct', function ($q) {
            $q->whereHas('product', function ($q) {
                $q->where('is_kit', 0);
            });
        })->where('country_group_id' , $categoryCountrySelected)->where('active', 1)->get(), $filterProducts),'product');

        $this->layoutData['content'] = View::make('admin::shopping.filters.filters', compact('countryUser',
            'countryUserSelected', 'categoryCountry', 'categoryCountrySelected', 'categoryProducts', 'filterProducts',
            'filter'));
    }

    /**
     * @param Request $request
     * @param FiltersRequest $filtersRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filtersCreate(Request $request, FiltersRequest $filtersRequest){
        $reqFilterCategory = $this->saveFilterCategory($request->filter_id,$request->category_id);
        $reqFilterProduct = $this->saveFilterProduct($request->filter_id,$request->product_id,$request->category_id);
        if(is_null($reqFilterCategory) || is_null($reqFilterProduct))
        {
            return redirect()
                ->route('admin.filters.categoriesshow', ['code' => $request->filter_code, 'idCountry' => $request->country_id, 'idCategory' => $request->category_id])
                ->with('msg', trans('admin::shopping.filters.message.success.filter_category'))
                ->with('alert', 'alert-warning');

        }
        return redirect()
            ->route('admin.filters.categoriesshow', ['code' => $request->filter_code, 'idCountry' => $request->country_id, 'idCategory' => $request->category_id])
            ->with('msg', trans('admin::shopping.filters.message.success.filter_category'))
            ->with('alert', 'alert-success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filtersDelete(Request $request)
    {
        $product = GroupProduct::find($request->id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = -1;
        $product->save();
        return redirect()
            ->route('admin.filters.categoriesshow', ['code' => $request->filter_code, 'idCountry' => $request->country_id, 'idCategory' => $request->category_id])
            ->with('msg', trans('admin::shopping.filters.message.success.filter_category'))
            ->with('alert', 'alert-success');
    }

    /**
     * @param $idFilter
     * @param $idCategory
     * @return mixed
     */
    private function saveFilterCategory($idFilter, $idCategory){
        return CategoryFilter::updateOrCreate(
            ['category_country_id' => $idCategory, 'filter_country_id' => $idFilter],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id ]
        );
    }

    /**
     * @param $idFilter
     * @param $idProduct
     * @param $idCategoy
     * @return mixed
     */
    private function saveFilterProduct($idFilter, $idProduct, $idCategoy){
        return GroupProduct::updateOrCreate(
            ['country_group_id' => $idFilter, 'product_id' => $idProduct, 'category_id' => $idCategoy],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id ]
        );
    }

    /**
     * @param $catProducts
     * @param $filProducts
     * @return mixed
     */
    private function getArrayProductsCategory($catProducts, $filProducts)
    {
        foreach ($catProducts as $key => $c) {
            if ($c->active == 1 && $c->countryProduct->active == 1 && $c->countryProduct->delete == 0 && $c->countryProduct->product->active == 1 && $c->countryProduct->product->delete == 0) {
                foreach ($filProducts as $f){
                    if($c->product_id == $f->product_id){ unset($catProducts[$key]); }
                }
            }
        }
        return $catProducts;
    }

    /**
     * @param $country
     * @return array
     */
    private function getArrayCountry($country, $val){
        $countries = [];
        foreach ($country as $c){
            if($val == 'country'){
                $countries[$c->country->id] = $c->country->name;
            }else{
                $countries[$c->id] = $c->$val;
            }
        }
        return $countries;
    }

    /**
     * @param $array
     * @param $type
     * @return array
     */
    private function getArray($array, $type){
        $data = [];
        foreach ($array as $a){
            switch ($type) {
                case 'category':
                    $data[$a->id] = $a->code. " - " .$a->global_name;
                    break;
                case 'product':
                    $data[$a->countryProduct->id] = $a->countryProduct->product->sku. " - " .$a->countryProduct->product->global_name;
                    break;
                case 2:
                    echo "i equals 2";
                    break;
            }
        }
        return $data;
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
}
