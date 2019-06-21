<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Modules\CMS\Libraries\Traits\DataPreLoad;

class Blacklist extends Eloquent
{

    use DataPreLoad;
    protected $fillable = ['country_id','eo_number','active','delete','last_modifier','created_at','updated_at'];


    protected $table = 'shop_blacklist';


    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_registration_references_countries', 'registration_references_id', 'country_id')->wherePivot('active', 1);
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
