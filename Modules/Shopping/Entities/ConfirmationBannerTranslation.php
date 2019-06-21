<?php namespace Modules\Shopping\Entities;

use Eloquent;

class ConfirmationBannerTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['confirmation_banner_id','image','locale'];
    
    protected $table = 'shop_confirmation_banner_translations';


    public function ConfirmationBanner()
    {
        return $this->belongsTo('Modules\Shopping\Entities\ConfirmationBanner');
    }

    
}