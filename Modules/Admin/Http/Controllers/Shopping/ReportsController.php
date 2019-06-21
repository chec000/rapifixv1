<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Auth;
use Modules\Admin\Entities\ACL\User;
use View;
use Session;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Shopping\Entities\Order;
use Modules\Admin\Http\Controllers\Shopping\QueryExport;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $this->layoutData['modals']  = View::make('admin::shopping.reports.modals.select');
        $this->layoutData['content'] = View::make('admin::shopping.reports.index');
    }

    public function orders()
    {
        $this->layoutData['content'] = View::make('admin::shopping.reports.orders');
    }
    public function viewOrders(){
         return view('admin::shopping.reports.orders1');
    }

    public function getOrders(Request $request)
    {
        $orders = Order::whereIn('country_id', User::userCountriesPermission())->get();
        if($request->country != 0){
            $orders = Order::where('country_id',$request->country)->get();
            if(!is_null($request->eo)){
                $orders = Order::where('country_id',$request->country)->where('distributor_number',$request->eo)->get();
            }
        } elseif (!is_null($request->eo)){
            $orders = Order::whereIn('country_id', User::userCountriesPermission())->where('distributor_number',$request->eo)->get();
        }
        $data = $this->getArrayData($orders,$request->from,$request->to);
        if (count($data) != 0){
            $this->exportFile($data);
        }
        return redirect()->back()->withInput()
            ->with('msg', trans('admin::shopping.reports.messages.errors.noInfo'))
            ->with('alert', 'alert-warning');
    }

    private function exportFile($data){
        ob_end_clean();
        ob_start();
        Excel::create('Order_report_'.date('Y_m_d-H:i:s'), function ($excel) use ($data) {
            $excel->sheet('Order', function ($sheet) use ($data) {
                $sheet->with($data, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    private function getArrayData($data,$from,$to){
        $array = array();
        foreach ($data as $result) {
            $newRow['Id'] = $result->id;
            $newRow['Country'] = $result->country->name;
            $newRow['Eo'] = $result->distributor_number;
            $newRow['Order status'] = $result->estatus->name;
            $newRow['Order number'] = $result->order_number;
            $newRow['Points'] = $result->points;
            $newRow['Total taxes'] = $result->total_taxes;
            $newRow['shipping company'] = $result->shipping_company;
            $newRow['Guide number'] = $result->guide_number;
            $newRow['Corbiz order number'] = $result->corbiz_order_number;
            $newRow['Bank'] = $result->bank->name;
            $newRow['Bank transaction'] = $result->bank_transaction;
            $newRow['Bank status'] = $result->bank_status;
            $newRow['Bank authorization'] = $result->bank_authorization;
            $newRow['Card type'] = $result->card_type;
            $newRow['Payment type'] = $result->payment_type;
            $newRow['Payment brand'] = $result->payment_brand;
            $newRow['Corbiz payment key'] = $result->corbiz_payment_key;
            $newRow['Shop type'] = $result->shop_type;
            $newRow['Corbiz transaction'] = $result->corbiz_transaction;
            $newRow['Error corbiz'] = $result->error_corbiz;
            $newRow['Error user'] = $result->error_user;
            $newRow['Warehouse'] = $result->warehouse->warehouse;
            $newRow['Management'] = $result->management;
            $newRow['Attempts'] = $result->attempts;
            $newRow['Change period'] = $result->change_period;
            $newRow['Contract path'] = $result->contract_path;
            $newRow['Mobile'] = $result->is_mobile;
            $newRow['Created'] = $result->created_at;
            $dateOrder = $result->created_at->format('Y-m-d');

            if(is_null($from) && is_null($to)){
                array_push($array, $newRow);
            } elseif (!is_null($from) && !is_null($to)){
                if(strtotime($dateOrder) >= strtotime($from) && strtotime($dateOrder) <= strtotime($to)){
                    array_push($array, $newRow);
                }
            } elseif (!is_null($from) && is_null($to)){
                if(strtotime($dateOrder) >= strtotime($from)){
                    array_push($array, $newRow);
                }
            } elseif (is_null($from) && !is_null($to)){
                if(strtotime($dateOrder) <= strtotime($to)){
                    array_push($array, $newRow);
                }
            }
        };
        return $array;
    }
}
