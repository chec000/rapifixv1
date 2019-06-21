<?php namespace Modules\Shopping\Entities;

use Eloquent;

class LegalTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['legal_id','contract_pdf','disclaimer_html','contract_html','policies_pdf','locale'];
    
    protected $table = 'shop_legal_translations';

    public function legal()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\Legal','id','legal_id');
    }
    
}