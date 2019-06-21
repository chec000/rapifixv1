<?php namespace Modules\Admin\Entities;

use Eloquent;

class CountryTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['country_id','name','locale'];

    protected $table = 'glob_country_translations';



}