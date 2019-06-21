<?php namespace Modules\Shopping\Entities;

use Eloquent;

class BankTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['banks_id','name','description','locale'];
    
    protected $table = 'shop_bank_translations';

    public function banks()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\Bank','id','banks_id');
    }
    
}