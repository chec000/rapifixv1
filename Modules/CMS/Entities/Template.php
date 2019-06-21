<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use DB;
use Eloquent;
use Dimsav\Translatable\Translatable;

class Template extends Eloquent
{
    use DataPreLoad, Translatable;

    public $translatedAttributes = ['label'];
    protected $fillable = ['template','child_template','hidden','active'];
   
    protected $table = 'cms_templates';
    protected static $_blocksOfType = [];

    /**
     * @return array
     */
    protected static function _preloadByColumn()
    {
        return ['id', 'template'];
    }

    public static function name($template_id)
    {
        return self::preload($template_id)->template;
    }

    public static function getTemplateIds($templates) {
        $validTemplates = [];
        foreach ($templates as $templateIdentifier) {
            $template = static::preload($templateIdentifier);
            if ($template->exists) {
                $validTemplates[$template->id] = $template->id;
            }
        }
        return $validTemplates;
    }

    public static function blocks_of_type($type)
    {
        $numb_type = array();
        $blockIds = Block::getBlockIdsOfType($type);
        if (!empty($blockIds)) {
            $sw = ThemeBlock::where('theme_id', '=', config('cms.frontend.theme'))
                ->whereIn('block_id', $blockIds)->where('show_in_pages', '=', 1)->count();
            $themeTemplates = ThemeTemplate::where('theme_id', '=', config('cms.frontend.theme'))
                ->with(['blocks' => function ($q) use($blockIds) { $q->whereIn('block_id', $blockIds); }])->get();
            foreach ($themeTemplates as $themeTemplate) {
                $numb_type[$themeTemplate->template_id] = $sw + $themeTemplate->blocks->count();
            }
        }
        return $numb_type;
    }

    public static function preload_blocks_of_type($type, $templateId = null)
    {
        if (!isset(self::$_blocksOfType[$type])) {
            self::$_blocksOfType[$type] = self::blocks_of_type($type);
        }
        if ($templateId !== null) {
            return !empty(self::$_blocksOfType[$type][$templateId])?self::$_blocksOfType[$type][$templateId]:0;
        } else {
            return self::$_blocksOfType[$type];
        }
    }
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
     public function traslations()
    {
        return $this->hasMany('Modules\CMS\Entities\TemplateTranslation');
    }
}