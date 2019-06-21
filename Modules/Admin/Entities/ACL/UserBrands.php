<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 19/04/2018
 * Time: 10:05 AM
 */

namespace Modules\Admin\Entities\ACL;


use Eloquent;

class UserBrands extends Eloquent
{
    protected $table = 'glob_user_brands';
    protected $fillable = ['user_id','brand_id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('Modules\Admin\Entities\ACL\User');
    }

    public function brand()
    {
        return $this->belongsTo('Modules\Admin\Entities\Brand');
    }
}