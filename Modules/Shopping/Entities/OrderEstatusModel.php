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
class OrderEstatusModel {
    //put your code here
    public  $order_estatus_id;
    public  $name;
    public $locale;

    function getOrderestatus_id() {
        return $this->order_estatus_id;
    }

    function getName() {
        return $this->name;
    }



    function getLocale() {
        return $this->locale;
    }

    function setOrderestatus_id($order_estatus_id) {
        $this->order_estatus_id = $order_estatus_id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }


    
    
}
