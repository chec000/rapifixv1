<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SurveyReportsController
 *
 * @author sergio
 */

namespace Modules\Admin\Http\Controllers\Shopping;

use View;
use Excel;
use Illuminate\Http\Request;
use Modules\CMS\Entities\Survey;
use Modules\CMS\Entities\Preguntas;
use Modules\CMS\Entities\SurveyReport;
use Modules\Admin\Entities\Country;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class SurveyReportsController extends Controller {

    public function index() {
        $this->layoutData['content'] = View::make('admin::shopping.reports.survey_report');
    }

    public function generateReport(Request $request) {  
        if($request->from!=null&&$request->to!=null){
                if ($request->type_report == 1) {

            return $this->getGeneralReport($request);
        } else {

            return $this->getReportWithDetails($request);
        }
        }else{
            return redirect()->back()->withInput()
            ->with('msg', trans('admin::shopping.reports.messages.errors.noInfo'))
            ->with('alert', 'alert-warning');
        }
    
    }

    private function getReportWithDetails($request) {

        try {
            $type = $request->type;
            if ($request->country == 0) {
                $result = Survey::where([
                                ['type', '=', $type]])->whereBetween('created_at', [$request->from, $request->to])
                         ->orderBy('country_id', 'asc')
                        ->get();
            } else {
                $result = Survey::with('country')->where([['type', '=', $type], 
                    ['country_id', '=', $request->country]])
                        ->whereBetween('created_at', [$request->from, $request->to])
                         ->orderBy('country_id', 'asc')
                        ->get();
            }

            if (count($result) > 0) {
                $this->exportFile($this->armarExelDetallado($result, $type));
            } else {
                 return redirect()->back()->withInput()
            ->with('msg', trans('admin::shopping.reports.messages.errors.noInfo'))
            ->with('alert', 'alert-warning');
            }
        } catch (Exception $ex) {
             return redirect()->back()->withInput()
            ->with('msg', trans('admin::shopping.reports.messages.errors.noInfo'))
            ->with('alert', 'alert-warning');
        }
    }

    private function getGeneralReport($request) {
        $type = $request->type;
        if ($request->country == 0) {
            $result = Survey::with('country')->where([['type', '=', $type],
                    ])->whereDate('created_at', '>=', $request->from)->
                    whereDate('created_at', '<=', $request->to)->
                    select('id', 'country_id', 'type', 'question_id', 'answer', 'created_at', DB::raw('count(*) as cuantity'))
                    ->groupBy('answer', 'country_id')
                    ->orderBy('id', 'asc')
                    ->get();
        } else {
            $result = Survey::with('country')->where([['type', '=', $type],  ['country_id', '=', $request->country]
                    ])->whereDate('created_at', '>=', $request->from)->
                    whereDate('created_at', '<=', $request->to)->
                    select('id', 'country_id', 'type', 'question_id', 'answer', 'created_at', DB::raw('count(*) as cuantity'))
                    ->groupBy('answer', 'country_id')
                    ->orderBy('id', 'asc')
                    ->get();
            
        }

        if (count($result) > 0) {
            $this->exportFile($this->armarExelGeneral($result, $type));
            return $this->index();
        } else {
            return redirect()->back()->withInput()
            ->with('msg', trans('admin::shopping.reports.messages.errors.noInfo'))
            ->with('alert', 'alert-warning');
          
        }
    }

    private function armarExelDetallado($data, $type) {
        $array = array();  
        if (count($data) > 0) {
            foreach ($data as $result) {
                $newRow[trans('cms::survey.portal.code')] = $result->surveyed_code;
                $newRow[trans('cms::header.country')] = $result->country->name;
                $newRow[trans('cms::survey.portal.type')] = $type;
                $newRow[trans('cms::survey.portal.question')] =$result->question_id.'.-'. trans('cms::survey.portal.cuestions.cuestion-' . $result->question_id);
                $newRow[trans('cms::survey.portal.answer')] =  $result->answer;
                $newRow[trans('cms::survey.portal.comments')] = $result->comments;
                $newRow[trans('cms::survey.portal.date')] = $result->created_at;
                array_push($array, $newRow);
            }
        }


        return $array;
    }

    private function armarExelGeneral($data, $type) {
        $excel = array();
        
        if (count($data) > 0) {
            foreach ($data as $result) {
                if (count($excel) > 0) {
                    foreach ($excel as $campo) {
                        if ($campo->country_id == $result->country_id) {

                            if (count($campo->preguntas) > 0) {
                                foreach ($campo->preguntas as $pregunta) {
                                    if ($pregunta->pregunta_id == $result->question_id) {
                                        $pregunta->respuesta .= " " . $result->answer . '(' . $result->cuantity . ')';                                                                            
                                    }else{
                                      $exist=  $this->existPregunta($campo->preguntas, $result->question_id);
                                      if($exist!=true){
                                        $p = new Preguntas();
                                        $p->date = $result->created_at;
                                        $p->pregunta =$result->question_id.'.-'.  trans('cms::survey.portal.cuestions.cuestion-' . $result->question_id);
                                        $p->respuesta = $result->answer . '(' . $result->cuantity . ')';
                                        $p->pregunta_id = $result->question_id;
                                        array_push($campo->preguntas, $p);
                                      }
                                    }
                                }
                            }
                        } else {
                            $exist_inlist = $this->exist($excel, $result->country_id);
                            if ($exist_inlist != true) {
                                $rep = new SurveyReport();
                                $rep->country_id = $result->country->id;
                                $rep->setCountry($result->country->name);
                                $rep->type = $type;
                                $preguntas = new Preguntas();
                                $preguntas->date = $result->created_at;
                                $preguntas->pregunta = $result->question_id.'.-'. trans('cms::survey.portal.cuestions.cuestion-' . $result->question_id);
                                $preguntas->respuesta = $result->answer . '(' . $result->cuantity . ')';
                                $preguntas->pregunta_id = $result->question_id;
                                $rep->preguntas = array();
                                array_push($rep->preguntas, $preguntas);
                                array_push($excel, $rep);
                            }
                        }
                    }
                } else {
                    $rep = new SurveyReport();
                    $rep->country_id = $result->country->id;
                    $rep->setCountry($result->country->name);
                    $rep->type = $type;
                    $preguntas = new Preguntas();
                    $preguntas->date = $result->created_at;
                    $preguntas->pregunta =$result->question_id.'.-'. trans('cms::survey.portal.cuestions.cuestion-' . $result->question_id);
                    $preguntas->respuesta = $result->answer . '(' . $result->cuantity . ')';
                    $preguntas->pregunta_id = $result->question_id;
                    $rep->preguntas = array();
                    array_push($rep->preguntas, $preguntas);
                    array_push($excel, $rep);
                }
            }
        }
       return $this->buildExcel($excel);
       
    }
    
      private function buildExcel($data) {
        $array = array();
        if (count($data) > 0) {
            foreach ($data as $result) {
                $newRow[trans('cms::header.country')] = $result->country;
                $newRow[trans('cms::survey.portal.type')] = $result->type;
                foreach ($result->preguntas as $p){                                   
                $newRow[$p->pregunta] = $p->respuesta;                
                }         
                array_push($array, $newRow);
            }
        }

        return $array;
    }
    
    

    private function exist($lista, $id) {
        foreach ($lista as $l) {
            if ($l->country_id == $id) {
                return true;
            }
        }

        return false;
    }
   private function existPregunta($lista, $id) {
        foreach ($lista as $l) {
            if ($l->pregunta_id == $id) {
                return true;
            }
        }
        return false;
    }
    private function exportFile($data) {
        ob_end_clean();
        ob_start();
        Excel::create('survey_report' . date('Y_m_d-H:i:s'), function ($excel) use ($data) {
            $excel->sheet('Report', function ($sheet) use ($data) {
                $sheet->with($data, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

}
