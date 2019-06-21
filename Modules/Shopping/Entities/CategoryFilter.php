<?php

namespace Modules\Shopping\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryFilter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_country_category_filter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_country_id', 'filter_country_id', 'active', 'last_modifier_id', 'created_at', 'updated_at'];

    public function category() {
        return $this->hasOne('Modules\Shopping\Entities\GroupCountry', 'id', 'category_country_id');
    }

    public function filter() {
        return $this->hasOne('Modules\Shopping\Entities\GroupCountry', 'id', 'filter_country_id');
    }
}
