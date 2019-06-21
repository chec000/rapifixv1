<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Modules\Shopping\Entities\banksTranslation;

class Bank extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['active','delete','bank_key','url','logo','last_modifier_id'];
    public $translationModel = 'Modules\Shopping\Entities\BankTranslation';
    public $translationForeignKey = 'banks_id';

    public $translatedAttributes = ['name','description'];
    protected $table = 'shop_banks';


    //banks translation
 public function banksTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\BankTranslation','banks_id','id');
    }

    public  function banksCountry()
    {
        return $this->hasMany('Modules\Shopping\Entities\BankCountry','banks_id','id');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_bank_countries', 'banks_id', 'country_id')->wherePivot('active', 1);
    }



    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }








}
