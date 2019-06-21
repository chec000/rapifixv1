<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_brand_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['brand_id','product_id', 'active', 'last_modifier_id'];

    static function saveInfo($brand_id, $product_id, $active)
    {
        BrandProduct::updateOrCreate(
            ['brand_id' => $brand_id, 'product_id' => $product_id],
            ['active' => $active, 'last_modifier_id' => Auth::user()->id]
        );
    }

    public function products(){
        return $this->hasMany('Modules\Shopping\Entities\Product');
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Admin\Entities\Brand', 'brand_id', 'id');
    }

}
