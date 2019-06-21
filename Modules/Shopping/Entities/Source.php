<?php namespace Modules\Shopping\Entities;

use Eloquent;



class Source extends Eloquent
{


    protected $fillable = ['active','delete','source_name','url'];

    protected $table = 'shop_sources';













}
