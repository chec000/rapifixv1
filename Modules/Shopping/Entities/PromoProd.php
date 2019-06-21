<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;


class PromoProd extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['promo_id','clv_producto','active','delete','last_modifier_id'];

    public $translatedAttributes = ['name','description'];
    protected $table = 'shop_promo_prod';

 public function promoProdTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\PromoProdTranslation');
    }


    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }


    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }





}
