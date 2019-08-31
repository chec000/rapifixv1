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
class Email extends Eloquent{
    //put your code here
        use DataPreLoad;

    protected $fillable = ['email'];
   
    protected $table = 'cms_email';
    public $timestamps = false;
      protected static function _preload()
    {
        return['email'];
    }
    
}
