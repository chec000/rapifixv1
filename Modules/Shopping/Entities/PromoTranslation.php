<?php namespace Modules\Shopping\Entities;

use Eloquent;

class PromoTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['promo_id','name_header','description_header','locale'];

    protected $table = 'shop_promo_translations';

    public function promo()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\Promo','id','promo_id');
    }
    
}