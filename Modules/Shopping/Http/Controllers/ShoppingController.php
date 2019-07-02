<?php

namespace Modules\Shopping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Helpers\ShoppingCart;
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
    
 

        public function export_cart()    
    {

               $subTotal=ShoppingCart::getSubtotal();
                $cart=\session()->get('portal.cart');
            //return view('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal]);

        $pdf = PDF::loadView('shopping::frontend.shopping.cart_list_report',['cart'=>$cart,'subTotal'=>$subTotal]);
        
        //$pdf->save(storage_path().'_filename.pdf');
      

         //return $pdf->stream('cart_products.pdf',array('Attachment'=>0));
        return $pdf->download('cart_products.pdf');
  

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
