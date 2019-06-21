<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Modules\Shopping\Entities\OrderEstatusTranslation;

class OrderEstatus extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['active','delete','key_estatus'];

    public $translatedAttributes = ['name', 'description'];
    protected $table = 'shop_orderestatus';

 public function orderEstatusTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\OrderEstatusTranslation');
    }

    public  function orderEstatusCountry()
    {
        return $this->hasMany('Modules\Shopping\Entities\OrderEstatusCountry');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_orderestatus_countries', 'orderestatus_id', 'country_id')->wherePivot('active', 1);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }





}
