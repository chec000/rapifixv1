<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Shopping\Entities;

/**
 * Description of OrderEstatusModel
 *
 * @author Alan
 */
class SecurityQuestionsModel {
    //put your code here
    public  $security_questions_id;
    public  $name;
    public $locale;

    function getSecurityquestions_id() {
        return $this->security_questions_id;
    }

    function getName() {
        return $this->name;
    }



    function getLocale() {
        return $this->locale;
    }

    function setSecurityquestions_id($security_questions_id) {
        $this->security_questions_id = $security_questions_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }


    
    
}
