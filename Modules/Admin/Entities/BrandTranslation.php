<?php namespace Modules\Admin\Entities;

use Eloquent;

class BrandTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name', 'alias', 'logo','locale'];
    
    protected $table = 'glob_brand_translations';

    public function brand()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Brand');
    }
    
}