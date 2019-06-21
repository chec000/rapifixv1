<?php namespace Modules\Admin\Entities\ACL;

use Eloquent;

class AdminActionTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['admin_action_id','name', 'about','locale'];

    protected $table = 'glob_admin_action_translations';
}