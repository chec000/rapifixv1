<?php namespace Modules\Admin\Entities\ACL;

use Eloquent;

class UserRoleTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['user_role_id','name', 'description','locale'];
    public $translatedAttributes = ['name', 'description'];

    protected $table = 'glob_user_rol_translations';


    public function language()
    {
        return $this->belongsTo('Modules\Admin\Entities\Language', 'locale_key','locale');
    }
    
    
    

}