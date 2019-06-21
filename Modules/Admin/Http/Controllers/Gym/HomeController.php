<?php


namespace Modules\Admin\Http\Controllers\gym;


use Illuminate\Http\Request;
use  Modules\Admin\Http\Controllers\gym\MembresiaController;
use  Modules\Admin\Http\Controllers\gym\ClienteController;

use View;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
     public function index(Request $request)
    {
        $request->user()->authorizeRoles(['user', 'admin']);
    
    
        switch ($request->user()->roles[0]->id){
        case 1:
            
        return View::make('admin/admin',
                array("data"=>        
            $this->getDataAdmin()))->render();
        
        case 2;
                      return view('home');
      
        }
        
    }
        
    private function getDataAdmin(){
        $membresiaController= new MembresiaController();
        $clienteController= new ClienteController();
       $menbresias= $membresiaController->getListMembresias();
        $clientes=$clienteController->getClientes();
        $clientes_atrasados=$clienteController->getClientesAtrasados();
        $ventas="";        
        $links="";
        
        $data=array(
            'membresias'=>count($menbresias),
            'clientes'=>count($clientes),
            'ventas'=>0,
            'clientes_atrasados'=>count($clientes_atrasados),
            'links'=>$links
        );
        return $data;
        }
    
    public function home(){                        
      return view('admin/admin');

    }
        
}
