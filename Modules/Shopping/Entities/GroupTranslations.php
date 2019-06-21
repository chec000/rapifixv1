<?php

namespace Modules\Shopping\Entities;

use Auth;
use Illuminate\Database\Eloquent\Model;

class GroupTranslations extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_group_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['country_group_id','locale','name','title','benefit','description','image','image_banner',
        'slug','active', 'last_modifier_id','created_at','updated_at'];


    /**
     * @param $country_group_id
     * @param $locale
     * @param $name
     * @param $title
     * @param $benefit
     * @param $description
     * @param $image
     * @param $imageBanner
     * @param $active
     * @return mixed
     */
    static function saveInfo($country_group_id, $locale, $name, $title, $benefit, $description, $imageBanner, $image, $active)
    {
        return GroupTranslations::updateOrCreate(
            ['country_group_id' => $country_group_id, 'locale' => $locale],

            ['name' => $name, 'title' => $title, 'benefit' => $benefit, 'description' => $description, 'image' => $image,
                'image_banner' => $imageBanner, 'slug' => str_slug($name, '-', $locale), 'active' => $active, 'last_modifier_id' => Auth::user()->id]
        );
    }

    static function getInfoGroup(){

    }
}
