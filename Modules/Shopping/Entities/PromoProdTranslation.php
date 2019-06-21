<?php namespace Modules\Shopping\Entities;

use Eloquent;

class PromoProdTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['promo_prod_id','name','description','locale'];
    
    protected $table = 'shop_promo_prod_translations';

    public function promoprod()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\PromoProd','id','promo_prod_id');
    }
    
}