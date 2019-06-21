<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Shopping\Entities;
use Eloquent;
use Modules\Admin\Entities\Country;

/**

 *
 * @author Alan
 */
class SecurityQuestionsCountry extends Eloquent{
    //put your code here
    //  use Translatable;
    public $timestamps = false;
    protected $fillable = ['security_questions_id','country_id','active'];

    protected $table = 'shop_security_questions_countries';
    
    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }

    public function securityquestions()
    {
        return $this->belongsTo('Modules\Shopping\Entities\SecurityQuestions');
    }

    public static function selectQuestionCountry($corbiz_key, $key_question)
    {
        $question = SecurityQuestions::select('shop_security_questions.*')
            ->join('shop_security_questions_countries', 'shop_security_questions.id', '=', 'shop_security_questions_countries.security_questions_id')
            ->join('glob_countries', 'shop_security_questions_countries.country_id', '=', 'glob_countries.id')
            ->where('glob_countries.corbiz_key', $corbiz_key)
            ->where('shop_security_questions.key_question', $key_question)
            ->where('shop_security_questions.active', 1)
            ->where('shop_security_questions.delete', 0)
            ->where('shop_security_questions_countries.active', 1)
            ->first();

        return $question;
    }
}
