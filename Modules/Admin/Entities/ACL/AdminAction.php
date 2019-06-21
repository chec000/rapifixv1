<?php namespace Modules\Admin\Entities\ACL;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Dimsav\Translatable\Translatable;

class AdminAction extends Eloquent
{
    use DataPreLoad, Translatable;

    public $timestamps = false;
    protected $fillable = ['controller_id', 'action', 'action_others', 'active','edited_based','inherit'];

    public $translatedAttributes = ['name', 'about'];
    protected $table = 'glob_admin_actions';
// protected $fillable = ['controller_id','action','inherit','edit_based','active'];
    public static function inherited()
    {
        $actions = [];
        foreach (static::preloadArray() as $action) {
            if ($action->inherit) {
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public static function edit_based()
    {
        $actions = [];
        foreach (static::preloadArray() as $action) {
            if ($action->edit_based) {
                $actions[] = $action;
            }
        }
        return $actions;
    }
    public function traslations()
    {
        return $this->hasMany('Modules\Admin\Entities\ACL\AdminActionTranslation');
    }
}