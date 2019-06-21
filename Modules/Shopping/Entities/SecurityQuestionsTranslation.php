<?php namespace Modules\Shopping\Entities;

use Eloquent;

class SecurityQuestionsTranslation extends Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name','locale'];
    
    protected $table = 'shop_security_questions_translations';

    public function securityquestions()
    {
        return $this->belongsToMany('Modules\Shopping\Entities\SecurityQuestions');
    }
    
}