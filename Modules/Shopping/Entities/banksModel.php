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
class banksModel {
    //put your code here
    public  $bank_id;
    public  $name;
    public $description;
    public $locale;

    function getbank_id() {
        return $this->bank_id;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getLocale() {
        return $this->locale;
    }

    function setbank_id($bank_id) {
        $this->bank_id = $bank_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }


    
    
}
