<?php namespace Modules\CMS\Entities;

use Eloquent;


class MenuTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['label'];

    protected $table = 'cms_menu_translations';
}