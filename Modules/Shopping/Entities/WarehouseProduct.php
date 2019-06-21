<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_warehouse_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_warehouse_id', 'product_id','product_country_id', 'active', 'last_modifier_id', 'created_at', 'updated_at'];

    /*static function saveInfo($country_id, $warehouse)
    {
        return WarehouseCountry::updateOrCreate(
            ['country_id' => $country_id, 'warehouse' => $warehouse],
            ['active' => 1, 'last_modifier_id' => Auth::user()->id]
        );
    }*/

    public function warehouse() {
        return $this->belongsTo('Modules\Shopping\Entities\WarehouseCountry', 'country_warehouse_id', 'id');
    }
}
