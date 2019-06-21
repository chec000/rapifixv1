<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Modules\Shopping\Entities\RegistrationReferencesTranslation;

class RegistrationReferences extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['active','delete','key_reference','last_modifier'];

    public $translatedAttributes = ['name'];
    protected $table = 'shop_registration_references';

 public function registrationReferencesTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\RegistrationReferencesTranslation');
    }

    public  function registrationReferencesCountry()
    {
        return $this->hasMany('Modules\Shopping\Entities\RegistrationReferencesCountry');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_registration_references_countries', 'registration_references_id', 'country_id')->wherePivot('active', 1);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }





}
