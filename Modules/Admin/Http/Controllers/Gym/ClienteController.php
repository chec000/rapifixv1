<?php

namespace Modules\Admin\Http\Controllers\gym;
use Modules\Admin\Entities\Gym\Abstractas\TipoProducto;
use Illuminate\Http\Request;
use View;
use Modules\Admin\Entities\Gym\UsuarioCliente;
use Modules\Admin\Entities\Gym\Pais;
use Modules\Admin\Entities\Gym\Membresia;
use Modules\Admin\Entities\Gym\Deporte;
use Modules\Admin\Http\Controllers\gym\Auth\RegisterController;
use Modules\Admin\Http\Controllers\AdminController as Controller;
use Modules\Admin\Http\Controllers\gym\MembresiaController;
use Modules\Admin\Http\Controllers\gym\GymController;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Entities\Gym\Articulo;
use Modules\Admin\Entities\Gym\Venta;
use Modules\Admin\Entities\Gym\DetalleVenta;
use Modules\Admin\Entities\Gym\User;
use Modules\Admin\Entities\Gym\ClienteMembresia;
use Validator;
use Auth;
use Carbon\Carbon;

class ClienteController extends Controller {

    public $total_pagar;

    public function index() {

        $clientes = $this->getClientes();
        $view = View::make('admin::gym.cliente.listClientes', array('clientes' => $clientes,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
        ));
        $this->layoutData['content'] = $view->render();
    }

    public function listMembresias() {

        $m = new MembresiaController();
        $membresias = $m->getListMembresias();
        $view = View::make('admin::gym.ventas.list_membresias_as_product', array("membresias" => $membresias))->render();

        return $view;
    }

    public function getClientes() {
        $cliente = UsuarioCliente::with('usuario')->get();

        return $cliente;
    }

    public function getCliente(Request $request) {

        if ($request->isId == true) {
            $cliente = User::find($request->cliente);
        } else {
            $cliente = User::where('name', '=', $request->cliente)->first();
        }

        $cl = UsuarioCliente::where('id_usuario', '=', $cliente->id)->first();
        if ($cliente != null && $cl != null) {
            if ($cl != null) {
                $membresias = $cl->compraMembresia()->get();
            } else {
                $membresias = [];
            }
            $view = View::make('admin::gym.membresia.list_membresias_compradas', array('membresias' => $membresias))->render();
            session()->put('portal.main.gym.cliente.id', $cliente->id);
            session()->put('portal.main.gym.cliente.tipo_venta', 2);

            return array(
                "data" => $cliente,
                "code" => 200,
                'membresias_actuales' => $view,
                'url_membresia' => route('admin.venta.addMembresia', ['id' => $cliente->id]),
                'url_add_actividad' => route('admin.venta.addActividad', ['id' => $cliente->id])
            );
        } else {
            return array(
                "data" => "No se encontro ningun cliente, intentelo nuevamente",
                "code" => 300
            );
        }

        return $cliente;
    }

    public function saveMembresia(Request $request) {
        $tipo_servicio = 1;
        if ($request->tipo_servicio == 2) {
            $tipo_servicio = 2;
        }

        if ($tipo_servicio == 1) {
            $membresia_existente = $this->verificarMembresia($request->id_membresia);
            if ($membresia_existente == null) {
                $membresia = Membresia::find($request->id_membresia);
                $membresia['cantidad'] = $request->cantidad;
                $membresia['subtotal'] = $request->cantidad * $membresia->precio;
                $this->total_pagar = $this->total_pagar + $membresia['subtotal'];
                session()->push('portal.main.gym.cliente.membresias', $membresia);
                $this->cotizarMembresia();
                $view = View::make('admin::gym.ventas.add_membresia', array(
                            "tipo_servicio" => 1,
                            "membresia" => $membresia))->render();
                $array = array(
                    "data" => $view,
                    "code" => 100
                );
                return $array;
            } else {
                $cantidad = $membresia_existente['cantidad'] + $request->cantidad;
                $subtotal = $membresia_existente['cantidad'] * $membresia_existente['precio'];
                $this->total_pagar = $subtotal;
                $index = $this->getIndex($membresia_existente->id);
                $this->updateMembresiaSession($subtotal, $index, $cantidad);
                return $membresia_existente;
            }
        } else {
            //Aqui va lo de actividades
        return     $this->saveActivity($request, $tipo_servicio);
        }
    }

