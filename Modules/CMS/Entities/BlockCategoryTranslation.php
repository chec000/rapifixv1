<?php namespace Modules\CMS\Entities;

use Eloquent;


class BlockCategoryTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name'];

    protected $table = 'cms_block_category_translations';
}