<?php namespace Modules\CMS\Entities;

use Eloquent;


class TemplateTranslation extends Eloquent
{
    public $timestamps = false;
  protected $fillable = ['template_id','label', 'locale'];

    protected $table = 'cms_template_translations';
}