    private function saveActivity($request, $tipo_servicio) {
        $actividad_existente = $this->verificarActividad($request->id_actividad);
        if ($actividad_existente == null) {
            $actividad = Deporte::find($request->id_actividad);
            $actividad['cantidad'] = $request->cantidad;
            $actividad['subtotal'] = $request->cantidad * $actividad->precio;
            $this->total_pagar = $this->total_pagar + $actividad['subtotal'];
            session()->push('portal.main.gym.cliente.actividades', $actividad);
            $this->cotizarMembresia($tipo_servicio);
            $view = View::make('admin::gym.ventas.add_membresia', array(
                        "actividad" => $actividad, 'tipo_servicio' => $tipo_servicio))->render();
            $array = array(
                "data" => $view,
                "code" => 100
            );
            return $array;
        } else {
            $cantidad = $actividad_existente['cantidad'] + $request->cantidad;
            $subtotal = $actividad_existente['cantidad'] * $actividad_existente['precio'];
            $this->total_pagar = $subtotal;
            $index = $this->getIndex($actividad_existente->id, $tipo_servicio);
            $this->updateMembresiaSession($subtotal, $index, $cantidad, $tipo_servicio);
            return $actividad_existente;
        }
    }

    private function updateMembresiaSession($subtotal, $index, $cantidad, $tipo_servicio = null) {
        if ($tipo_servicio == 2) {
            session()->get('portal.main.gym.cliente.actividades')[$index]->cantidad = $cantidad;
            session()->get('portal.main.gym.cliente.actividades')[$index]->subtotal = $subtotal;
        } else {
            session()->get('portal.main.gym.cliente.membresias')[$index]->cantidad = $cantidad;
            session()->get('portal.main.gym.cliente.membresias')[$index]->subtotal = $subtotal;
        }
    }

    private function getIndex($id, $tipo_servicio = null) {
        if ($tipo_servicio == 2) {
            $actividades = session()->get('portal.main.gym.cliente.actividades');
            if ($actividades != null) {
                foreach ($actividades as $key => $m) {
                    if ($m->id == $id) {
                        return $key;
                    }
                }
            }
        } else {
            $membresias = session()->get('portal.main.gym.cliente.membresias');
            if ($membresias != null) {
                foreach ($membresias as $key => $m) {
                    if ($m->id == $id) {
                        return $key;
                    }
                }
            }
        }

        return null;
    }

    public function addMembresiaCliente(Request $request) {

        $membresia_existente = $this->verificarMembresia($request->id_membresia);
        if ($membresia_existente != null) {

            $index = $this->getIndex($membresia_existente->id);
            if ($request->tipo == 1) {
                $cantidad = $membresia_existente['cantidad'] + 1;
                $subtotal = $cantidad * $membresia_existente['precio'];
                $index = $this->getIndex($membresia_existente->id);
                $this->total_pagar = $this->total_pagar + $membresia_existente['precio'];
                $this->updateMembresiaSession($subtotal, $index, $cantidad);
            } else {
                $cantidad = $membresia_existente['cantidad'] - 1;
                $subtotal = $cantidad * $membresia_existente['precio'];
                $this->total_pagar = $this->total_pagar + $membresia_existente['precio'];
                $index = $this->getIndex($membresia_existente->id);
                $this->updateMembresiaSession($subtotal, $index, $cantidad);
            }
        }

        $this->cotizarMembresia($request->tipo);
        return array(
            'subtotal' => $subtotal,
            'cantidad' => $cantidad,
            'total_pagar' => session()->get('portal.main.gym.cliente.total_pagar')
        );
    }

