<?php namespace Modules\Admin\Entities\ACL;

use Eloquent;

class AdminMenuTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['admin_menu_id','item_name', 'item_desc','locale'];

    protected $table = 'glob_admin_menu_translations';
}