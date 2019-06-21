<?php namespace Modules\Admin\Entities\ACL;

use Eloquent;
use Dimsav\Translatable\Translatable;

class AdminMenu extends Eloquent
{
    use Translatable;

    public $translatedAttributes = ['item_name', 'item_desc'];
 protected $fillable = ['action_id','parent','icon','active','order'];
    protected $table = 'glob_admin_menu';

    public function action()
    {
        return $this->belongsTo('Modules\Admin\Entities\ACL\AdminAction');
    }
    
      public function traslations()
    {
        return $this->hasMany('Modules\Admin\Entities\ACL\AdminMenuTranslation');
    }
    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToBrand', ['id'], 'domain');
        return static::_preloadGetArray('idToBrand');
    }
}