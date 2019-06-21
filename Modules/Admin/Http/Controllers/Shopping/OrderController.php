<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers\Shopping;



use Carbon\Carbon;
use Mockery\Exception;
use Modules\Admin\Entities\Country;
use Modules\Shopping\Entities\Customer;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\OrderEstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\Language;
use Image;
use Modules\Shopping\Entities\Product;
use View;
use Validator;
use Auth;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;


/**
 * Description of OrderEstatusController
 *
 * @author Alan
 */
class OrderController extends Controller {

    public function indexOrder($message = "", $validacion = "") {



        $countries = Country::selectArrayActive();
        $languagesList = Language::where('active', '=', 1)->get();


        $this->layoutData['content'] = View::make('admin::shopping.orderestatus.forms.add', array('countries' => $countries,
                    'languages' => $languagesList,
                    'msg' => $message,
                    'can_add' => Auth::action('orderestatus.add'),
                    'can_delete' => Auth::action('orderestatus.delete'),
                    'can_activate' => Auth::action('orderestatus.activate'),
                    'can_edit' => Auth::action('orderestatus.editOe'),
                    'validacion' => $validacion,
                    'add' => 1));
    }

    public function showOrders() {

        $dt = Carbon::now();

        $orders = Order::wherein('country_id',User::userCountriesPermission())
                        ->where('created_at','>=',$dt->subMonths(6))
                        ->orderBy('created_at', 'asc')
                         ->get();



        $this->layoutData['content'] = View::make('admin::shopping.orders.list', array('orders' => $orders,

                    'can_delete' => Auth::action('orders.active'),
                    'can_edit' => Auth::action('orders.edit'),
        ));
    }


     public function activeOrders(Request $request) {

        $order = Order::find($request->order_id);

        if ($order != null) {

            //obtener el id des status correcto por su key
            $estatus = OrderEstatus::where('key_estatus','=','PAYMENT_SUCCESSFUL')->first();


            try{
                $order->order_estatus_id = !empty($estatus->id) ? $estatus->id : 1;
                $order->last_modifier_id = Auth::user()->id;
                $order->save();
                $response = array(
                    'status' => true,
                    'message' => trans('admin::shopping.orders.index.activated'),
                );
            }catch (\Exception $e){
                $response = array(
                    'status' => false,
                    'message' => trans('admin::shopping.orders.index.notactivated'),
                );
            }


            return $response;
        } else {
            return "";
        }
    }

    public function removeProduct(Request $request) {

        $orderitem = OrderDetail::where(['order_id' => $request->order_id,'id' => $request->item])->first();


        if ($orderitem != null) {

            if ($orderitem->active == 1) {
                $orderitem->active = -1;
                $orderitem->save();


                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.disabled'),
                );
            }
            else {
                $orderitem->active = 1;
                $orderitem->save();


                $response = array(
                    'status' => true,
                    'message' => trans('admin::menu.active')
                );
            }
            return $response;



        } else {
            $response = array(
                'status' => false,
                'message' => trans('admin::menu.active')
            );
            return "";
        }
    }

    public function getOrdersDetail($idorder = 0){

        $order = Order::find($idorder);

        if ($order != null) {

            $orderdetail = $order->orderDetail;
            $shippingAddress = $order->shippingAddress;
            $documents = $order->orderDocument;
            $products = $order->products;
            $orderhistory = $order->orderstatushistory;


             $this->layoutData['content'] = View::make('admin::shopping.orders.detail', array(
                    'order' => $order,
                    'orderdetail' => $orderdetail,
                    'shipping_address' => $shippingAddress,
                    'products'  => $products,
                    'documents'       => $documents,
                    'history' => $orderhistory,
                    'can_delete' => Auth::action('orders.active'),
                    'can_edit' => Auth::action('orders.edit'),
                ));
        } else {
            return redirect()->route('admin.orders.list');
        }

    }





    public function saveNew(Request $request){
        //dd($request->products);
        try{
            DB::beginTransaction();
                $json = json_decode($request->products);

                foreach ($json as $p){
                    $detail = new OrderDetail();
                    $detail->order_id = $request->id;
                    $detail->product_id = $p->product_id;
                    $detail->promo_prod_id = 0;
                    $detail->quantity = $p->qty;
                    $detail->final_price = $p->price;
                    $detail->points = $p->points;
                    $detail->active = 2;
                    $detail->is_promo = 0;
                    $detail->last_modifier_id = Auth::user()->id;
                    $detail->save();
                }
                //encontramos la orden para modificar el last modifier y cambiamos el estatus para que intene el reproceso
                $estatus = OrderEstatus::where('key_estatus','=','PAYMENT_SUCCESSFUL')->first();

                $orden = Order::find($request->id);
                $orden->last_modifier_id = Auth::user()->id;
                $orden->order_estatus_id = $estatus->id;
                $orden->save();

            DB::commit();

            return response()->json(['success' => true,'message' => '']);

        }catch (Exception $e){
            DB::rollback();
            $message = trans('admin::shopping.orders.detail.failed');
            return response()->json(['success' => false,'message' => $message]);
        }


    }





}
