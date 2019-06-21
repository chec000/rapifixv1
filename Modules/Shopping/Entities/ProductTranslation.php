<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_product_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_product_id', 'locale', 'name', 'short_description', 'description', 'benefits',
        'ingredients', 'comments', 'slug', 'image', 'nutritional_table', 'active', 'last_modifier_id'];

    static function saveInfo($country_product_id, $locale, $name, $shortDescription, $description, $benefits,
                             $ingredients, $comments, $image, $nutritional_table)
    {
        ProductTranslation::updateOrCreate(
            ['country_product_id' => $country_product_id, 'locale' => $locale],
            [
                'name' => $name, 'short_description' => $shortDescription, 'description' => $description,
                'benefits' => $benefits, 'ingredients' => $ingredients, 'comments' => $comments, 'slug' => str_slug($name, '-', $locale), 'image' => $image,
                'nutritional_table' => $nutritional_table, 'active' => 1, 'last_modifier_id' => Auth::user()->id
            ]
        );
    }

    public function groupProducts() {
        return $this->belongsTo('Modules\Shopping\Entities\GroupProduct', 'country_group_id', 'id');
    }
}
