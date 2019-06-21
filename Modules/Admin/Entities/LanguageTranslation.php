<?php namespace Modules\Admin\Entities;

use Eloquent;

class LanguageTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['language','language_country', 'locale'];

    protected $table = 'glob_language_translations';

}