<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Entities;

/**
 * Description of hotorialModel
 *
 * @author sergio
 */
class HistorialModel {
    

    function getMarcas() {
        return $this->marcas;
    }

    function getCountries() {
        return $this->countries;
    }

    function getStatus() {
        return $this->status;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setMarcas($marcas) {
        $this->marcas = $marcas;
    }

    function setCountries($countries) {
        $this->countries = $countries;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    function getLanguage() {
        return $this->language;
    }

    function setLanguage($language) {
        $this->language = $language;
    }


}