    public function cotizarMembresia($type = null) {
        $total = 0;
        if ($type == 2) {
            $actividades = session()->get('portal.main.gym.cliente.actividades');
            if ($actividades != null) {
                foreach ($actividades as $m) {
                    $total = $total + $m->subtotal;
                }
                session()->put('portal.main.gym.cliente.total_pagar', $total);
            }
        } else {

            $membresias = session()->get('portal.main.gym.cliente.membresias');
            if ($membresias != null) {
                foreach ($membresias as $m) {
                    $total = $total + $m->subtotal;
                }
                session()->put('portal.main.gym.cliente.total_pagar', $total);
            }
        }
    }

    private function verificarMembresia($id_membresia) {

        $membresias = session()->get('portal.main.gym.cliente.membresias');
        if ($membresias != null) {
            foreach ($membresias as $m) {
                if ($m->id == $id_membresia) {
                    return $m;
                }
            }
        }

        return null;
    }

    private function verificarActividad($id) {

        $actividades = session()->get('portal.main.gym.cliente.actividades');
        if ($actividades != null) {
            foreach ($actividades as $m) {
                if ($m->id == $id) {
                    return $m;
                }
            }
        }

        return null;
    }

    public function sendEmailReminder($membresias, $usuario, $asunto, $rutaArchivo) {
        ini_set('max_execution_time', 300);
        $articulos = $membresias;
        try {
            Mail::send('admin::gym.emails.registro', ['user' => $usuario, "membresias" => $articulos, 'total' => 0], function ($m) use ($usuario, $asunto, $rutaArchivo) {
                $m->attach($rutaArchivo, array(
                    'as' => 'factura-' . $usuario->name . '.pdf',
                    'mime' => 'application/pdf')
                );
                $m->to($usuario->email, $usuario->name)->subject($asunto);
            });
            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return $ex->getText;
        }
    }

    public function sendEmailFill($membresias, $usuario, $asunto, $rutaArchivo) {
        ini_set('max_execution_time', 300);
        $articulos = $membresias;
        try {
            Mail::send('admin::gym.emails.factura_renovacion', ['user' => $usuario, "membresias" => $articulos, 'total' => 0], function ($m) use ($usuario, $asunto, $rutaArchivo) {
                $m->attach($rutaArchivo, array(
                    'as' => 'factura-' . $usuario->name . '.pdf',
                    'mime' => 'application/pdf')
                );
                $m->to($usuario->email, $usuario->name)->subject($asunto);
            });
            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return $ex->getText;
        }
    }

    public function getDetalleVenta() {
        $membresias = session()->get('portal.main.gym.cliente.membresias');
        $articulos = $this->buidCheckout($membresias, 1);
        $confirmacion_modal = View::make('admin::gym.modals.confirmar_pago_modal')->render();
        $view = View::make('admin::gym.ventas.detalle_venta', ["membresias" => $articulos,
                    "total" => $this->total_pagar,
                    "modal" => $confirmacion_modal
        ]);
        return $view->render();
    }

    public function buidCheckout($membresias, $tipo) {
        $articulos = [];
        if ($tipo == 1) {
            $m = Membresia::find(1);
            $articulo = new Articulo();
            $articulo->setDuracion_meses($m->duracion_meses);
            $articulo->setCantidad(1);
            $articulo->setDescripcion($m->descripcion);
            $articulo->setId($m->id);
            $articulo->setNombre($m->nombre);
            $articulo->setPrecio($m->precio);
            $articulo->setSubtotal($m->precio);
             $articulo->setTipo_producto(TipoProducto::membresia);
           $articulo->setDuracion_meses($m->duracion_meses);
            $articulo->setTipo(0);
            $this->total_pagar = $this->total_pagar + $articulo->getPrecio();
            $articulo->setImagen($m->imagen);
            array_push($articulos, $articulo);
        }
        foreach ($membresias as $key => $m) {
            $articulo = new Articulo();
            $articulo->setNombre($m->nombre);
            $articulo->setDescripcion($m->descripcion);
            $articulo->setId($m->id);
            $articulo->setPrecio($m->precio);
            $articulo->setSubtotal($m->subtotal);
            $articulo->setCantidad($m->cantidad);
            $articulo->setImagen($m->imagen);
             $articulo->setDuracion_meses($m->duracion_meses);
             $articulo->setTipo_producto(TipoProducto::membresia);
            $articulo->setTipo($m->tipo_id);
            $this->total_pagar = $this->total_pagar + $articulo->getSubtotal();
            $retu = $this->verificarArticulo($articulos, $m);
            if (!$retu) {
                array_push($articulos, $articulo);
            }
        }
        session()->put('portal.main.gym.cliente.total_pagar', $this->total_pagar);
        return $articulos;
    }

    
    public function buidCheckoutActividades($actividades) {
        $articulos = [];
        foreach ($actividades as $key => $m) {
            $articulo = new Articulo();
            $articulo->setNombre($m->nombre);
            $articulo->setDescripcion($m->descripcion);
            $articulo->setId($m->id);
            $articulo->setPrecio($m->precio);
            $articulo->setSubtotal($m->subtotal);
            $articulo->setCantidad($m->cantidad);
            $articulo->setImagen($m->foto);
            $articulo->setTipo_producto(TipoProducto::deporte);
            $articulo->setTipo(0);
            $this->total_pagar = $this->total_pagar + $articulo->getSubtotal();
            $retu = $this->verificarArticulo($articulos, $m);
            if (!$retu) {
                array_push($articulos, $articulo);
            }
        }
        session()->put('portal.main.gym.cliente.total_pagar', $this->total_pagar);
        return $articulos;
    }
    
