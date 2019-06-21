<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 19/04/2018
 * Time: 10:05 AM
 */

namespace Modules\Admin\Entities\ACL;


use Eloquent;

class UserCountries extends Eloquent
{
    protected $table = 'glob_user_countries';
    protected $fillable = ['user_id','country_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('Modules\Admin\Entities\ACL\User');
    }

    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }
}