<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventarioController
 *
 * @author sergio
 */
use Modules\Admin\Http\Controllers\AdminController as Controller;
use View;
class InventarioController  extends Controller{
    //put your code here
    
    public function  index(){
        $gastos= Gasto::get();
         $view = View::make('admin::gym.gastos.gastos', array('gastos' => $gastos,
        ));
        $this->layoutData['content'] = $view->render();
    
    }

                                        
}
