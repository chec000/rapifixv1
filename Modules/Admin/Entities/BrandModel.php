<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Entities;

/**
 * Description of BrandModel
 *
 * @author sergio
 */
class BrandModel {
    //put your code here
    public  $brand_id;
    public  $name;
    public  $alias;
    public $logo;
    public $locale;
    function getBrand_id() {
        return $this->brand_id;
    }

    function getName() {
        return $this->name;
    }

    function getAlias() {
        return $this->alias;
    }

    function getLogo() {
        return $this->logo;
    }

    function getLocale() {
        return $this->locale;
    }

    function setBrand_id($brand_id) {
        $this->brand_id = $brand_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAlias($alias) {
        $this->alias = $alias;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }


    
    
}