    private function verificarArticulo($articulos, $articulo) {
        foreach ($articulos as $a) {
            if ($a->id == $articulo->id) {
                return true;
            }
        }


        return false;
    }

    public function generateReport($membresias, $user, $path,$name_report) {
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
         * */
        $directorio = public_path() . '/uploads/facturas';
        $date = new \DateTime();
        if (file_exists($directorio)) {

            $pdf = PDF::loadView('admin::gym.ventas.factura_venta', ['date' => $date->format('d-M-Y'), "membresias" => $membresias, "user" => $user, "total" => $this->total_pagar]);

            file_put_contents($directorio . '/' .  $name_report.".pdf", $pdf->stream());
        } else {
            mkdir($directorio, 7777, true);
            $pdf = PDF::loadView('admin::gym.ventas.factura_venta', ['date' => $date->format('d-M-Y')]);
            file_put_contents($directorio . '/' . $name_report.".pdf", $pdf->stream());
        }
        $archivo = $path . '/uploads/facturas/' .$name_report . '.pdf';
        $archivoEmail = $directorio . "/" .$name_report. ".pdf";

        return array("archivo" => $archivo, "archivoEmail" => $archivoEmail);

//        return compact($archivoEmail,$archivo);
    }

    private function buildMembresiasPDF($membreasias, $user) {
        $date = new \DateTime();
        $pdf = PDF::loadView('admin::gym.ventas.factura_venta', ['date' => $date->format('d-M-Y'), "membresias" => $membreasias, "user" => $user, "total" => $this->total_pagar]);

        return $pdf->stream();
    }

    public function getClientesAtrasados() {
        $cliente = UsuarioCliente::where([['activo', '=', 1], ['estado_cliente', '=', 'Atrasado']])->get();
        return $cliente;
    }

    public function getUsersAsCliente(Request $request) {

        $clientes = User::where('name', 'like', "%{$request->campo}%")->orWhere('apellido_paterno', 'like', "%{$request->campo}%"
                )->orWhere('clave_unica', 'like', "%{$request->campo}%")->get();
        $uc = false;
        if (!count($clientes) > 0) {
            $clientes = UsuarioCliente::where('codigo_cliente', 'like', "%{$request->campo}%")->get();
            $uc = true;
        }
        $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
        if (count($clientes) > 0) {
            foreach ($clientes as $row) {
                if ($uc) {
                    $output .= '</li><li data-key=' . $row->usuario->id . '><a href="#">' . $row->usuario->name . ' ' . $row->usuario->apellido_paterno . '</a></li>';
                } else {
                    $output .= '</li><li data-key=' . $row->id . '><a href="#">' . $row->name . ' ' . $row->apellido_paterno . '</a></li>';
                }
            }
            $output .= '</ul>';
        }

        return $output;
    }

    public function getCheckout() {
        $view = View::make('admin::gym.ventas.detalle_venta', ["membresias" => session()->get('portal.main.gym.cliente.membresias')]);
        return $view->render();
    }

