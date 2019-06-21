<?php

namespace Modules\Admin\Http\Controllers\Shopping;

use App\Helpers\RestWrapper;
use Modules\Admin\Entities\Country;
use View;
use Auth;
use Image;
use Session;
use Validator;
use Illuminate\Http\Request;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\ProductRestriction;
use Modules\Admin\Http\Requests\ProdRestrictionRequest;
use Modules\Admin\Http\Controllers\AdminController as Controller;

class ProductRestrictionsController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // Info para select de paises
        $countryUser = $this->getArrayCountry(Auth::user()->countries);
        // Se elige el primer pais que tiene el usuario asignado para cagar informacion
        $id = key($countryUser);
        // Info para select de productos
        $prodCountry = $this->getArrayProduct(CountryProduct::whereHas('product', function ($q) {
            $q->where('is_kit', 0);
        })->where('country_id',$id)->where('active',1)->get());
        // Info para select de estados
        $statesCountry = [];

        $country  = Country::find($id);
        $response = $this->getStatesFromCorbiz($country->webservice, $country->corbiz_key, Session::get('adminLocaleCorbiz'));

        // Info para listado de productos restringidos
        $productRestrictions = CountryProduct::has('productsRestriction')->with('productsRestriction')->where('country_id',$id)->get();

        $this->layoutData['content'] = View::make('admin::shopping.productrestrictions.productrestriction',
            compact('prodCountry','statesCountry','productRestrictions','id','countryUser', 'response'));
    }

    public function show($id)
    {
        // Info para select de paises
        $countryUser = $this->getArrayCountry(Auth::user()->countries);
        // Info para select de productos
        $prodCountry = $this->getArrayProduct(CountryProduct::where('country_id',$id)->where('active',1)->get());

        $country  = Country::find($id);
        $response = $this->getStatesFromCorbiz($country->webservice, $country->corbiz_key, Session::get('adminLocaleCorbiz'));

        // Info para listado de productos restringidos
        $productRestrictions = CountryProduct::has('productsRestriction')->with('productsRestriction')->where('country_id',$id)->get();

        $this->layoutData['content'] = View::make('admin::shopping.productrestrictions.productrestriction',
            compact('prodCountry','statesCountry','productRestrictions','id','countryUser','response'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, ProdRestrictionRequest $prodRestrictionRequest)
    {

        ProductRestriction::updateOrCreate(
            [ 'country_product_id' => $request->product_id, 'state' => $request->code_state],
            [ 'active' => 1, 'last_modifier_id' => Auth::user()->id ]
        );
        return redirect()->route('admin.productRestrictions.show', $id)
            ->with('msg', trans('admin::shopping.warehouses.error.controller-success'))
            ->with('code', $request->code_state);
    }

    /**
     * Remove the specified resource from storage.
     * @return boolean
     */
    public function destroy(Request $request, $id)
    {
        $prodRestriction = ProductRestriction::find($id);
        $prodRestriction->last_modifier_id = Auth::user()->id;
        $prodRestriction->active = -1;
        $prodRestriction->save();

        return redirect()->route('admin.productRestrictions.show', $request->idCountry)
            ->with('msg', trans('admin::shopping.warehouses.error.controller-success'))
            ->with('code', $request->code);
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

    private function getArrayProduct($country){
        $countries = [];
        foreach ($country as $c){
            if ($c->product->delete == 0 && $c->product->active == 1) {
                $countries[$c->id] = $c->product->sku. " - " .$c->name;
            }
        }
        return $countries;
    }

    /**
     * getStatesFromCorbiz
     * Realiza la petición del método getState a corbiz y se formatea su respuesta
     *
     * @param $ws           URL del webservice
     * @param $countryKey   Clave del país de corbiz
     * @param $lang         Clave del idioma de corbiz
     * @return array        Respuesta de la petición
     */
    private function getStatesFromCorbiz($ws, $countryKey, $lang) {
        $response    = ['status' => false, 'data' => [], 'messages' => []];
        $restWrapper = new RestWrapper("{$ws}getState?CountryKey={$countryKey}&Lang={$lang}");
        $responseWS  = $restWrapper->call('GET', [], 'json', ['http_errors' => false]);

        if ($responseWS['success'] == true && isset($responseWS['responseWS']['response']['State']['dsState']['ttState'])) {
            $response['status'] = true;
            foreach ($responseWS['responseWS']['response']['State']['dsState']['ttState'] as $state) {
                $response['data'][trim($state['idState'])] = trim($state['stateDescr']);
            }

        } else {
            if (isset($responseWS['responseWS']['response']['Error']['dsError']['ttError'])) {
                $response['messages'] = [
                    $responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messUser'],
                    '<i>'.$responseWS['responseWS']['response']['Error']['dsError']['ttError'][0]['messTech'].'</i>'
                ];
            } else {
                if (isset($responseWS['message'])) {
                    $response['messages'] = [$responseWS['message']];
                } else {
                    $response['messages'] = [trans('cms::cedis.errors.404')];
                }
            }
        }

        return $response;
    }
}
