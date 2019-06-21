<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $table = 'cms_shares';

    protected $fillable = [
        'share_id',
        'url',
        'brand_id',
        'country_id',
        'language_id',
        'data',
        'is_product'
    ];
}
