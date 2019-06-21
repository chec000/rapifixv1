<?php namespace Modules\Shopping\Entities;

use Eloquent;

class RegistrationReferencesTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name','locale'];
    
    protected $table = 'shop_registration_references_translations';

    public function orderestatus()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\RegistrationReferences');
    }
    
}