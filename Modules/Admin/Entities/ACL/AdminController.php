<?php namespace Modules\Admin\Entities\ACL;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Dimsav\Translatable\Translatable;

class AdminController extends Eloquent
{
    use DataPreLoad, Translatable;

    /**
     * @var string
     */
    protected $fillable = ['controller','role_order','role_section','active'];

    public $translatedAttributes = ['role_name'];
    protected $table = 'glob_admin_controllers';
      public function traslations()
    {
        return $this->hasMany('Modules\Admin\Entities\ACL\AdminControllerTranslation');
    }
}