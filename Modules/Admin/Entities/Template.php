<?php
  namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Dimsav\Translatable\Translatable;

class Template extends Model
{
        use DataPreLoad, Translatable;  
    protected $fillable = ['template','child_template','hidden'];
    public $translatedAttributes = ['label', 'locale'];
        protected $table = 'cms_templates';

    public static function selectArray()
    {
        static::_preloadOnce(null, 'idToTemplate', ['id'], 'template');
        return static::_preloadGetArray('idToTemplate');
    }

    public static function selectArrayActive($template = null)
    {
        $templates_list = [];
        $templateActive = $template != null ? $template : self::where('active', '=', 1)->get();
        if(count($$templateActive) > 0){
            foreach($$templateActive as $template) {
                $templates_list[$template->id] = $template->template;
            }
        }
        return $templates_list;
    }
}