    public function addClienteGet() {
        session()->forget('portal.main.gym.cliente.id');
        session()->forget('portal.main.gym.cliente.tipo_venta');
        $cliente = session()->get('portal.main.gym.cliente');
        $paises = Pais::where('activo', '=', 1)->get();
        $list_membresias = $this->listMembresias();
        $view = View::make('admin::gym.cliente.addCliente'
                        , array('paises' => $paises, "list_membresias" => $list_membresias, "venta_aside" => $this->getCarrito(),
                    'cliente' => ($cliente != null) ? $cliente : array()
                        )
        );

        $this->layoutData['content'] = $view->render();
    }

    public function getCarrito($tipo_servicio=null) {
        $membresias_view = "";
        if($tipo_servicio==2){
        if (session()->has('portal.main.gym.cliente.actividades')) {
            foreach (session()->get('portal.main.gym.cliente.actividades') as $membresia) {
                $view = View::make('admin::gym.ventas.add_membresia', array("actividad" => $membresia,
                        "tipo_servicio"=>$tipo_servicio
                        ));

                $membresias_view .= $view;
            }
        }
        $venta_aside = View::make('admin::gym.ventas.venta_aside', array("membresias" => $membresias_view))->render();
            
        }else{
        if (session()->has('portal.main.gym.cliente.membresias')) {
            foreach (session()->get('portal.main.gym.cliente.membresias') as $membresia) {
                $view = View::make('admin::gym.ventas.add_membresia', array("membresia" => $membresia,
                        "tipo_servicio"=>$tipo_servicio
                        ));

                $membresias_view .= $view;
            }
        }
        $venta_aside = View::make('admin::gym.ventas.venta_aside', array("membresias" => $membresias_view))->render();
            
        }    

        return $venta_aside;
    }

    public function getClienteUsuario(Request $request) {
        $users = User::where('nombre', 'like', "%{$request->nombre}%")->get();
        if (count($users) > 0) {
            return $users;
        } else {
            return null;
        }
    }

    public function saveCliente(Request $request) {

        if (!User::where('clave_unica', '=', $request->clave_unica)->count() > 0) {
            if (!session()->has('portal.main.gym.cliente')) {
                $v = Validator::make($request->all(), array(
                            'name' => 'required',
                            'apellido_paterno' => 'required',
                            'telefono' => 'required|numeric|min:9',
                            'telefono_celular' => 'required|numeric|min:9',
                            'fecha_nacimiento' => 'required',
                            'estado_civil' => 'required',
                            'pais' => 'required',
                            'estado' => 'required',
                            'direccion' => 'required',
                            'email' => 'required|email',
                            'password' => 'required'
                                )
                );

                if ($v->passes()) {
                    $cliente = $this->confirmarGuardado($request);
                    if ($request->has('only_client')) {
                        return redirect()->route('admin.client.list_clientes');
                    } else {
                        session()->put('portal.main.gym.cliente', $request->all());
                        session()->put('portal.main.gym.cliente.id', $cliente->id);
                    }
                    $result = array(
                        "status" => true,
                        "code" => 200,
                        'data' => session()->get('portal.main.gym.cliente')
                    );
                } else {
                    if ($request->has('only_client')) {
                        return redirect()->route('admin.client.list_clientes');
                    } else {
                        $result = array(
                            "status" => false,
                            "code" => 500,
                            'data' => $v->messages()
                        );
                    }
                }
                return $result;
            } else {
                if ($request->has('only_client')) {
                    return redirect()->route('admin.client.list_clientes');
                } else {
                    $result = array(
                        "status" => false,
                        "code" => 300,
                        'data' => "Hay un cliente en proceso de inscripción"
                    );
                }
            }
        } else {
            if ($request->has('only_client')) {
                return redirect()->route('admin.client.list_clientes');
            } else {
                $result = array(
                    "status" => true,
                    "code" => 200,
                    'data' => session()->get('portal.main.gym.cliente')
                );
            }
        }


        return $result;
    }

