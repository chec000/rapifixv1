<?php

namespace Modules\Admin\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Cedis extends Model
{
    use Translatable;

    public $translatedAttributes = [
        'name',
        'description',
        'state_name',
        'city_name',
        'schedule',
        'banner_image',
        'slug'
    ];

    protected $fillable = [
        'address',
        'country_id',
        'global_name',
        'state_key',
        'city_key',
        'neighborhood',
        'postal_code',
        'phone_number_01',
        'phone_number_02',
        'telemarketing',
        'fax',
        'email',
        'latitude',
        'longitude',
        'image_01',
        'image_02',
        'image_03',
        'banner_link',
        'status',
        'delete'
    ];

    protected $table = 'glob_cedis';

    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public static function belongToCity($countryId, $stateKey) {
        return Cedis::where('state_key', $stateKey)->where('country_id', $countryId)->where('status', 1)->where('delete', 0)->count() > 0;
    }
}
