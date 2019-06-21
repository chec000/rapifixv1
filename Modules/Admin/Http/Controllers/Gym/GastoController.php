<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GastosController
 *
 * @author sergio
 */
namespace Modules\Admin\Http\Controllers\gym;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Entities\Gym\Gasto;
use Illuminate\Http\Request;
use Validator;
use View;

class GastoController extends Controller {
    //put your code here
    
    
    public function index(){
        $gastos= Gasto::get();
         $view = View::make('admin::gym.gastos.gastos', array('gastos' => $gastos,
        ));
        $this->layoutData['content'] = $view->render();
    
    }
    
    
    public function getAdd() {     
        $view = View::make('admin::gym.gastos.add');
        $this->layoutData['content'] = $view->render();
    }
    
    public function postAdd(Request $request){        
            $v = Validator::make($request->all(), array(
                       'code_product'=>'required',
                        'nombre' => 'required',
                        'descripcion' => 'required',
                        'valor_costo' => 'required',
                        'cantidad' => 'required',
                        'valor_total' => 'required',
                        'fecha_compra' => 'required',
                )
            );
            if ($v->passes()) {            
        try {
        $gasto= new Gasto();
        $gasto->nombre=$request->nombre;
        $gasto->cod_producto=$request->code_product;
        $gasto->descripcion=$request->descripcion;
        $gasto->valor_costo=$request->valor_costo;
        $gasto->cantidad=$request->cantidad;
        $gasto->valor_total=$request->valor_total;
        $gasto->fecha_compra=$request->fecha_compra;
        $gasto->save();
        return $this->getAdd();
                
            
        } catch (Exception $ex) {         
                    FormMessage::set($v->messages());
                    $this->getAdd();   
        }
            }else{
                    FormMessage::set($v->messages());
                    $this->getAdd();  
            }
    }
    
}









