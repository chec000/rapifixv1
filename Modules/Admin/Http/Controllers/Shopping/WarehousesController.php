<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use Modules\Admin\Entities\ACL\User;
use Modules\Admin\Entities\Country;
use Modules\Admin\Entities\CountryTranslation;
use Modules\Admin\Http\Requests\WarehousesRequest;
use Modules\Shopping\Entities\OrderEstatus;
use Modules\Shopping\Entities\OrderEstatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Language;
use Image;
use Modules\Shopping\Entities\WarehouseCountry;
use View;
use Validator;
use Auth;
use Session;
use Modules\CMS\Libraries\Builder\FormMessage;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class WarehousesController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $wh = WarehouseCountry::whereIn('shop_country_warehouses.country_id', User::userCountriesPermission())
            ->groupBy('shop_country_warehouses.warehouse')
            ->where('shop_country_warehouses.active','!=',-1)
            ->get();
        $warehouse = $this->getCountryWarehouse($wh);
        $this->layoutData['modals']  = View::make('admin::shopping.products.modals.confirm');
        $this->layoutData['content'] = View::make('admin::shopping.warehouses.list', compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $countries = $this->getArrayCountry(Auth::user()->countries);
        $this->layoutData['content'] = View::make('admin::shopping.warehouses.create', array('countries' => $countries,
            'can_add' => Auth::action('orderestatus.add'),
            'can_delete' => Auth::action('orderestatus.delete'),
            'can_activate' => Auth::action('orderestatus.activate'),
            'can_edit' => Auth::action('orderestatus.editOe'),
            'add' => 1));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, WarehousesRequest $warehousesRequest)
    {
        if(isset($request->country_id)){
            foreach ($request->country_id as $country){
                WarehouseCountry::saveInfo($country,$request->warehouse);
            }
        }else{
            return redirect()->route('admin.warehouses.create')
                ->withErrors(['country'=>trans('admin::shopping.warehouses.error.country')])
                ->withInput();
        }
        return redirect()->route('admin.warehouses.index')->with('msg', trans('admin::shopping.warehouses.error.controller-success'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $countries = $this->getArrayCountry(Auth::user()->countries);
        $wh = WarehouseCountry::where('id',$id)->first();
        $warehousesSelected = [];
        if(isset($wh)){
            $whSelected = WarehouseCountry::where('warehouse', $wh->warehouse)->where('active','!=',-1)->get();
            foreach ($whSelected as $whS){
                array_push($warehousesSelected, $whS->country_id);
            }
        }

        $this->layoutData['content'] = View::make('admin::shopping.warehouses.edit', compact('countries','wh','warehousesSelected'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,$id, WarehousesRequest $warehousesRequest)
    {
        if(isset($request->country_id)){
            $reg = WarehouseCountry::find($id);
            $wCountry = WarehouseCountry::where('warehouse', $reg->warehouse)->get();
            WarehouseCountry::where('warehouse', $reg->warehouse)->update(['active' => -1,'warehouse' => $request->warehouse]);

            foreach ($request->country_id as $country){
                $existe = 0;
                foreach ($wCountry as $wc) {
                    if($country == $wc->country_id){
                        $existe = $wc->id;
                    }
                }
                if($existe == 0){ WarehouseCountry::saveInfo($country,$request->warehouse); }
                else {
                    $reg1 = WarehouseCountry::find($existe);
                    $reg1->warehouse = $request->warehouse;
                    $reg1->active = 1;
                    $reg1->last_modifier_id = Auth::user()->id = 1;
                    $reg1->save();
                }
            }
        }else{
            return back()
                ->withErrors(['country'=>trans('admin::shopping.warehouses.error.country')])
                ->withInput();
        }
        return redirect()->route('admin.warehouses.index')->with('msg', trans('admin::shopping.warehouses.error.controller-success'));
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request)
    {
        $warehouse = WarehouseCountry::where('warehouse', $request->code)->get();
        foreach ($warehouse as $w){
            $w->last_modifier_id = Auth::user()->id;
            $w->active = -1;
            $w->save();
        }
        return redirect()->route('admin.warehouses.index')->with('msg', trans('admin::shopping.warehouses.error.controller-success'));
    }

    public function changeStatus(Request $request) {
        if ($request->has('code') && $request->has('type')) {
            $warehouse = WarehouseCountry::where('warehouse', $request->input('code'))->where('active','!=',-1)->get();

            if ($request->input('type') == 'activate') {
                foreach ($warehouse as $w){
                    $w->last_modifier_id = Auth::user()->id;
                    $w->active = 1;
                    $w->save();
                }
            } else if ($request->input('type') == 'deactivate') {
                foreach ($warehouse as $w){
                    $w->last_modifier_id = Auth::user()->id;
                    $w->active = 0;
                    $w->save();
                }
            }

            return redirect()->route('admin.warehouses.index')->with('msg', trans('admin::shopping.warehouses.error.controller-success'));
        }
    }

    /**
     * @param $warehouse
     * @return mixed
     */
    private function getCountryWarehouse($warehouse){
        foreach ($warehouse as $w)
        {
            $countries = WarehouseCountry::select('country_id')
                ->whereIn('shop_country_warehouses.country_id', User::userCountriesPermission())
                ->where('shop_country_warehouses.warehouse',$w->warehouse)
                ->where('shop_country_warehouses.active','!=',-1)
                ->get();
            $countryWarehouse = [];
            foreach ($countries as $c)
            {
                $nameCountry = CountryTranslation::where('country_id',$c->country_id)->where('locale',Session::get('adminLocale'))->first();
                if(isset($nameCountry)){ array_push($countryWarehouse, $nameCountry->name); }
            }
            $w->country = $countryWarehouse;
        }
        return $warehouse;
    }

    /**
     * @param $country
     * @return array
     */
    private function getArrayCountry($country){
        $countries = [];
        foreach ($country as $c){
            $countries[$c->id] = $c->name;
        }
        return $countries;
    }
}
