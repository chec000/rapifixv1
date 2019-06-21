<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_group_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_group_id', 'product_id', 'category_id', 'product_home', 'product_category', 'active', 'last_modifier_id'];

    static function saveInfo($group_id, $product_id,$product_home,$product_category, $active)
    {
        return GroupProduct::updateOrCreate(
            ['country_group_id' => $group_id, 'product_id' => $product_id],
            ['product_home' => $product_home, 'product_category' => $product_category,'active' => $active,
                'last_modifier_id' => Auth::user()->id]
        );
    }

    public function getActiveProduct() {
        return Product::where('id', $this->product_id)->where('active', 1)->where('delete', 0)->first();
    }

    public function countryProduct() {
        return $this->belongsTo('Modules\Shopping\Entities\CountryProduct', 'product_id', 'id');
    }

    public function countryGroup() {
        return $this->belongsTo('Modules\Shopping\Entities\GroupCountry', 'country_group_id', 'id');
    }
}
