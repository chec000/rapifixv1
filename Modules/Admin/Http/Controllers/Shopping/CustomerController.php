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
class CustomerController extends Controller {



    public function showCustomers() {

        $dt = Carbon::now();


        $customers = Customer::wherein('country_id',User::userCountriesPermission())
                        ->where('created_at','>=',$dt->subMonths(6))
                        ->orderBy('created_at', 'asc')
                         ->get();

                    $this->layoutData['content'] = View::make('admin::shopping.customers.list', array('customers' => $customers,
                    'can_delete' => Auth::action('customers.active'),
                    'can_edit' => Auth::action('customers.edit'),
        ));


    }

     public function getCustomersDetail($id = 0){


        $customer = Customer::find($id);

        if ($customer != null) {


            $documents = $customer->customerDocument;




             $this->layoutData['content'] = View::make('admin::shopping.customers.detail', array(
                    'customer' => $customer,
                    'documents'       => $documents,
                ));
        } else {
            return redirect()->route('admin.customers.list');
        }

    }


}
