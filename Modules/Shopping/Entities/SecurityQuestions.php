<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Modules\Admin\Entities\Country;
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Modules\Shopping\Entities\SecurityQuestionsTranslation;

class SecurityQuestions extends Eloquent
{

    use Translatable, DataPreLoad;
    protected $fillable = ['active','delete','key_question','last_modifier'];

    public $translatedAttributes = ['name'];
    protected $table = 'shop_security_questions';
    public $translationModel      = 'Modules\Shopping\Entities\SecurityQuestionsTranslation';
    public $translationForeignKey = 'security_questions_id';

 public function securityQuestionsTraslations()
    {
        return $this->hasMany('Modules\Shopping\Entities\SecurityQuestionsTranslation');
    }

    public function securityQuestionsCountry()
    {
        return $this->hasMany('Modules\Shopping\Entities\SecurityQuestionsCountry');
    }

    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_security_questions_countries', 'security_questions_id', 'country_id')->wherePivot('active', 1);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }
}