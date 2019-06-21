<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\CMS\Libraries\Traits\DataPreLoad;


class ConfirmationType extends Eloquent
{


    protected $fillable = ['type','active','delete','last_modifier_id'];

    protected $table = 'shop_confirmation_types';



    public function confirmationbanner()
    {
        return $this->belongsTo('Modules\Shopping\Entities\ConfirmationBanner');
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
