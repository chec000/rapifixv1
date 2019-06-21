<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\DataModels;
use Modules\Admin\Entities\Language;
use Modules\Admin\Entities\LanguageTranslation;
/**
 * Description of LanguageModel
 *
 * @author sergio
 */
class LanguageModel {
    //put your code here
    function getLocale() {
        return $this->locale;
    }

    function getLanguage_id() {
        return $this->language_id;
    }

    function setLocale($locale) {
        $this->locale = $locale;
    }

    function setLanguage_id($language_id) {
        $this->language_id = $language_id;
    }

        
    function getLanguage() {
        return $this->language;
    }
 
        function setLanguage($language) {
        $this->language = $language;
    }

    public function saveLanguage($LanguageModel){    
        $language= new Language;
        $language->active=true;
        $language->save();        
      $this->saveLanguageTraslate($language->id,$LanguageModel);
    }
    
    private function saveLanguageTraslate($id_language,$languageModel){
   if($id_language!=0){
       $languageTraslations=new LanguageTranslation;
       $languageTraslations->language_id=$id_language;
       $languageTraslations->language=$languageModel->language;
       $languageTraslations->locale=$languageModel->locale;      
   }   
   return $languageModel;
    }
      

}
