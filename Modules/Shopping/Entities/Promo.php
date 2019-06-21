<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;


class Promo extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['clv_promo','active','delete','last_modifier_id'];

    public $translatedAttributes = ['name_header','description_header'];
    protected $table = 'shop_promo';

 public function promoTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\PromoTranslation');
    }

    public function promoprods(){
        return $this->hasMany('Modules\Shopping\Entities\PromoProd','promo_id','id')->where('delete',0);
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
