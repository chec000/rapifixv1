<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class WarehouseCountry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_country_warehouses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id', 'warehouse', 'active', 'last_modifier_id', 'created_at', 'updated_at'];

    static function saveInfo($country_id, $warehouse)
    {
        return WarehouseCountry::updateOrCreate(
            ['country_id' => $country_id, 'warehouse' => $warehouse],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id]
        );
    }

    public function country() {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public static function getWarehouseByCountryAndSku($countryId, $sku = null) {
        if($sku !== null){
            $warehouse = WarehouseCountry::select('shop_country_warehouses.warehouse')
                ->join('shop_warehouse_products', 'shop_warehouse_products.country_warehouse_id', 'shop_country_warehouses.id')
                ->join('shop_country_products', 'shop_warehouse_products.product_country_id', 'shop_country_products.id')
                ->join('shop_products', 'shop_country_products.product_id', 'shop_products.id')
                ->where('shop_products.sku', $sku)
                ->where('shop_country_products.country_id', $countryId)
                ->where('shop_country_warehouses.active', 1)
                ->where('shop_warehouse_products.active', 1)
                ->first();
        }else{
            $warehouse = WarehouseCountry::select('shop_country_warehouses.warehouse')
                ->where('shop_country_warehouses.country_id', $countryId)
                ->where('shop_country_warehouses.active', 1)
                ->first();
        }
        return $warehouse;
    }



    public static function getWarehouseId($countryId,$warehousename){
        $warehouseId = 0;
        if($countryId !== null && $warehousename !== null){
            $warehouse = WarehouseCountry::where(['country_id' => $countryId,'warehouse' => $warehousename])->first();
            if(!is_null($warehouse)){
                $warehouseId = $warehouse->id;
            }
        }


        return $warehouseId;

    }

}
