<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use function htmlspecialchars;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Http\Requests\ProductUploadRequest;

use Modules\Admin\Http\Requests\WarehousesRequest;
use Modules\Shopping\Entities\GroupCountry;
use Modules\Shopping\Entities\WarehouseCountry;
use Modules\Shopping\Entities\WarehouseProduct;
use View;
use Session;
use Modules\Admin\Entities\ACL\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Shopping\Entities\Product;
use Modules\Shopping\Entities\BrandProduct;
use Modules\Shopping\Entities\GroupProduct;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\ProductTranslation;
use Modules\Shopping\Entities\ComplementaryProducts;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {


        $countryProducts = CountryProduct::groupBy('product_id')->where('delete', 0)->get();
        $this->layoutData['modals']  = View::make('admin::shopping.products.modals.confirm').View::make('admin::shopping.products.modals.load_csv', ['countries' => Auth::user()->countries]);
        $this->layoutData['content'] = View::make('admin::shopping.products.index', compact('countryProducts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        // Armar array de paises con sus lenguajes en que tiene permisos el usuario
        $countryUser = Product::userPermissionCountryLanguage();
        // Armar array de marcas en que tiene permisos el usuario
        $brandsUser = Product::userPermissionBrandsLanguage();
        //dd($countryUser[0]['categories']);

        $locale = Auth::user()->language->locale_key;
        $this->layoutData['content'] = View::make('admin::shopping.products.create', compact('countryUser', 'brandsUser', 'locale'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $datos = $request->all();
        $product_id = $this->saveProduct($id = null, $datos['sku'], $datos['isKit'], $datos['globalName'], $active = true);
        $this->saveProductBrand($datos['brandId'], $product_id, $active = true);
        $this->saveProductCountry($product_id, $datos['countries'], $active = true);
        if(!empty($product_id)){
            $this->saveRelatedProducts($product_id, $datos['countries'], $active = true);
        }

        return response()->json(true);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        // Armar array de paises con sus lenguajes en que tiene permisos el usuario
        $countryUser = Product::userPermissionCountryLanguage();

        // Armar array de marcas en que tiene permisos el usuario
        $brandsUser = Product::userPermissionBrandsLanguage();

        // Mandar informacion con los datos del producto que se editara
        $product          = Product::returnInfo($id);
        $prods            = [];
        $prods['product'] = [];

        foreach ($product['countries'] as $cC) {
            $complementaryProducts = ComplementaryProducts::join('shop_country_products','shop_country_products.id','=','shop_complementary_products.product_related_id')
                ->join('shop_products','shop_products.id','=','shop_country_products.product_id')
                ->where('shop_complementary_products.product_id','=',$id)
                ->where('shop_complementary_products.country_id','=',$cC['countryId'])
                ->where('shop_complementary_products.active','=',1)
                ->select('shop_complementary_products.id as id','shop_complementary_products.product_id as product_id','shop_complementary_products.country_id as country_id','shop_complementary_products.product_id','shop_products.sku as sku','shop_complementary_products.product_related_id as product_related_id')
                ->get();

            $prodJSON = [];
            foreach ($complementaryProducts as $p) {
                $object = (object) [
                    'id'          => $p->id,
                    'id_product'  => $p->product_id,
                    'id_related'  => $p->product_related_id,
                    'sku'         => $p->sku,
                    'global_name' => $p->global_name,
                    'country'     => $p->country_id

                ];
                array_push($prodJSON,$object);
            }
            $prods['product'][$cC['countryId']] = json_encode($prodJSON);
        }
        $this->layoutData['content'] = View::make('admin::shopping.products.edit', compact('countryUser', 'brandsUser','product','prods'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $datos = $request->all();
        $product_id = $this->saveProduct($id = null, $datos['sku'], $datos['isKit'], $datos['globalName'], $active = true);
        $this->saveProductBrand($datos['brandId'], $product_id, $active = true);

        $this->saveProductCountry($product_id, $datos['countries'], $active = true);
        if(!empty($product_id)){
            $this->saveRelatedProducts($product_id, $datos['countries'], $active = true,null);
        }
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy()
    {
        return false;
    }

    private function on($id) {
        $product = Product::find($id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = 1;
        $product->save();

        # Activa el producto por categoría
        GroupProduct::whereHas('countryProduct', function ($q) use ($id) {
            $q->where('product_id', $id);
        })->update(['active' => 1]);

        # Activa el producto por país
        CountryProduct::where('product_id', $id)
            ->update(['active' => 1]);

        # Activa el producto como base de complementos
        ComplementaryProducts::where('product_id', $id)
            ->update(['active' => 1]);

        # Activa el producto como complemento
        ComplementaryProducts::whereHas('relatedProduct', function ($q) use ($id) {
            $q->where('product_id', $id);
        })->update(['active' => 1]);
    }

    private function off($id) {
        $product = Product::find($id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = 0;
        $product->save();

        # Descactiva el producto por categoría
        GroupProduct::whereHas('countryProduct', function ($q) use ($id) {
            $q->where('product_id', $id);
        })->update(['active' => 0, 'product_home' => 0, 'product_category' => 0]);

        # Desactiva el producto por país
        CountryProduct::where('product_id', $id)
            ->update(['active' => 0]);

        # Desactiva el producto como base de complementos
        ComplementaryProducts::where('product_id', $id)
            ->update(['active' => 0]);

        # Desactiva el producto como complemento
        ComplementaryProducts::whereHas('relatedProduct', function ($q) use ($id) {
            $q->where('product_id', $id);
        })->update(['active' => 0]);
    }

    public function changeStatus(Request $request) {
        if ($request->has('type') && $request->has('id')) {
            if ($request->input('type') == 'activate') {
                $this->on($request->input('id'));
                return response()->json(['success' => true, 'status' => 'on']);
            } else if ($request->input('type') == 'deactivate') {
                $this->off($request->input('id'));
                return response()->json(['success' => true,'status' => 'off']);
            } else {
                return response()->json(['success' => false,'status' => 'off']);
            }
        } else {
            return response()->json(['success' => false,'status'=>'off']);
        }
    }

    /**
     * @param $id
     */
    public function listWarehouses($id)
    {
        $productCountry = CountryProduct::whereIn('country_id', User::userCountriesPermission())->where('product_id',$id)->get();
        if(is_null($productCountry)){
            //return redirect('admin/products')->with('msg', trans('admin::shopping.warehouses.error.controller-success'));
            return redirect()->route('admin/products')->with('msg', 'You do not have permits in any country of the assigned warehouses');
        }

        $productCountryId = $productCountry[0]->id;
        $countryUserSelected = $productCountry[0]->country_id;
        $productName = $productCountry[0]->product->sku . " - " . $productCountry[0]->name;

        $countryUser = $this->getArrayProductCountryUser($productCountry,$this->getArrayCountry(Auth::user()->countries, 'name'));

        $warehousesAvailable = $this->getArrayCountry(WarehouseCountry::where('country_id',$countryUserSelected)->where('active',1)->get(), 'warehouse');
        $selectedWarehousesProduct = WarehouseProduct::select('*', 'shop_warehouse_products.active as activeRow', 'shop_warehouse_products.id as idRow')
            ->join('shop_country_warehouses','shop_warehouse_products.country_warehouse_id','shop_country_warehouses.id')
            ->where('shop_country_warehouses.country_id',$countryUserSelected)
            ->where('shop_warehouse_products.product_country_id',$productCountryId)
            ->where('shop_warehouse_products.active','!=',-1)
            ->get();

        foreach ($selectedWarehousesProduct as $sWP) {
            if (isset($warehousesAvailable[$sWP->country_warehouse_id])) {
                unset($warehousesAvailable[$sWP->country_warehouse_id]);
            }
        }
        $this->layoutData['content'] = View::make('admin::shopping.products.warehouses', compact('id',
            'productName', 'countryUser', 'selectedWarehousesProduct', 'warehousesAvailable', 'productCountryId',
            'countryUserSelected'));
    }

    private function getArrayProductCountryUser($productCountry,$countryUser){
        $prodCountry = [];
        foreach ($productCountry as $c){
            $prodCountry[$c->country_id] = $c->product_id;
        }
        $countryDelete = array_diff_key($countryUser, $prodCountry);
        foreach ($countryUser as $k => $cu1){
            foreach ($countryDelete as $ke => $cd1){
                if($k == $ke){ unset($countryUser[$ke]); };
            }
        }
        return $countryUser;
    }

    /**
     * @param Request $request
     * @param WarehousesRequest $warehousesRequest
     */
    public function warehousesCreate(Request $request, WarehousesRequest $warehousesRequest){
        WarehouseProduct::updateOrCreate(
            ['country_warehouse_id' => $request->warehouse, 'product_country_id' => $request->id_country_product,
             'product_id'=> $request->id_product],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id ]
        );
        $this->viewWerehouses($request->id_product, $request->id_country_product, $request->id_country);
    }

    /**
     * @param Request $request
     */
    public function warehousesList(Request $request){
        $this->viewWerehouses($request->id_product, $request->id_country_product, $request->id_country);
    }

    /**
     * @param $id
     * @param $id_country_product
     * @param $id_country
     */
    public function viewWerehouses($id, $id_country_product, $id_country)
    {
        $countryUserSelected = $id_country;

        $productCountry      = CountryProduct::where('product_id', $id)->where('country_id', $id_country)->first();
        $productCountryId    = $productCountry->id;
        $productName         = $productCountry->product->sku. " - " .$productCountry->name;

        $productCountry1     = CountryProduct::where('product_id', $id)->get();
        $countryUser         = $this->getArrayProductCountryUser($productCountry1,$this->getArrayCountry(Auth::user()->countries, 'name'));

        $warehousesAvailable = $this->getArrayCountry(WarehouseCountry::where('country_id',$countryUserSelected)->where('active',1)->get(), 'warehouse');
        $selectedWarehousesProduct = WarehouseProduct::select('*', 'shop_warehouse_products.active as activeRow', 'shop_warehouse_products.id as idRow')
            ->join('shop_country_warehouses','shop_warehouse_products.country_warehouse_id','shop_country_warehouses.id')
            ->where('shop_country_warehouses.country_id',$countryUserSelected)
            ->where('shop_warehouse_products.product_country_id',$productCountryId)
            ->where('shop_warehouse_products.active','!=',-1)
            ->get();

        foreach ($selectedWarehousesProduct as $sWP) {
            if (isset($warehousesAvailable[$sWP->country_warehouse_id])) {
                unset($warehousesAvailable[$sWP->country_warehouse_id]);
            }
        }

        $this->layoutData['content'] = View::make('admin::shopping.products.warehouses', compact('id',
            'productName', 'countryUser', 'selectedWarehousesProduct', 'warehousesAvailable', 'productCountryId',
            'countryUserSelected'));
    }

    public function warehousesOff(Request $request)
    {
        $product = WarehouseProduct::find($request->id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = 0;
        $product->save();
        return response()->json(['success' => true, 'id'=>$request->id]);
    }

    public function warehousesOn(Request $request)
    {
        $product = WarehouseProduct::find($request->id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = 1;
        $product->save();
        return response()->json(['success' => true, 'id'=>$request->id]);
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function warehousesDelete(Request $request)
    {

        $product = WarehouseProduct::find($request->id);
        $product->last_modifier_id = Auth::user()->id;
        $product->active = -1;
        $product->save();

        #return redirect()->route('admin.products.listWarehouses', $request->id_product);
        $this->viewWerehouses($request->id_product, $request->id_country_product, $request->id_country);
    }

    public function uploadFile(Request $request, ProductUploadRequest $productUploadRequest) {
        $csvContent         = $this->readCSV($request->file('file_csv')->path());
        $response['data']   = $this->validaInfo($request->input('country'), $csvContent);
        $response['status'] = false;
        //dd($response['data']);
        return $response;
    }

    private function validaInfo($countryId, $csvContent)
    {
        $results = [];
        if (sizeof($csvContent) > 0) {
            foreach ($csvContent as $i => $product) {
                if (!is_null($product['sku']) && !is_null($product['price']) && !is_null($product['points']) && !is_null($product['status'])) {
                    if(is_numeric($product['price']) && $product['price'] > 0 ){
                        if(is_numeric($product['points'])){
                            if((is_numeric($product['status'])) && ($product['status'] == 0 || $product['status'] == 1)){
                                $res = $this->saveInfo($countryId,$product,$i);
                                $results[$i] = $res;
                            }else{
                                $results[$i] = ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.error.status'), 'class' => 'danger'];
                            }
                        }else{
                            $results[$i] = ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.error.point'), 'class' => 'danger'];
                        }
                    }else{
                        $results[$i] = ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.error.price'), 'class' => 'danger'];
                    }
                }else{
                    $results[$i] = ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];
                }
            }
        }else
        {
            $results[] = ['line' => 0, 'message' => trans('admin::shopping.products.updateproduct.error.empty_file'), 'class' => 'danger'];
        }
        return $results;
    }

    private function saveInfo($countryId,$product,$i){
        $prod = CountryProduct::select('*', 'shop_products.id as productId', 'shop_country_products.id as id',
            'shop_products.active as productActive', 'shop_country_products.active as active')
            ->join('shop_products','shop_country_products.product_id','shop_products.id')
            ->where('shop_country_products.country_id',$countryId)
            ->where('shop_products.sku',$product['sku'])
            ->first();
        if(!is_null($prod)){
            $prod->price  = $product['price'];
            $prod->points = $product['points'];
            $prod->active = $product['status'];
            $prod->save();
            return ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.label.success'), 'class' => 'success'];
        }
        return ['line' => $i+1, 'message' => trans('admin::shopping.products.updateproduct.error.notexist'), 'class' => 'danger'];
    }

    private function readCSV($file, $header = true) {
        $csv    = [];
        $handle = fopen($file, 'r');
        while ($line = fgetcsv($handle, 500, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'sku'    => $line[0]!= "" ? $line[0] : null,
                    'price'  => $line[1] != "" ? $line[1] : null,
                    'points' => $line[2] != "" ? $line[2] : null,
                    'status' => $line[3] != "" ? $line[3] : null,
                ];
            }
        }
        return $csv;
    }

    /**
     * @param $country
     * @return array
     */
    private function getArrayCountry($country, $val){
        $countries = [];
        foreach ($country as $c){
            $countries[$c->id] = $c->$val;
        }
        return $countries;
    }

    /**
     * Guarda los datos del producto en la tabla shop_product
     * @param  int $id
     * @param  int $sku
     * @param  boolean $is_kit
     * @param  boolean $active
     * @return int
     */
    private function saveProduct($id, $sku, $is_kit, $globalName, $active)
    {
        return Product::saveInfo($id, $sku, $is_kit, $globalName, $active);
    }

    /**
     * Guarda los datos del producto en la tabla shop_brand_products
     * @param  int $brand_id
     * @param  int $product_id
     * @param  boolean $active
     * @return int
     */
    private function saveProductBrand($brand_id, $product_id, $active)
    {
        return BrandProduct::saveInfo($brand_id, $product_id, $active);
    }

    /**
     * Guarda los datos del producto en la tabla shop_country_products
     * @param  array $dataCountry
     * @param  int $product_id
     * @param  boolean $active
     * @return null
     */
    private function saveProductCountry($product_id, $dataCountry, $active)
    {
        foreach ($dataCountry as $c)
        {
            if($c['active'] == 1)
            {
                $productCountry = CountryProduct::saveInfo($c['countryId'], $product_id, $c['price'], $c['points'], $c['activateProductByCountry']);
                /*if(isset($c['categoryRowId'])){
                    GroupProduct::where('id',$c['categoryRowId'])->update(['country_group_id'=>$c['categoryId']]);
                }else{
                    GroupProduct::saveInfo($c['categoryId'], $product_id,null,null,$active);
                }*/
                $this->saveProductTranslation($productCountry->id, $c['detail']);
            }
        }
    }

    /**
     * Guarda los datos del producto en la tabla shop_complementary_products
     * @param  array $dataCountry
     * @param  int $product_id
     * @param  boolean $active
     * @return null
     */
    private function saveRelatedProducts($product_id, $dataCountry, $active)
    {
        foreach ($dataCountry as $c)
        {
            if($c['active'] == 1 && isset($c['related']))
            {
                /* $productCountry = CountryProduct::saveInfo($c['countryId'], $product_id, $c['price'], $c['points'], $c['active']);
                GroupProduct::saveInfo($c['categoryId'], $product_id, $active);
                $this->saveProductTranslation($productCountry->id, $c['detail']); */
                ComplementaryProducts::saveInfo($c['related'],$product_id,$active,$c['countryId']);
            }
        }
    }

    /**
     * Guarda los datos del producto en la tabla shop_products_translations
     * @param $country_product_id
     * @param  array $detail
     * @return null
     */
    private function saveProductTranslation($country_product_id, $detail)
    {
        foreach ($detail as $d)
        {
            if($d['name'] != ""){
            ProductTranslation::saveInfo($country_product_id, $d['languageName'], $d['name'], $d['shortDescription'],
                nl2br($d['description']), nl2br($d['benefits']), nl2br($d['ingredients']), nl2br($d['comments']),$d['image'],$d['nutritionalTable']);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function obtainComplementary(Request $request)
    {
        $datos = $request->all();
        if(isset($datos['pais']) && isset($datos['lenguaje']) && isset($datos['producto'])){
            $pais = $datos['pais'];
            $lenguaje = $datos['lenguaje'];
            $idproducto = $datos['producto'];
            $products = ComplementaryProducts::obtainComplementaryProducts($pais,$lenguaje,$idproducto);
            if(!empty($products)){
                return response()->json(['success' => true,'message'=>'','info' => $products]);
            }
            return response()->json(['success' => false,'message'=>trans('admin::shopping.products.obtain.failedobtaining'),'info' => ""]);
        }
        return response()->json(['success' => false,'message'=>trans('admin::shopping.products.obtain.emptyvalues'),'info' => ""]);
    }

    public function obtainSelectedComplementary(Request $request){
        $datos = $request->all();
        if(isset($datos['pais']) && isset($datos['lenguaje']) && isset($datos['producto'])) {
            $pais = $datos['pais'];
            $lenguaje = $datos['lenguaje'];
            $idproducto = $datos['producto'];
            $selectedComplementary = ComplementaryProducts::selectedComplementary($idproducto,$pais);
            if(!empty($selectedComplementary)){
                return response()->json(['success' => true,'message'=>'','info' => $selectedComplementary]);
            }
            return response()->json(['success' => false,'message'=>trans('admin::shopping.products.obtain.failedobtaining'),'info' => ""]);
        }
        return response()->json(['success' => false,'message'=>trans('admin::shopping.products.obtain.emptyvalues'),'info' => ""]);
    }

    public function delete(Request $request, Product $product) {
        $product->delete = 1;
        $product->active = 0;
        $product->update();
        CountryProduct::where('product_id', $product->id)
            ->update(['delete' => 1, 'active' => 0]);

        $productId = $product->id;

        # Descactiva el producto por categoría
        GroupProduct::whereHas('countryProduct', function ($q) use ($productId) {
            $q->where('product_id', $productId);
        })->update(['active' => 0, 'product_home' => 0, 'product_category' => 0]);

        # Desactiva el producto por país
        CountryProduct::where('product_id', $productId)
            ->update(['active' => 0]);

        # Desactiva el producto como base de complementos
        ComplementaryProducts::where('product_id', $productId)
            ->update(['active' => 0]);

        # Desactiva el producto como complemento
        ComplementaryProducts::whereHas('relatedProduct', function ($q) use ($productId) {
            $q->where('product_id', $productId);
        })->update(['active' => 0]);

        $request->session()->flash('success', trans('admin::shopping.products.index.delete_product_message'));
        return redirect()->route('admin.products.index');
    }

    public function getProductsByBrandAndCountry(Request $request) {
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
            $response['countriesByBrand'] = $countriesByBrand;
        }

        return $response;
    }

    public function existSKU(Request $request) {
        $response = ['status' => false, 'redirect' => false];

        if ($request->has('sku')) {
            $product = Product::where('sku', $request->input('sku'))->first();

            if ($product != null) {

                if ($product->delete == 1) {
                    $product_id = $product->id;

                    # Reactivar el producto
                    $product->active = 1;
                    $product->delete = 0;
                    $product->update();

                    # Reactivar los productos por paises
                    CountryProduct::where('product_id', $product_id)
                       ->update(['delete' => 0]);

                    # Reactivar los productos eliminados por categoría
                    # GroupProduct::whereHas('countryProduct', function ($q) use ($product_id) {
                    #     $q->where('product_id', $product_id);
                    # })->update(['active' => 1]);

                    $response['redirect'] = route('admin.products.edit', $product);
                } else {
                    $response['status'] = true;
                }
            }
        }

        return \GuzzleHttp\json_encode($response);
    }
}
