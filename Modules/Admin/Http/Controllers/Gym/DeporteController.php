<?php


namespace Modules\Admin\Http\Controllers\gym;


use Illuminate\Http\Request;
use Modules\Admin\Entities\Gym\Deporte;
use Modules\Admin\Entities\Gym\ObjetivosDeporte;
use Modules\Admin\Entities\Gym\Articulo;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Auth;
use View;

class DeporteController extends Controller {

    public function index() {        
     $deportes= $this->getListDeportes();
        $view= View::make('admin::gym.deporte.listDeportes', array('deportes' => $deportes,
                     'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
            
            ));      
        $this->layoutData['content']=$view->render();
 }
 
 public function getListDeportes(){
        $deportes = Deporte::with('objetivos')->get();
     if(count($deportes)>0){
         return $deportes;                 
     }else{
         return array();
     }
 }
 
public function detailActividad($id){     
          $deporte= Deporte::find($id); 
          $this->layoutData['content']=View::make('admin::gym.deporte.detalle_deporte', 
                  array('deporte' => $deporte))->render();         
}

private function deporteAsProducto($deporte){
            $articulo= new Articulo;
       if($deporte!=null){
        $articulo->setDescripcion($deporte->descripcion);
        $articulo->setId($deporte->id);
        $articulo->setNombre($deporte->nombre);
        $articulo->setImagen($deporte->foto);
        $articulo->setPrecio($deporte->precio);
       }       
 
}

    public function addDeporte() {
        $objetivos = ObjetivosDeporte::where('activo', '=', 1)->get();
          $this->layoutData['content']=View::make('admin::gym.deporte.addDeporte', 
                  array('objetivos' => $objetivos))->render();
    }

    public function updateDeporte(Request $request) {
           try {           
            $deporte = Deporte::find($request->id);          
            $deporte->nombre = $request->name;
            $deporte->descripcion = $request->descripcion;
            $deporte->activo = ($request->has('activo')) ? 1 : 0;
             $deporte->foto = $request->imagen;
            $deporte->precio = $request->precio;
            $deporte->save();
            $deporte->objetivos()->detach();
            $deporte->objetivos()->attach($request->objetivos);
        } catch (Exception $ex) {
            
        }                
        return $this->index();
    }

    public function deleteDeporte(Request $request) {
        $deporte = Deporte::find($request->id);
        if ($deporte != null) {
            if ($deporte->activo == 1) {
                $deporte->activo = 0;
                $deporte->save();
                return 0;
            } else {
                $deporte->activo = 1;
                $deporte->save();
                return 1;
            }
        }
    }

    public function saveDeporte(Request $request) {
        try {
            $deporte = new Deporte();
            $deporte->nombre = $request->name;
            $deporte->descripcion = $request->descripcion;
            $deporte->activo = ($request->has('activo')) ? 1 : 0;
            $deporte->foto = $request->imagen;
            $deporte->precio = $request->precio;
            $deporte->save();
            $deporte->objetivos()->attach($request->objetivos);
        } catch (Exception $ex) {
            
        }
        return $this->addDeporte();
    }

    public function getDeporte($id) {
         $deporte =Deporte::with('objetivos')->find($id);  
         $objetivos = ObjetivosDeporte::where('activo', '=', 1)->get();

         $objetivos_selected=$deporte->objetivos;
         foreach ($objetivos as $ob){    
             foreach ($objetivos_selected as $os){                        
                 if($ob->id==$os->id){
                     $ob['selected']=true;
                 }
             }
         }
              $this->layoutData['content']=View::make('admin::gym.deporte.updateDeporte',
                      array('deporte'=>$deporte,'objetivos'=>$objetivos))->render();
    
    }

    public function eraseDeporte($id){
    
        $deporte= Deporte::find($id);
        $deporte->delete();
        return \redirect()->route('admin.Deporte.list_deportes')->with(['resultSaved' => 
                            array('success' => true, 'type_alert' =>'success',
                                'message_alert' => 'Eliminado correctamente')]);
        
    }
}
