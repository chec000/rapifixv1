<?php namespace Modules\CMS\Entities;

use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;
use Dimsav\Translatable\Translatable;

class BlockCategory extends Eloquent
{
    use DataPreLoad, Translatable;

    public $translatedAttributes = ['name'];
    protected $table = 'cms_block_category';


}