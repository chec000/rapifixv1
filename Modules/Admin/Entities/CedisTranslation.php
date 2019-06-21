<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class CedisTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'glob_cedis_translations';
}
