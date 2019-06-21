<?php

namespace Modules\Shopping\Entities;

use Illuminate\Database\Eloquent\Model;

class CountryRegistrationParameter extends Model
{
    protected $fillable = ['country_id', 'min_age', 'maz_age', 'has_documents', 'active', 'delete', 'last_modifier_id'];

    protected $table = 'shop_country_registration_parameters';
}
