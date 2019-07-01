<?php

namespace Modules\Shopping\Entities;

use App\Helpers\SessionHdl;
use Auth;
use Dimsav\Translatable\Translatable;
use Session;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\CountryLanguage;
use Modules\Admin\Entities\CountryTranslation;


class CountryProduct extends Model
{
    use Translatable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_country_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id','product_id', 'price', 'points', 'active', 'last_modifier_id', 'delete'];

    public $translationModel = 'Modules\Shopping\Entities\ProductTranslation';

    public $translationForeignKey = 'country_product_id';

    public $translatedAttributes = ['name','short_description','description','benefits','ingredients','comments','slug','image','nutritional_table'];

    static function saveInfo($country_id, $product_id, $price, $points, $active) {
        ComplementaryProducts::where('product_id', $product_id)
            ->update(['active' => $active]);

        ComplementaryProducts::whereHas('relatedProduct', function ($q) use ($product_id, $country_id) {
            $q->where('product_id', $product_id);
            $q->where('product_id', $country_id);
        })->update(['active' => $active]);

        $updateGroupProduct = ['active' => $active];
        if ($active == 0) {
            $updateGroupProduct['product_home']     = 0;
            $updateGroupProduct['product_category'] = 0;
        }

        GroupProduct::whereHas('countryProduct', function ($q) use ($product_id, $country_id) {
            $q->where('product_id', $product_id);
            $q->where('country_id', $country_id);
        })->update($updateGroupProduct);

        return CountryProduct::updateOrCreate(
            ['country_id' => $country_id, 'product_id' => $product_id],
            ['price' => $price, 'points' => $points, 'active' => $active, 'last_modifier_id' => Auth::user()->id]
        );
    }

    static function infoProductTranslation($id)
    {
        $countries = [];
        $countryProduct = CountryProduct::where('product_id',$id)->whereIn('country_id', User::userCountriesPermission())->get();
        foreach ($countryProduct as $c)
        {
            $category = GroupProduct::select('shop_group_products.country_group_id','shop_group_products.id')
                ->join('shop_country_groups', 'shop_group_products.country_group_id', '=', 'shop_country_groups.id')
                ->where('shop_country_groups.country_id',$c->country_id)
                ->where('shop_country_groups.group_id',1)
                ->where('shop_group_products.product_id',$c->product_id)->first();

            $countriesLang = DB::table('glob_country_languages')
                ->join('glob_languages', 'glob_country_languages.language_id', '=', 'glob_languages.id')
                ->where('country_id',$c->country_id)->get();
            $countryName = CountryTranslation::where('country_id',$c->country_id)
                ->where('locale',Session::get('adminLocale'))->first();
            $countryLangProduct = [];
            foreach ($countriesLang as $cL)
            {
                $translationProduct = ProductTranslation::where('country_product_id',$c->id)->where('locale',$cL->locale_key)->first();
                if ($translationProduct != null)
                {
                    array_push($countryLangProduct, ['languageName'=> $translationProduct->locale,
                        'languageId'=> $cL->language_id, 'name'=> $translationProduct->name,
                        'description'=> strip_tags($translationProduct->description), 'shortDescription'=> $translationProduct->short_description,
                        'benefits'=> strip_tags($translationProduct->benefits), 'ingredients'=> strip_tags($translationProduct->ingredients),
                        'nutritionalTable'=> $translationProduct->nutritional_table, 'active'=> $translationProduct->active,
                        'comments'=> strip_tags($translationProduct->comments),'image'=> $translationProduct->image]);
                }
            }
            array_push($countries,['countryId' => $c->country_id,'countryName' => $countryName->name,
                #'price' => $c->price,'points' => $c->points, 'active' => $c->active, 'categoryId' => $category->country_group_id,
                'price' => $c->price,'points' => $c->points, 'active' => $c->active, 'detail' => $countryLangProduct]);
        }

        return $countries;
    }

    public function getTranslations($locale) {
        return ProductTranslation::where('country_product_id', $this->id)->where('locale', $locale)->first();
    }

    public function product() {
        return $this->belongsTo('Modules\Shopping\Entities\Product');
    }

