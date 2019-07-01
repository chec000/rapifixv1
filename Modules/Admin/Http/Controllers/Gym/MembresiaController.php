<?php

namespace Modules\Admin\Http\Controllers\gym;

use Modules\Admin\Http\Controllers\AdminController as Controller;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Gym\Beneficio;
use Modules\Admin\Entities\Gym\TipoMembresia;
use Modules\Admin\Entities\Gym\Membresia;
use Modules\Admin\Entities\Gym\Deporte;
use View;
use Auth;

class MembresiaController extends Controller {

    public function index() {
        $membresias = $this->getListMembresias();
        $view = View::make('admin::gym.membresia.list', array("membresias" => $membresias,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
        ));
        $this->layoutData['content'] = $view->render();
    }

    public function getListMembresias() {
        $membresias = Membresia::with('tipo')->where('activo', '=', 1)->get();
        return $membresias;
    }

    public function getAdd() {
        $tipo = $this->tipos();
        $beneficios = $this->beneficios();
        $deportes = $this->deportes();

        $view = View::make('admin::gym.membresia.add', array(
                    "beneficios" => $beneficios,
                    "deportes" => $deportes,
                    "tipos" => $tipo));
        $this->layoutData['content'] = $view->render();
    }

    private function deportes() {
        $deportes = Deporte::where('activo', '=', 1)->get();
        return $deportes;
    }

    private function beneficios() {
        $beneficios = Beneficio::where('activo', '=', 1)->get();
        return $beneficios;
    }

    private function tipos() {
        $tipo = TipoMembresia::where('activo', '=', 1)->get();
        return $tipo;
    }

    public function addMebrecia(Request $request) {

        $membresia = new Membresia();
        $membresia->tipo_id = $request->tipo;
        $membresia->imagen = $request->flag;
        $membresia->nombre = $request->nombre;
        $membresia->precio = $request->precio;
        $membresia->descripcion = $request->requisitos;
        $membresia->duracion_meses = $request->duracion;
        $membresia->activo = 1;
        $membresia->save();

        if ($request->has('deporte') && $request->has('beneficio')) {
            $membresia->deportes()->attach($request->deporte);
            $membresia->beneficios()->attach($request->beneficio);
        }

        return $this->getAdd();
    }

    public function getMembresiaById($id) {
        $tipos_existentes = $this->tipos();

        $membresia = Membresia::find($id);
        $all_deportes = $this->deportes();
        $all_beneficios = $this->beneficios();
        $deportes_existentes = $membresia->deportes;
        $benficios_existentes = $membresia->beneficios;
        foreach ($all_beneficios as $b) {
            foreach ($benficios_existentes as $be) {
                if ($be->id == $b->id) {
                    $b['selected'] = true;
                }
            }
        }
        foreach ($all_deportes as $d) {
            foreach ($deportes_existentes as $de) {
                if ($de->id == $d->id) {
                    $d['selected'] = true;
                }
            }
        }
        $view = View::make('admin::gym.membresia.edit', array(
                    "membresia" => $membresia,
                    "tipos" => $tipos_existentes,
                    "beneficios_existestes" => $all_beneficios,
                    "deportes_existentes" => $all_deportes,
        ));
        $this->layoutData['content'] = $view->render();
    }

    public function updateMembrecia(Request $request) {
        try {
            $membresia = Membresia::find($request->id);
            $membresia->nombre = $request->nombre;
            $membresia->tipo_id = $request->tipo;
            $membresia->nombre = $request->nombre;
            $membresia->imagen = $request->flag;
            $membresia->precio = $request->precio;
            $membresia->descripcion = $request->requisitos;
            $membresia->duracion_meses = $request->duracion;
            $membresia->deportes()->detach();
            $membresia->beneficios()->detach();
            $membresia->deportes()->attach($request->deportes);
            $membresia->beneficios()->attach($request->beneficio);
            $membresia->save();
        } catch (Exception $ex) {
            
        }
        return redirect()->route('admin.Membresia.list_membresia');
    }

    public function activeInactiveMembresia(Request $request) {

        $membresia = Membresia::find($request->id);

        if ($membresia != null) {
            if ($membresia->activo == 1) {
                $membresia->activo = 0;
                $membresia->save();
                return 0;
            } else {
                $membresia->activo = 1;
                $membresia->save();
                return 1;
            }
        }
    }
public function  detailMembresia($id){
                $membresia = Membresia::find($id);

                if($membresia!=null){
     $view = View::make('admin::gym.membresia.detalle_membresia', array(
                    "membresia" => $membresia,
        ));
        $this->layoutData['content'] = $view->render();                       
                }else{
                    $this->layoutData['content']="";
                }
                
}
    
}
