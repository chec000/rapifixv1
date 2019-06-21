<?php namespace Modules\Admin\Entities\ACL;

use Eloquent;

class AdminControllerTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['admin_controller_id','role_name','locale'];

    protected $table = 'glob_admin_controller_translations';
}