    public function finalizarCompra(Request $request) {
//        $date = new \DateTime(); 
        $tipo_venta = $request->tipo_venta;        
        $date = Carbon::now();
        try {
            $diferencia = 0;
            DB::beginTransaction();

        if($request->tipo_producto==2){
            $articulos = $this->buidCheckoutActividades(session()->get('portal.main.gym.cliente.actividades'));            
        }else{
            $articulos = $this->buidCheckout(session()->get('portal.main.gym.cliente.membresias'), $tipo_venta);            
        }                       
        $user = UsuarioCliente::find(session()->get('portal.main.gym.cliente.id'));
            $actual = $date->format('Y-m-d');
            $venta = new Venta();
            $venta->fecha = $actual;
            $venta->id_cliente = session()->get('portal.main.gym.cliente.id');
            $venta->nombre_cliente = session()->get('portal.main.gym.cliente.name') . ' ' . session()->get('portal.main.gym.cliente.apellido_paterno');
            $venta->id_empleado = Auth::user()->id;
            $venta->tipo_pago = $request->tipo_pago;
            $venta->total = session()->get('portal.main.gym.cliente.total_pagar');
            $venta->estatus = "terminado";
            $venta->concepto = $request->concepto;
            $venta->codigo_factura = $this->getCodigoReporte();
            $venta->diferencia = $diferencia;
            $venta->descuento_id = 2;
            $venta->save();
   
         
            if ($request->tipo_pago == 'efectivo') {
                if (session()->get('portal.main.gym.cliente.total_pagar') >= $request->dinero_cliente) {
                    $diferencia = $request->pago_cliente - $venta->total;
                }
            }
                                    
            foreach ($articulos as $m) {
               
                if($m->tipo_producto==2){
                          $user->actividades()->attach($m->id);
                }else{
                          $user->membresias()->attach($m->id);
                }                
                $cm = new ClienteMembresia;
                $cm->cliente_id = $user->id;
                $cm->membresia_id = $m->id;
                $cm->nombre_membresia = $m->nombre;
                $cm->precio = $m->precio;
                $cm->compra_id = $venta->id;
                $cm->fecha_compra = $actual;
                $cm->tipo=$m->tipo_producto;
                $cm->fecha_proximo_pago = $date->addMonth($m->duracion_meses);
                $cm->save();
                $detalle = new DetalleVenta();
                $detalle->venta_id = $venta->id;
                $detalle->tipo_producto_id=$m->tipo_producto;
                $detalle->producto_id = $m->id;
                $detalle->producto = $m->nombre;
                $detalle->cantidad = $m->cantidad;
                $detalle->subtotal = $m->subtotal;
                $venta->detalleVenta()->save($detalle);
            }

            $ruta = $this->generateReport($articulos, $user->usuario, $request->getSchemeAndHttpHost(),  $venta->codigo_factura);

            $venta->factura = $ruta['archivo'];
            $venta->save();

            if ($this->sendEmailReminder($articulos, $user->usuario, "Inscripcion a gym", $ruta['archivoEmail'])) {
                session()->forget('portal.main.gym.cliente.id');
                session()->forget('portal.main.gym.cliente.tipo_venta');
                session()->forget('portal.main.gym.cliente');
            }
            DB::commit();
            $this->addAlert('success', 'Compra finalizada con exito');
            return array(
                "data" => "Compra finalizada con exito",
                'code' => 200,
                'total' => $venta->total,
                'diferencia' => $diferencia,
                'tipo_venta' => $tipo_venta
            );
        } catch (Exception $ex) {
            DB::rollback();
            return array(
                "data" => "Existio un error, verifique sus datos",
                'code' => 500
            );
        }

        return false;
    }

    public function getCodigoReporte(){
        $numero="";
        $ventas= Venta::get();
      
        if(count($ventas)>0){
           $numero=$ventas->last()->codigo_factura;
         $numero=$numero+1;
           
        }else{
                $numero= substr(str_shuffle("0123456789"), 0, 6);  
        }
        return $numero;
    }


