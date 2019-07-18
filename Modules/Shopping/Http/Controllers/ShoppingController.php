<?php

namespace Modules\Shopping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Helpers\ShoppingCart;
use Modules/Shopping/Entities/Order;
use Modules/Shopping/Entities/OrderDetail;
use Illuminate\Support\Facades\Mail;
use PDF;
class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('shopping::index');
    }
    
 

        public function export_cart($request)    
    {


            $subTotal=ShoppingCart::getSubtotal();
    
                $cart=\session()->get('portal.cart');
        return view('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal,'data'=>$request]);

            $usuario="Sergio ";
     return view('shopping::frontend.shopping.email.budget',array('cliente'=>$usuario));

             
        $pdf = PDF::loadView('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal]);
        
        //$pdf->save(storage_path().'_filename.pdf');
      

         //return $pdf->stream('cart_products.pdf',array('Attachment'=>0));
        return $pdf->download('cart_products.pdf');
  

  }


    public function sendEmailShopping(Request $request) {
            
        try {                
            $r=$request->all();

        $usuario='rapifixjarabacoa@gmail.com';
        $asunto='Presupuesto';
        $user=$r['nombre'].' '.$r['apellidos'];
        
         Mail::send('shopping::frontend.shopping.email.budget',['cliente' => $user], function ($m) use ($usuario, $asunto,$r){

            $subTotal=ShoppingCart::getSubtotal();
                $cart=\session()->get('portal.cart');
    
            $pdf = PDF::loadView('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal,'data'=>$r]);
        
                $m->to($usuario,'rapifix.com')->subject('Presupuesto de compra');

        //$message->from('from@gmail.com','The Sender');

        $m->attachData($pdf->output(),'prusupuesto.pdf');

    });

            return redirect()->route('cart.list');

            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return $ex->getText;
        }
    }

    private function saveOrder()
    {
        $order= new Order();
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('shopping::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('shopping::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('shopping::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    private function getPdf()
    {
    $ruta = $this->generateReport($articulos, $user->usuario, $request->getSchemeAndHttpHost(),  $venta->codigo_factura);
        
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
}
