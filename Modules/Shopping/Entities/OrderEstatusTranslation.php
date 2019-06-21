<?php namespace Modules\Shopping\Entities;

use Eloquent;

class OrderEstatusTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name', 'description','locale'];
    
    protected $table = 'shop_orderestatus_translations';

    public function orderestatus()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\OrderEstatus');
    }
    
}