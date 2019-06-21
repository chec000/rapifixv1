<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class DistributorsPool extends Model
{
    protected $fillable = [
        'country_id',
        'distributor_code',
        'distributor_name',
        'distributor_email',
        'used',
        'last_modifier_id'
    ];

    protected $table = 'shop_distributors_pool';

    public function country() {
        return $this->hasOne('Modules\Admin\Entities\Country', 'id', 'country_id');
    }
}
