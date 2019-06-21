<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Entities;

/**
 * Description of CountryTraslation
 *
 * @author sergio
 */
class CountryTraslationModel {
    //put your code here
    function getCountry_id() {
        return $this->country_id;
    }

    function getName() {
        return $this->name;
    }

    function getLocale() {
        return $this->locale;
    }

    function setCountry_id($country_id) {
        $this->country_id = $country_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }


}
