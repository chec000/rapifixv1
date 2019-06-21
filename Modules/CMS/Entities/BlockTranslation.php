<?php namespace Modules\CMS\Entities;

use Eloquent;


class BlockTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['label'];

    protected $table = 'cms_block_translations';
}