    public function confirmarGuardado($request) {
        $date = new \DateTime();

        if ($request->tipo_inscripcion == 1) {
            $userController = new RegisterController();
            $user = $userController->createUser($request->all());

            if ($user != null) {
                $cliente = new UsuarioCliente();
                $cliente->fecha_inscripcion = $date;
                $cliente->id_usuario = $user->id;
                $cliente->estado_cliente = "Al dia";
                $cliente->codigo_cliente = "CL" . strtoupper(substr($user->name, 0, 1)) . strtoupper(substr($user->apellido_paterno, 0, 1)) . '-' . $user->id;
                $cliente->activo = 1;
                $cliente->save();
                return $cliente;
            } else {
                return null;
            }
        } else {
            $cliente = new UsuarioCliente();
            $cliente->fecha_inscripcion = $date;
            $cliente->id_usuario = $request->user_id;
            $cliente->estado_cliente = "Al dia";
            $cliente->activo = 1;
            $cliente->save();
            return $cliente;
        }
    }

    public function deleteCliente(Request $request) {
        $cliente = UsuarioCliente::find($request->id);
        if ($cliente != null) {
            if ($cliente->activo == 1) {
                $cliente->activo = 0;
                $cliente->save();
                return 0;
            } else {
                $cliente->activo = 1;
                $cliente->save();
                return 1;
            }
        }
    }

    public function updateCliente($id) {
        $cliente = UsuarioCliente::find($id);
        $indexController = new GymController();

        $pais = $indexController->getCountryById($cliente->usuario->pais);
        $estado = $indexController->getStateById($cliente->usuario->estado);
        $view = View::make('admin::gym.cliente.updateCliente', array("cliente" => $cliente, 'pais' => $pais
                    , "estado" => $estado,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
                    "venta_aside" => $this->getCarrito()
        ));

        $this->layoutData['content'] = $view->render();
    }

    public function saveUpdateCliente(Request $request) {

        if (User::where([['clave_unica', '=', $request->clave_unica], ['id', '!=', $request->cliente_id]])->count() == 0) {

            try {
                DB::beginTransaction();
                $cliente = UsuarioCliente::find($request->cliente_id);
                $cliente->usuario->name = $request->name;
                $cliente->usuario->apellido_paterno = $request->apellido_paterno;
//            $cliente->usuario->apellido_materno = $request->apellido_materno;
                $cliente->usuario->telefono = $request->telefono;
                $cliente->usuario->telefono_celular = $request->telefono_celular;
                $cliente->usuario->estado_civil = $request->estado_civil;
                $cliente->usuario->direccion = $request->direccion;
                $cliente->usuario->email = $request->email;
                $cliente->usuario->foto = $request->flag;
                $cliente->usuario->clave_unica = $request->clave_unica;
                $cliente->usuario->save();
                $cliente->usuario->activo = ($request->has('activo')) ? 1 : 0;
                $cliente->save();
                DB::commit();
                $this->updateCliente($request->cliente_id);
            } catch (Exception $e) {
                return $this->updateCliente($request->cliente_id);
            }
        } else {
            $this->addAlert('danget', "Ya existe un usuario con esta clave");
            return $this->updateCliente($request->cliente_id);
        }
    }

    public function eraseCliente($id) {

        $usr = User::find($id);
        if ($usr != null) {
            $cliente = UsuarioCliente::where('id_usuario', '=', $usr->id)->first();
            $cliente->membresias()->detach();
            $cliente->delete();
            $usr->delete();
        } else {
            $cliente = UsuarioCliente::where('id_usuario', '=', $id)->first();
            $cliente->membresias()->delete();
            $cliente->delete();
        }

        return \redirect()->route('admin.client.list_clientes')->with(['resultSaved' =>
                    array('success' => true, 'type_alert' => 'success',
                        'message_alert' => 'Eliminado correctamente')]);
    }

    public function getAddCliente() {
        $paises = Pais::where('activo', '=', 1)->get();
        $view = View::make('admin::gym.cliente.addOnlyClient', array(
                    'cliente' => null,
                    'paises' => $paises,
                    'can_add' => Auth::action('brand.add'),
                    'can_delete' => Auth::action('bread.activeBrand'),
                    'can_edit' => Auth::action('brand.editBrand'),
                    "venta_aside" => $this->getCarrito()
        ));

        $this->layoutData['content'] = $view->render();
    }

}
