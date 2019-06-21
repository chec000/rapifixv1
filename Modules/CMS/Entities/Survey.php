<?php
namespace Modules\CMS\Entities;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Modules\CMS\Libraries\Traits\DataPreLoad;
use Eloquent;

/**
 * Description of Survey
 *
 * @author sergio
 */
class Survey extends Eloquent{
    //put your code here
        use DataPreLoad;

    public $translatedAttributes = ['label'];
    protected $fillable = ['country_id','type','surveyed_code','question_id','answer','comments'];
   
    protected $table = 'cms_survey';
    
      protected static function _preload()
    {
        return['country_id','type','surveyed_code','question_id','answer','comments'];
    }
      public  function country()
        {
            return $this->hasOne('Modules\Admin\Entities\Country','id', 'country_id');
        }
    
}
