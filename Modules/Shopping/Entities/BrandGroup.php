<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class BrandGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_brand_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['brand_id', 'country_group_id', 'active', 'last_modifier_id'];

    static function saveInfo($brand_id, $group_id, $active)
    {
        return BrandGroup::updateOrCreate(
            ['brand_id' => $brand_id, 'country_group_id' => $group_id],
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

    public function countriesGroup(){
        return $this->hasMany('Modules\Shopping\Entities\GroupCountry');
    }

    public function scopeOfBrandId(Builder $query){
        return $query->where('brand_id', 1);

    }
}
