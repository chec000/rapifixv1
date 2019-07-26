<?php

namespace Modules\Shopping\Http\Controllers;


use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller;
use App\Helpers\ShoppingCart;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use PDF;

class ShoppingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    //public  $numero="";
    public function index()
    {
        return view('shopping::index');
    }
    


        public function export_cart($request=null,$data,$numeroOrden)    
    {

        
         $subTotal=ShoppingCart::getSubtotal();    
         $cart=\session()->get('portal.cart');           
        $pdf = PDF::loadView('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal,"data"=>$data,'numero'=>$numeroOrden]);
        $directorio = public_path() . '/uploads/facturas';
        $date = new \DateTime();
        $name_report="orden".time();
         $path=$request->getSchemeAndHttpHost();
      if (file_exists($directorio)) {
          
            file_put_contents($directorio . '/' .  $name_report.".pdf", $pdf->stream());
      }else{
           mkdir($directorio, 7777, true);
            file_put_contents($directorio . '/' . $name_report.".pdf", $pdf->stream());
      }
      
          $archivo = $path . '/uploads/facturas/' .$name_report . '.pdf';
        $archivoEmail = $directorio . "/" .$name_report. ".pdf";
        
       // $pdf->save(storage_path().'_filename.pdf');
    
   return  array("archivo" => $archivo, "archivoEmail" => $archivoEmail,'name'=>$name_report);

  }


    public function sendEmailShopping(Request $request) {
                
      
        try {                           
              $r=$request->all();
        if(\Session::has('portal.cart' ) && \Session::get('portal.cart.items') > 0) {
            $date=getdate();
            $numeroOrden=  "P1-".$date['year'].'-'.time();      
            //$this->numero=$numeroOrden;
          
          $usuario='rapifixjarabacoa@gmail.com';
          $asunto='Presupuesto';
         $user=$r['nombre'].'  '.$r['apellidos'];
           $file= $this->export_cart($request,$r,$numeroOrden) ;
        
            $subTotal=ShoppingCart::getSubtotal();
            $cart=\session()->get('portal.cart');    
            $items=\Session::get('portal.cart.items') ;
            $this->saveOrder( $items,$numeroOrden,$r);
     //  $pdf = PDF::loadView('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal,'data'=>$r]);        

         Mail::send('shopping::frontend.shopping.email.budget',['cliente' => $user], function ($m) use ($usuario, $asunto,$r,$file){
         
            $m->to($usuario,'rapifix.com')->subject('Presupuesto de compra');
            //$m->attachData($pdf->output(),'prusupuesto.pdf',['mime'=>'application/pdf']);
         $m->attach($file['archivoEmail'], array(
                    'as' => $file['name'],
                    'mime' => 'application/pdf')
                );
               
         });   
                        session()->forget('portal.cart');
      return  $file;
        
       }
        
        
            
        } catch (Exception $ex) {
            return $ex->getText;
        }
                    
        return json_encode(false);
                }
       


    private function saveOrder($items,$numeroOrden,$data)
    {
            
         $order= new Order();
        $order->country_id=\Session::get('portal.main.country_id');      
        $order->order_estatus_id=1;
        $order->order_number=$numeroOrden;
        $order->points=\Session::get('portal.cart.points');
        $order->total_taxes=0;
        $order->total=\Session::get('portal.cart.subtotal');
        $order->discount=0;        
        $order->guide_number=$numeroOrden;
        $order->save();
    
        foreach ($items as $i){          
            $orderDetail = new OrderDetail();
            $orderDetail->order_id=$order->id;
            $orderDetail->product_id=$i['id'];
            $orderDetail->quantity=$i['quantity'];
            $orderDetail->final_price=$i['price'];
            $orderDetail->points=$i['points'];
            $orderDetail->active=1;
            $orderDetail->country_group_id=\Session::get('portal.main.country_id');
            $orderDetail->save();
            
        }
       $shipingAddres= new  ShippingAddress();
       $shipingAddres->order_id=$order->id;
        $shipingAddres->name=$data['nombre'];
       $shipingAddres->lastname=$data['apellidos'];   
       $shipingAddres->address=$data['direccion'];
       $shipingAddres->cellphone=$data['celular'];
       $shipingAddres->telephone=$data['telefono'];
       $shipingAddres->zip_code="";
       $shipingAddres->city=$data['ciudad'];
       $shipingAddres->state=$data['ciudad'];
       $shipingAddres->country="Republica Dominicana";
       $shipingAddres->email=$data['email'];
       $shipingAddres->save();
         
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

 
}