    public function country() {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public function getCountriesAttribute() {
        return CountryProduct::where('product_id', $this->product_id)->get();
    }

    public function getActivesAttribute() {
        $active = 0;

        $products = CountryProduct::where('product_id', $this->product_id)->get();;

        foreach ($products as $product) {
            if ($product->active == 1) {
                $active = 1;
            }
        }

        return $active;
    }

    public function productsRestriction(){
        return $this->hasMany('Modules\Shopping\Entities\ProductRestriction','country_product_id','id')->where('active',1);
    }

    public function productGroups() {
        return $this->belongsToMany('Modules\Shopping\Entities\GroupCountry', 'shop_group_products', 'product_id', 'country_group_id');
    }

    public function warehouses() {
        return $this->belongsToMany('Modules\Shopping\Entities\WarehouseCountry', 'shop_warehouse_products', 'product_country_id', 'country_warehouse_id');
    }

    public function warehouseProduct() {
        return $this->belongsTo('Modules\Shopping\Entities\WarehouseProduct', 'id', 'product_country_id');
    }

    public function warehouseProducts() {
        return $this->hasMany('Modules\Shopping\Entities\WarehouseProduct', 'product_country_id', 'id');
    }

    public function belongsToWarehouse($warehouseName) {
        $belongs = false;

        try {
            foreach($this->warehouses as $wh) {
                $warehouseProduct = $this->warehouseProducts->where('country_warehouse_id', $wh->id)->first();

                if (utf8_encode($wh->warehouse) == utf8_encode($warehouseName) && $wh->active && $warehouseProduct->active == 1) {
                    $belongs = true;
                }
            }
        } catch (\Exception $e) {
            $belongs = false;
        }

        return $belongs;
    }

    public function isItRestrictedIn($stateKey) {
        if ($stateKey != false && SessionHdl::isWebServiceActive()) {
            return ProductRestriction::where('country_product_id', $this->id)
                    ->where('state', $stateKey)
                    ->where('active', 1)
                    ->get()
                    ->count() > 0;
        }

        return false;
    }

    public function getRelatedProducts() {
        return ComplementaryProducts::select('shop_complementary_products.*')
            ->join('shop_country_products', 'shop_country_products.id', '=', 'shop_complementary_products.product_related_id')
            ->join('shop_product_translations as t', function ($join) {
                $join->on('shop_country_products.id', '=', 't.country_product_id')
                    ->where('t.locale', '=', SessionHdl::getLocale());
            })
            ->where('shop_complementary_products.product_id', $this->product->id)
            ->where('shop_complementary_products.country_id', $this->country_id)
            ->orderBy('t.name', 'ASC')
            ->get();
    }

    public static function getAllByCategory($categoryId, $countryId, $locale, $onlyHome = false, $onlyCat = false) {

        $products = CountryProduct::select('shop_country_products.*')
            ->join('shop_products as p', 'p.id', '=', 'shop_country_products.product_id')
            ->join('shop_group_products as gp', 'gp.product_id', '=', 'shop_country_products.id')
            ->join('shop_product_translations as t', function ($join) use ($locale) {
                $join->on('shop_country_products.id', '=', 't.country_product_id')
                    ->where('t.locale', '=', $locale);
            })
            ->where('shop_country_products.country_id', $countryId)
            ->where('gp.country_group_id', $categoryId)
            ->where('shop_country_products.active', 1)
            ->where('shop_country_products.delete', 0)
            ->orderBy('t.name', 'ASC');

        if ($onlyHome) {
            $products->where('gp.product_home', 1);
        }

        if ($onlyCat) {
            $products->where('gp.product_category', 1);
        }

        return $products->get();
    }

    public static function getFilteredByGroup($countryGroupId) {
        $config           = country_config(SessionHdl::getCorbizCountryKey());
        $isShoppingActive = $config['shopping_active'];
        $isWSActive       = $config['webservices_active'];
        $warehouse        = SessionHdl::getWarehouse();
        $locale           = SessionHdl::getLocale();

        $products = GroupProduct::select('shop_group_products.*')
            ->whereHas('countryProduct', function ($q) use ($isShoppingActive, $isWSActive, $warehouse) {
                $q->where('active', 1)->where('delete', 0);
                $q->whereHas('product', function ($q) {
                    $q->where('is_kit', 0);
                });

                if (areShoppingAndWsActive() || allow_by_ip()) {
                    $q->whereHas('warehouseProduct', function ($q) use ($warehouse) {
                        $q->where('active', 1)
                            ->whereHas('warehouse', function ($q) use ($warehouse) {
                                $q->where('warehouse', $warehouse);
                            });
                    });
                }
            })
            ->join('shop_country_products as cp', 'cp.id', '=', 'shop_group_products.product_id')
            ->join('shop_product_translations as t', function ($join) use ($locale) {
                $join->on('cp.id', '=', 't.country_product_id')
                    ->where('t.locale', '=', $locale);
            })
            ->where('shop_group_products.country_group_id', $countryGroupId)
            ->where('shop_group_products.active', 1)
            ->orderBy('t.name', 'ASC')
            ->paginate(9);

        return $products;
    }
}
