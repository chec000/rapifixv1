<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\CMS\Entities;

/**
 * Description of SurveyReport
 *
 * @author sergio
 */
class SurveyReport {

    public $country;
    public  $type;
    
    public $country_id;
    
    public function GetType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type=$type;
    }
    
    public function  getCountryId(){
        return $this->country_id;
    }
    
    public function setCountryId($country_id){
        $this->country_id=$country_id;
    }
    public $preguntas;
    public  function getCountry(){
        return $this->country;
    }
    public function  setCountry($country){
        $this->country=$country;
    }
  
    public function getPreguntas(){
        return $this->preguntas;
    }
    public  function setPreguntas($preguntas){
        $this->preguntas=$preguntas;
    }

}

class Preguntas {

    public $pregunta_id;
    public $pregunta;
    public $respuesta;
    public  $date;
    public function getPregunta() {
          return $this->pregunta;
     }
     public function setPregunta($pregunta){
        $this->pregunta = $pregunta;
    }
    public function getRespuesta(){
        return $this->respuesta;
    }
    public function  setRespuesta($respuesta){
        $this->respuesta=$respuesta;
    }
  
    public function getDate(){
        return $this->date;
    }
     public function setDate($date){
         $this->date=$date;
     }
     public function  getPreguntaId(){
         return $this->pregunta_id;
     }
     
     public  function setPreguntaId($id_pregunta){
         $this->pregunta_id=$id_pregunta;
     }
}
