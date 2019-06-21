<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\CMS\Http\Controllers;

/**
 * Description of SurveyController
 *
 * @author sergio
 */
//use Illuminate\Http\Request as rqs;
//use Illuminate\Http\Response as res;
use Excel;
use Modules\CMS\Entities\Survey;
use Illuminate\Http\Request as rqs;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Illuminate\Support\Facades\DB;
use View;
class SurveyController extends Controller {

    //put your code here

 
    public function getActiveSurvey(){
          $settings =config('settings::frontend.survey.active');
          if($settings==1&&session()->get('portal.main.made_survey')==null){                      
              return json_encode(true);              
          }else{
              return json_encode(false);
          }
    }
        
    public function saveSurvey() {        
        
         app()->setLocale(session()->get('portal.main.app_locale'));          
         $type = config('settings::frontend.survey.type');
           $list_cuestions = config('cms.configurations_survey.' . $type);      
        $settings = config('settings::frontend.survey.active');
        if ($settings != null) {
            if ($settings==1) {
                $list_cuestions = config('cms.configurations_survey.' . $type);
                $questions = array_filter($list_cuestions, function ($elemento) {
                    if (in_array(session()->get('portal.main.country_corbiz'), $elemento['countries']) && $elemento['active']) {                                          
                        return $elemento;
                        } else {
                        return null;
                    }
                }
                );               
                $questions= $this->configurateSurveyTraslations($questions);
                if (count($questions)>0) {
                  $tab_data = [
                   'exist'=>true,
                  "view"=> View::make('themes.omnilife2018.sections.survey',
                    ['questions' => $questions])->render()
                 ];
                return $tab_data;    
                }else{

               $tab_data = [
                   'exist'=>false,                  
                 ];
                }

            }
        } else {
               $tab_data = [
                   'exist'=>false,                  
                 ];            
        }
    }
    
    private  function configurateSurveyTraslations($list){
       $listCuestions=array();
        foreach ($list as $question){           
        $question['question']=trans('cms::survey.portal.cuestions.cuestion-'.$question['id']);        
        foreach ($question['answers'] as $key =>$a){           
            $question['answers'][$key]=trans('cms::survey.portal.answers.'.$key);            
        }        
         if (array_key_exists ("comments", $question))
        {
             $question['comments']['label']=trans('cms::survey.portal.comments.question2');                      
            }            
            array_push($listCuestions, $question);           
        }
      return $listCuestions;
    }

    public function setSurrveyToSave(rqs $request){             
     $type = config('settings::frontend.survey.type');
       $country_code=session()->get('portal.main.countryCode');
       $code= strtoupper($this->generateRandomString(4));  
       $role=array(
           'type'=>$type,
          'country_id'=> session()->get('portal.main.country_id'),
           'surveyed_code'=>$country_code.$code,
           'question_id'=>$request->role_id,
           'answer'=>$request->role,
           'comments'=>($request->has('role_comment'))?$request->role_comment:"",           
           );            
 
           $redesign=array(
            'type'=>$type,
          'country_id'=> session()->get('portal.main.country_id'),
           'surveyed_code'=>$country_code.$code,
           'question_id'=>$request->redesign_id,
           'answer'=>$request->redesign,
           'comments'=>($request->has('redesign_comment'))?$request->redesign_comment:"",           
           );
           $performance=array(
          'type'=>$type,
          'country_id'=> session()->get('portal.main.country_id'),
           'surveyed_code'=>$country_code.$code,
           'question_id'=>$request->performance_id,
           'answer'=>$request->performance,
           'comments'=>($request->has('performance_comment'))?$request->performance_comment:"",           
           );
      try {
                    $role=new Survey($role);
                   $role->save();
                    $redesign=new Survey($redesign);
                   $redesign->save();
                    $performance=new Survey($performance);
                   $performance->save();
                   session()->put('portal.main.made_survey', true);
     return  1;
      } catch (Exception $ex) {
          return 0;
      }                         
    }
    
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
} 




}
