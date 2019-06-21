<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Modules\Admin\Entities\BrandCountry;
use Modules\Admin\Entities\BrandTranslation;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\CountryTranslation;
use Modules\Admin\Http\Requests\BulkLoadRequest;
use Modules\Admin\Http\Requests\FiltersRequest;
use Modules\Shopping\Entities\BrandProduct;
use Modules\Shopping\Entities\CategoryFilter;
use Modules\Shopping\Entities\ComplementaryProducts;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Product;
use Modules\Shopping\Entities\ProductTranslation;
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

class BulkLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $this->layoutData['content'] = View::make('admin::shopping.bulkload.index');
    }

    public function product(Request $request, BulkLoadRequest $bulkLoadRequest)
    {
        $csvContent = $this->readProductCSV($request->file('fileUpload')->path());
        $results[] = ['line' => 0, 'message' => trans('admin::shopping.bulkload.messages.errors.empty_file'), 'class' => 'danger'];
        if (sizeof($csvContent) > 0) {
            $results = [];
            foreach ($csvContent as $i => $p) {
                $results['res'][$i] = ['line' => $p['sku'], 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];
                if (!is_null($p['country']) && !is_null($p['brand']) && !is_null($p['lang']) && !is_null($p['sku']) &&
                    !is_null($p['name']) && !is_null($p['desc_short'])
                    && !is_null($p['img_product']) && !is_null($p['is_kit']) && !is_null($p['active'])){
                    //&& !is_null($p['description']) && ((is_null($p['price']) && $p['active']== '0') || (!is_null($p['price']) && $p['active']== '1')) ) {
                    $p['price'] = !is_null($p['price']) ? $this->cleanPrice($p['price']) : 0;
                    $p['point'] = !is_null($p['point']) ? $p['point'] : 0;
                    $res = $this->saveInfoProduct($p,$i);
                    $results['res'][$i] = $res;
                }
            }
        }
        $results['status'] = true;
        return $results;
    }
    private function saveInfoProduct($p,$i)
    {
        $country = Country::where('country_key', $p['country'])->first();

        $imagePath      = "/uploads/images/products/detail/".strtolower($country->corbiz_key)."/".$p['lang']."/";
        $nutitionalPath = "/uploads/images/products/nutrimental/".strtolower($country->corbiz_key)."/".$p['lang']."/";

        $brand = BrandTranslation::where('name', $p['brand'])->where('locale', $p['lang'])->first();
        $shop_product = Product::updateOrCreate( ['sku' => $p['sku']],
            ['global_name' => utf8_encode($p['name_global']),'is_kit' => $p['is_kit'],'active' => 1, 'last_modifier_id' => Auth::user()->id ]);
        $shop_product_country = CountryProduct::updateOrCreate( ['country_id' => $country->id, 'product_id' => $shop_product->id ],
                ['price' => $p['price'], 'points' => $p['point'], 'active' => $p['active'], 'last_modifier_id' => Auth::user()->id ]);
        $shop_product_brand = BrandProduct::updateOrCreate( ['brand_id' => $brand->brand_id, 'product_id' => $shop_product->id ],
                ['active' => 1, 'last_modifier_id' => Auth::user()->id ]);

        $image            = empty($p['img_product']) ? '' : $imagePath.$p['img_product'];
        $imageNutritional = empty($p['img_nutri'])   ? '' : $nutitionalPath.$p['img_nutri'];

        $shop_product_translations = ProductTranslation::updateOrCreate(
                ['country_product_id' => $shop_product_country->id, 'locale' => $p['lang'] ],
                ['name' => utf8_encode(trim($p['name'])), 'short_description' => utf8_encode($p['desc_short']), 'description' => utf8_encode($p['description']),
                 'benefits' => utf8_encode($p['benefit']), 'ingredients' => utf8_encode($p['ingredient']), 'comments' => utf8_encode($p['comments']),
                 'slug' => str_slug(utf8_encode($p['name']), '-', $p['lang']), 'image' => $image,
                 'nutritional_table' => $imageNutritional, 'active' => 1, 'last_modifier_id' => Auth::user()->id ]);
        return ['line' => $p['sku'], 'message' => trans('admin::shopping.bulkload.messages.success.product'), 'class' => 'success'];
    }
    private function readProductCSV($file, $header = true)
    {
        ini_set('auto_detect_line_endings', true);
        $csv    = [];
        $handle = fopen($file, 'r');
        while ($line = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'country'          => $line[0] != "" ? $line[0] : null,
                    'brand'            => $line[1] != "" ? $line[1] : null,
                    'lang'             => $line[2] != "" ? $line[2] : null,
                    'sku'              => $line[3] != "" ? $line[3] : null,
                    'name_global'      => $line[4] != "" ? $line[4] : null,
                    'is_kit'           => $line[5] != "" ? $line[5] : null,
                    'price'            => $line[6] != "" ? $line[6] : null,
                    'point'            => $line[7] != "" ? $line[7] : null,
                    'comments'         => $line[8] != "" ? $line[8] : null,
                    'name'             => $line[9] != "" ? $line[9] : null,
                    'desc_short'       => $line[10] != "" ? $line[10] : null,
                    'description'      => $line[11] != "" ? $line[11] : null,
                    'benefit'          => $line[12] != "" ? $line[12] : null,
                    'ingredient'       => $line[13] != "" ? $line[13] : null,
                    'img_nutri'        => $line[14] != "" ? $line[14] : null,
                    'img_product'      => $line[15] != "" ? $line[15] : null,
                    'active'           => $line[16] != "" ? $line[16] : null,
                ];
            }
        }
        ini_set('auto_detect_line_endings', false);
        return $csv;
    }

    public function related(Request $request, BulkLoadRequest $bulkLoadRequest)
    {
        $csvContent = $this->readRelatedCSV($request->file('fileUpload')->path());
        $results[] = ['line' => 0, 'message' => trans('admin::shopping.bulkload.messages.errors.empty_file'), 'class' => 'danger'];
        if (sizeof($csvContent) > 0) {
            $results = [];
            foreach ($csvContent as $i => $p) {
                $results['res'][$i] = ['line' => $i, 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];
                if (!is_null($p['country']) && !is_null($p['product']) && !is_null($p['product_related'])) {
                    $res = $this->saveInfoRelated($p,$i);
                    $results['res'][$i] = $res;
                }
            }
        }
        $results['status'] = true;
        return $results;
    }
    private function saveInfoRelated($p,$i)
    {
        $country = Country::where('country_key', trim($p['country']))->first();
        $product = $this->getProduct($p['product'],$country->id);
        if (isset($p['product_related']))
        {
            $array = explode(";", $p['product_related']);
            foreach ($array as $a)
            {
                $product_related = $this->getProduct($a,$country->id);
                if(isset($product_related) && $product_related->idCountryProduct != $product->idCountryProduct){
                    ComplementaryProducts::updateOrCreate(
                        ['country_id' => $country->id, 'product_id' => $product->product->id, 'product_related_id' => $product_related->idCountryProduct],
                        ['active' => 1, 'last_modifier_id' => Auth::user()->id]
                    );
                }
            }
        }
        return ['line' => $p['product'], 'message' => trans('admin::shopping.bulkload.messages.success.product'), 'class' => 'success'];
    }
    private function readRelatedCSV($file, $header = true)
    {
        ini_set('auto_detect_line_endings', true);
        $csv    = [];
        $handle = fopen($file, 'r');
        while ($line = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'country'          => $line[0] != "" ? $line[0] : null,
                    'product'          => $line[1] != "" ? $line[1] : null,
                    'product_related'  => $line[2] != "" ? $line[2] : null,
                ];
            }
        }
        ini_set('auto_detect_line_endings', false);
        return $csv;
    }

    public function category(Request $request, BulkLoadRequest $bulkLoadRequest)
    {
        $csvContent = $this->readCategoryCSV($request->file('fileUpload')->path());
        $results[] = ['line' => 0, 'message' => trans('admin::shopping.bulkload.messages.errors.empty_file'), 'class' => 'danger'];
        if (sizeof($csvContent) > 0) {
            $results = [];
            foreach ($csvContent as $i => $p) {
                $results['res'][$i] = ['line' => $i, 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];
                if (!is_null($p['country']) && !is_null($p['brand']) && !is_null($p['lang']) && !is_null($p['name']) &&
                    !is_null($p['description']) && !is_null($p['banner']) &&
                    !is_null($p['name_global']) && !is_null($p['active'])) {
                    $res = $this->saveInfoCategory($p,$i);
                    $results['res'][$i] = $res;
                }
            }
        }
        $results['status'] = true;
        return $results;
    }
    private function saveInfoCategory($p,$i)
    {
        $bcountry_group = GroupCountry::select('code')->where('global_name', '=', utf8_encode($p['name_global']))->first();
        $country = Country::where('country_key', $p['country'])->first();
        $path_image = "/uploads/images/categories/banners/".strtolower($country->corbiz_key)."/".$p['lang']."/";
        $brand = BrandTranslation::where('name', $p['brand'])->where('locale', $p['lang'])->first();
        $country_group = GroupCountry::updateOrCreate(['country_id' => $country->id, 'group_id' => $this->getCategoryId(),
            'global_name' => utf8_encode($p['name_global'])], ['link_banner' => $p['link'], 'active' => $p['active'],
            'last_modifier_id' => Auth::user()->id ]);
        $codeCat = (!is_null($bcountry_group)) ? $bcountry_group->code : 'CAT'.$country_group->id;
        GroupCountry::find($country_group->id)->update(['code' => $codeCat]);
        $group_translations = GroupTranslations::updateOrCreate(['country_group_id' => $country_group->id,'locale' => $p['lang']],
            [ 'name' => utf8_encode(trim($p['name'])), 'description' => utf8_encode($p['description']), 'last_modifier_id' => Auth::user()->id,
                'image_banner' => $path_image.$p['banner'], 'active' => 1,
                'slug' => str_slug(utf8_encode($p['name']), '-', $p['lang'])]);
        $group_brand = BrandGroup::updateOrCreate( ['brand_id' => $brand->brand_id, 'country_group_id' => $country_group->id],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id ]);

        $this->saveGroupProduct($p['category'],$country_group->id,$country->id,1);
        $this->saveGroupProduct($p['latest_releases'],$country_group->id,$country->id,3);
        $this->saveGroupProduct($p['inventories'],$country_group->id,$country->id,2);

        return ['line' => $i, 'message' => trans('admin::shopping.bulkload.messages.success.category'), 'class' => 'success'];
    }
    private function readCategoryCSV($file, $header = true)
    {
        ini_set('auto_detect_line_endings', true);
        $csv    = [];
        $handle = fopen($file, 'r');
        while ($line = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'country'          => $line[0] != "" ? $line[0] : null,
                    'brand'            => $line[1] != "" ? $line[1] : null,
                    'lang'             => $line[2] != "" ? $line[2] : null,
                    'name_global'      => $line[3] != "" ? $line[3] : null,
                    'name'             => $line[4] != "" ? $line[4] : null,
                    'description'      => $line[5] != "" ? $line[5] : null,
                    'banner'           => $line[6] != "" ? $line[6] : null,
                    'link'             => $line[7] != "" ? $line[7] : null,
                    'category'         => $line[8] != "" ? $line[8] : null,
                    'latest_releases'  => $line[9] != "" ? $line[9] : null,
                    'inventories'      => $line[10] != "" ? $line[10] : null,
                    'active'           => $line[11] != "" ? $line[11] : null,
                ];
            }
        }
        ini_set('auto_detect_line_endings', false);
        return $csv;
    }


    public function system(Request $request, BulkLoadRequest $bulkLoadRequest)
    {
        $csvContent = $this->readSystemCSV($request->file('fileUpload')->path());
        $results[] = ['line' => 0, 'message' => trans('admin::shopping.bulkload.messages.errors.empty_file'), 'class' => 'danger'];
        if (sizeof($csvContent) > 0) {
            $results = [];
            foreach ($csvContent as $i => $p) {
                $results['res'][$i] = ['line' => $i, 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];
                if (!is_null($p['country']) && !is_null($p['brand']) && !is_null($p['lang']) && !is_null($p['name']) &&
                    !is_null($p['name_global']) && !is_null($p['description']) && !is_null($p['benefit']) && !is_null($p['active']) &&
                    !is_null($p['banner1']) && !is_null($p['banner2']) && !is_null($p['system']))
                {
                    $res = $this->saveInfoSystem($p,$i);
                    $results['res'][$i] = $res;
                }
            }
        }
        $results['status'] = true;
        return $results;
    }
    private function saveInfoSystem($p,$i)
    {
        $bcountry_group = GroupCountry::select('code')->where('global_name', '=', utf8_encode($p['name_global']))->first();
        $country = Country::where('country_key', $p['country'])->first();

        $systemPath = "/uploads/images/systems/banners/".strtolower($country->corbiz_key)."/".$p['lang']."/";
        $bannerPath = "/uploads/images/systems/detail/".strtolower($country->corbiz_key)."/".$p['lang']."/";

        $brand = BrandTranslation::where('name', $p['brand'])->where('locale', $p['lang'])->first();

        $country_group = GroupCountry::updateOrCreate([
            'country_id' => $country->id,
            'group_id' => $this->getSystemId(),
            'global_name' => utf8_encode($p['name_global'])
        ], ['link_banner' => $p['link1'],
            'link_banner_two' => $p['link2'],
            'active' => $p['active'],
            'last_modifier_id' => Auth::user()->id
        ]);

        $codeSys = (!is_null($bcountry_group)) ? $bcountry_group->code : 'SYS'.$country_group->id;
        GroupCountry::find($country_group->id)->update(['code' => $codeSys]);

        $group_translations = GroupTranslations::updateOrCreate([
            'country_group_id' => $country_group->id,
            'locale' => $p['lang']
        ],
        ['name' => utf8_encode(trim($p['name'])), 'benefit' => utf8_encode($p['benefit']), 'description' => utf8_encode($p['description']), 'active' => 1,
                'image_banner' => $bannerPath.$p['banner2'],
                'image' => $systemPath.$p['banner1'], 'last_modifier_id' => Auth::user()->id,
                'slug' => str_slug(utf8_encode($p['name']), '-', $p['lang'])]);

        $group_brand = BrandGroup::updateOrCreate( ['brand_id' => $brand->brand_id, 'country_group_id' => $country_group->id],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id ]);

        $this->saveGroupProduct($p['system'],$country_group->id,$country->id,1);
        return ['line' => $i, 'message' => trans('admin::shopping.bulkload.messages.success.system'), 'class' => 'success'];
    }
    private function readSystemCSV($file, $header = true)
    {
        ini_set('auto_detect_line_endings', true);
        $csv    = [];
        $handle = fopen($file, 'r');
        while ($line = fgetcsv($handle, 1000, ",")) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'country'          => $line[0] != "" ? $line[0] : null,
                    'brand'            => $line[1] != "" ? $line[1] : null,
                    'lang'             => $line[2] != "" ? $line[2] : null,
                    'name'             => $line[3] != "" ? $line[3] : null,
                    'name_global'      => $line[4] != "" ? $line[4] : null,
                    'description'      => $line[5] != "" ? $line[5] : null,
                    'benefit'          => $line[6] != "" ? $line[6] : null,
                    'banner1'          => $line[7] != "" ? $line[7] : null,
                    'banner2'          => $line[8] != "" ? $line[8] : null,
                    'link1'            => $line[9] != "" ? $line[9] : null,
                    'link2'            => $line[10] != "" ? $line[10] : null,
                    'system'           => $line[11] != "" ? $line[11] : null,
                    'active'           => $line[12] != "" ? $line[12] : null,
                ];
            }
        }
        ini_set('auto_detect_line_endings', false);
        return $csv;
    }

    private function saveGroupProduct($list, $countryGroup,$country_id, $type){
        if(!is_null($list)){
            $array = explode(";", $list);
            foreach ($array as $a){
                $product = $this->getProduct($a,$country_id);
                if(isset($product))
                {
                    switch ($type) {
                        case 1:
                            $group_products = GroupProduct::updateOrCreate(['country_group_id' => $countryGroup,
                                'product_id' => $product->idCountryProduct], ['category_id' => 0, 'product_home' => 0,
                                'product_category' => 0, 'active' => 1, 'last_modifier_id' => Auth::user()->id]);
                            break;
                        case 2:
                            $group_products = GroupProduct::where('country_group_id',$countryGroup)->where('product_id',$product->idCountryProduct)->first();
                            if(!is_null($group_products)){
                                $group_products->product_home = 1;
                                $group_products->save();
                            }
                            break;
                        case 3:
                            $group_products = GroupProduct::where('country_group_id',$countryGroup)->where('product_id',$product->idCountryProduct)->first();
                            if(!is_null($group_products)){
                                $group_products->product_category = 1;
                                $group_products->save();
                            }
                            break;
                    }
                }
            }
        }
    }
    private function getProduct($sku,$country_id)
    {
        return CountryProduct::select('*','shop_country_products.id as idCountryProduct')
            ->join('shop_products','shop_country_products.product_id','shop_products.id')
            ->where('shop_products.sku',$sku)->where('shop_country_products.country_id',$country_id)->first();
    }
    private function getCategoryId(){
        $category = Group::where('type','Categories')->first();
        return $category->id;
    }
    private function getSystemId(){
        $category = Group::where('type','System')->first();
        return $category->id;
    }


    public function uploadProductsByWarehouse(Request $request, BulkLoadRequest $bulkLoadRequest) {
        $results    = ['line' => 0, 'message' => trans('admin::shopping.bulkload.messages.errors.empty_file'), 'class' => 'danger'];
        $csvContent = $this->readProductsByWarehouseCSV($request->file('fileUpload')->path());

        if (sizeof($csvContent) > 0) {
            $results = [];

            foreach ($csvContent as $i => $info) {
                $results['res'][$i] = ['line' => $i, 'message' => trans('admin::shopping.products.updateproduct.error.incomplete'), 'class' => 'danger'];

                if (!is_null($info['warehouse']) && !is_null($info['sku']) && !is_null($info['status'])) {
                    $res = $this->saveProductByWarehouse($info, $i);
                    $results['res'][$i] = $res;
                }

            }

            $results['status'] = true;
        }

        return $results;
    }

    private function readProductsByWarehouseCSV($file, $header = true) {
        ini_set('auto_detect_line_endings', true);

        $csv    = [];
        $handle = fopen($file, 'r');

        while ($line = fgetcsv($handle, 1000, ',')) {
            if ($header) {
                $header = false;
            } else {
                $csv[] = [
                    'warehouse' => $line[0] != '' ? $line[0] : null,
                    'sku'       => $line[1] != '' ? $line[1] : null,
                    'status'    => $line[2] != '' ? $line[2] : null,
                ];
            }
        }

        ini_set('auto_detect_line_endings', false);
        return $csv;
    }

    private function saveProductByWarehouse($info, $line) {

        $warehouse = WarehouseCountry::where('warehouse', $info['warehouse'])->first();

        if ($warehouse !== null) {
            $countryProduct = CountryProduct::whereHas('product', function ($q) use ($info) {
                $q->where('sku', $info['sku']);
                //$q->where('active', 1);
                //$q->where('delete', 0);
            })->where('country_id', $warehouse->country->id)
                //->where('active', 1)
                //->where('delete', 0)
                ->first();

            if ($countryProduct !== null) {
                WarehouseProduct::updateOrCreate(
                    ['country_warehouse_id' => $warehouse->id, 'product_country_id' => $countryProduct->id, 'product_id'=> $countryProduct->product->id],
                    ['active' => $info['status'], 'last_modifier_id' => Auth::user()->id ]
                );
            }
            
            return ['line' => $line, 'message' => trans('admin::shopping.bulkload.messages.success.warehouse'), 'class' => 'success'];
        } else {
            return ['line' => $line, 'message' => trans('admin::shopping.bulkload.messages.errors.warehouse_404'), 'class' => 'danger'];
        }
    }


    private function cleanPrice($price){
        $formats = array("$",",", "€", "_");
        $cleanPrice = str_replace($formats, "", $price);
        return trim($cleanPrice);
    }
}
