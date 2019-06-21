<?php namespace Modules\CMS\Entities;

use Eloquent;


class PageGroupTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name', 'item_name'];

    protected $table = 'cms_page_group_translations';
}