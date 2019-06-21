<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 29/08/2018
 * Time: 12:15 PM
 */

namespace Modules\Shopping\Http\Controllers;


use App\Helpers\SessionHdl;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Shopping\Entities\Promo;

class PromotionController extends Controller
{

    public function initPromotions($headPromotions, $detPromotions, $whereSaveSession = "checkout"){
        //dd($headPromotions,$detPromotions);
        //dd(Session::get("portal.{$whereSaveSession}.".SessionHdl::getCorbizCountryKey().".promotionsSent"), $whereSaveSession,SessionHdl::getCorbizCountryKey());
        Session::forget('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotions');

        $promotions = array();
        $transPromotions = array();
        $promotionsSent = array();

        if(Session::get('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent') != null){
            $promotionsSent = Session::get('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent');
            //dd($promotionsSent);
        }
        /*$promotionsSent = Session::has('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent') ?
            Session::get('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent') : array();*/

        //Armado de cabeceras de promociones
        foreach($headPromotions as $hp) {
            //Se comprueba si la promocion ya ha sido enviada al usuario con anterioridad
            if (!$this->existPromotionsSent(trim($hp['clv_promo']), $promotionsSent)) {
                //Se obtienen translates para traducciones de promociones desde BD
                $transPromotions[$hp['clv_promo']] = Promo::where('clv_promo', '=', $hp['clv_promo'])->first();
                //Modificando nombre de promocion en caso de existir, y guardado de cabecera en arreglo de promociones
                if (isset($transPromotions[$hp['clv_promo']]) && $transPromotions[$hp['clv_promo']] != null
                    && !empty($transPromotions[$hp['clv_promo']])) {

                    $transPromotions[$hp['clv_promo']]->promoprods = $transPromotions[$hp['clv_promo']]->promoprods->groupBy('clv_producto');
                    //Si existe traduccion la sobrescribe
                    if ($transPromotions[$hp['clv_promo']]->name_header != null && $transPromotions[$hp['clv_promo']]->name_header != "") {
                        $hp['descripcion'] = trim($transPromotions[$hp['clv_promo']]->name_header);
                    }
                    //dd($transPromotions[$hp['clv_promo']]->name_header, $transPromotions[$hp['clv_promo']]->promoprods[9607040][0]->name);
                }
                $newHead = array(
                    "key_promo" => $hp["clv_promo"],
                    "description" => $hp["descripcion"],
                    "quantity" => $hp["cantidad"],
                    "required" => $hp["obliga"],
                    "type" => $hp["tipo"]
                );
                $promotions['head'][trim($hp['tipo'])][trim($hp['clv_promo'])] = $newHead;


                $promotionsSent[]= trim($hp["clv_promo"]);
                //dd($itemsPromoSession,$itemsPromoValidation, $newItemsPromo);
            }
        }
        //Session::put('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent', $promotionsSent);
        //dd(Session::get("portal.{$whereSaveSession}.".SessionHdl::getCorbizCountryKey().".promotionsSent"));

        //dd($detPromotions, $transPromotions, $transPromotions["295-BR"]->promoprods);
        //Armado de contenido de promociones
        foreach($detPromotions as $dp){
            if (isset($promotions['head'][trim($dp['tipo_linea'])][trim($dp['clv_promo'])])) {
                //Modificando nombre de productos de promocion en caso de existir, y guardado en arreglo de Items de promociones
                if (isset($transPromotions[$dp['clv_promo']]) && $transPromotions[$dp['clv_promo']] != null
                    && !empty($transPromotions[$dp['clv_promo']])) {
                    //Si existe traduccion la sobrescribe
                    if (isset($transPromotions[$dp['clv_promo']]->promoprods[$dp['clv_arti']])
                        && $transPromotions[$dp['clv_promo']]->promoprods[$dp['clv_arti']][0]->name != null
                        && $transPromotions[$dp['clv_promo']]->promoprods[$dp['clv_arti']][0]->name != "") {
                        $dp['descripcion'] = $transPromotions[$dp['clv_promo']]->promoprods[$dp['clv_arti']][0]->name;
                    }
                }
                //Formateado de precio
                $dp['precio_format'] = currency_format($dp['precio'], SessionHdl::getCurrencyKey());

                $newDP = array(
                    "key_promo" => $dp["clv_promo"],
                    "line" => $dp["linea"],
                    "key_item" => $dp["clv_arti"],
                    "description" => $dp["descripcion"],
                    "quantity" => $dp["cantidad"],
                    "price" => $dp["precio_format"],
                    "price_no_format" => $dp["precio"],
                    "type_line" => $dp["tipo_linea"],
                    "udf1" => $dp["udf1"],
                    "udef2" => $dp["udf2"]);

                $promotions['items'][trim($dp['tipo_linea'])][trim($dp['clv_promo'])][trim($dp['linea'])][trim($dp['clv_arti'])] = $newDP;
            }
        }

        if(!empty($promotions)) {
            //dd($promotions);
            //Guardado en session de arreglo de promociones y retorna true
            Session::put("portal.{$whereSaveSession}.".SessionHdl::getCorbizCountryKey().".promotions", $promotions);
            //Session::put('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.promotions', $promotions);
            $this->addPromotionsSent($whereSaveSession);
            return true;
        }

        return false;
    }

    //promotionsSent Valida que las promociones obtenidas no hayan sido enviadas al usuario en el ciclo actual de cotizacion
    public function existPromotionsSent($clvPromotion,$promotionsSent) {

        /*$promotionsSent = Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent') != null ?
            Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent') : array();*/
        $existPromotion = false;
        foreach($promotionsSent as $ps){
            if($ps === $clvPromotion) {
                $existPromotion = true;
                break;
            }
        }

        //Session::put("portal.{$process}.".SessionHdl::getCorbizCountryKey().".promotionsSentArray.{$clvPromotion}", isset($promotionsSent[$clvPromotion]) );

        return $existPromotion;


    }

    public function validateQuantityPromos(Request $request){

        $process = $request->has('process') && $request->get('process') != "" ? $request->get('process') : "checkout";
        //dd($request->all(), Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions'));
        //Se limpia de sesion los articulos de promocion temporales para cotizacion
        Session::forget('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate');
        // Se inicializan los result para las distintas promociones
        $response = array('success' => false, 'successA' => true, 'successB' => true, 'successC' => true, 'messages' => array());

        $arrayQtyPromos = array();
        $arraySelectPromos = array();
        if ($request->ajax()) {
            if($request->get('qtyPromo') != null) {
                $arrayQtyPromos = $request->get('qtyPromo');
                //dd($arrayQtyPromos['A']);
            }
            /*if($request->get('selectPromo') != null) {
                //$arraySelectPromos = $request->get('selectPromo');
            }*/

            $dataQtyPromos['A'] = isset($arrayQtyPromos['A']) ? $arrayQtyPromos['A'] : array();
            //$dataSelectPromos['A'] = isset($arraySelectPromos['A']) ? $arraySelectPromos['A'] : array();
            $resultA = $this->validatePromotionA($dataQtyPromos['A'], $process);
            if(!$resultA['success']){
                //dd($response, $resultA);
                $response['successA'] = false;
                $response['messages'] = array_merge($response['messages'], $resultA['messages']);
            }

            $dataQtyPromos['B'] = isset($arrayQtyPromos['B']) ? $arrayQtyPromos['B'] : array();
            //$dataSelectPromos['B'] = isset($arraySelectPromos['B']) ? $arraySelectPromos['B'] : array();
            $resultB = $this->validatePromotionB($dataQtyPromos['B'], $process);
            if(!$resultB['success']){
                $response['successB'] = false;
                $response['messages'] = array_merge($response['messages'], $resultB['messages']);
                //$response['messages']['B'] = $resultB['messages'];
            }

            if(isset($arrayQtyPromos['C']) ){
                $resultC = $this->validatePromotionC($arrayQtyPromos['C'], $process);
                if(!$resultC['success']){
                    $response['successC'] = false;
                    $response['messages'] = array_merge($response['messages'], $resultC['messages']);
                    //$response['messages'] = $resultC['messages'];
                }
            }

            //dd($response);
            //En caso de que todas las promociones hayan resultado exitosas
            if($response['successA'] && $response['successB'] && $response['successC']){
                $response['success'] = true;

                $itemsPromoSession = Session::has('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTemp') ?
                    Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTemp') : array();
                $itemsPromoValidation = Session::has('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') ?
                    Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') : array();

                $newItemsPromo = array_merge($itemsPromoSession, $itemsPromoValidation);
                //dd($itemsPromoSession,$itemsPromoValidation, $newItemsPromo);
                Session::put('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTemp', $newItemsPromo);
                Session::forget('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate');

                $response['prmotionsSent'] = $this->addPromotionsSent($process);

            } else {
                Session::forget('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate');
            }
        }
        return response()->json($response);
    }

    private function validatePromotionA($qtyPromoA, $process = "checkout"){

        $headPromos = Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions.head.A');
        //$itemsPromos = session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.promotions.items.A');

        $result['success'] = false; //result final de la funcion
        $resultBefore = true; //result auxiliar en caso de que exista mas de una promocion, para comprobar que todos las promociones sean exitosas

        if($headPromos != null){
            foreach($headPromos as $indexHead => $promo){

                $resultValidatePromoA = $this->getValidateQuantityPromo($qtyPromoA[$indexHead], $promo['quantity']);
                //dd($headPromos,$qtyPromoA[$indexHead], $promo['quantity'], $resultValidatePromoA);
                $result = array('success' => false, 'max_allowed' => false, 'line' => false, 'quantity' => false, 'messages' => array());

                //Se comprueba si la promocion es obligatoria
                if($promo['required']){
                    //Se comprueba si existe un paquete seleccionado y  si el paquete seleccionado tiene una cantidad mayor que cero
                    if($resultValidatePromoA['quantity'] && $resultValidatePromoA['quantity'] > 0){
                        //Se comprueba si la quantity es menor que la maxima permitida
                        if($resultValidatePromoA['max_allowed']) {
                           // dd($resultBefore,$resultValidatePromoA, $promo);
                            if($resultBefore) {
                                $result['success'] = true;
                                //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, linea, cantidad.
                                $this->addItemPromoTempByLine("A", $indexHead, $resultValidatePromoA['line'], $resultValidatePromoA['quantity'], $process);
                            }
                        } else {
                            //Mensaje para cantidad maxima excedida
                            $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty',['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity'] ]);
                            $resultBefore = false;
                        }
                    } else {
                        //Mensaje para cantidad promocion no seleccionada/igual a cero
                        $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_obliga',['name_promo' => $promo['description']]);
                        $resultBefore = false;
                    }
                } else {
                    //Validaciones de promocion no obligatoria

                    //Se comprueba si existe un paquete seleccionado
                    //Se comprueba si el paquete seleccionado tiene una cantidad mayor que cero
                    if($resultValidatePromoA['quantity'] && $resultValidatePromoA['quantity'] > 0){
                        //Se comprueba si la quantity es menor que la maxima permitida
                        if($resultValidatePromoA['max_allowed']) {
                            $result['max_allowed'] = true;
                            //dd($resultBefore);
                            if($resultBefore) {
                                $result['success'] = true;
                                //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, linea, cantidad.
                                $this->addItemPromoTempByLine("A", $indexHead,  $resultValidatePromoA['line'], (int)$resultValidatePromoA['quantity'], $process);
                            }
                        } else {
                            //Mensaje para cantidad maxima excedida
                            $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty',['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity'] ]);
                            $resultBefore = false;
                        }
                    } else {

                        $result['success'] = true;

                        //Si el usuario eligio cantidad pero no selecciono promocion
                        /*if(isset($qtyPromoA[$indexHead])) {
                            $qtyZero = true;
                            foreach($qtyPromoA[$indexHead] as $lineQty){
                                if((int)$lineQty > 0){
                                    $qtyZero = false;
                                    $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_obliga',['name_promo' => $promo['description']]);
                                    $resultBefore = false;
                                    break;
                                }
                            }
                            if($qtyZero && $resultBefore){
                                $result['success'] = true;
                            }
                        } elseif($resultBefore) {
                            $result['success'] = true;
                        }*/
                        //$result['messages'][$indexHead][] = trans('shopping::checkout.promotions.msg_promo_obliga',['name_promo' => $promo['description']]);
                    }
                }
            }
        } else {
            $result['success'] = true;
        }

        //dd($resultValidatePromoA,$result);
        return $result;
    }

    private function validatePromotionB($qtyPromoB, $process = "checkout"){
        $headPromos = session()->get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions.head.B');
        //$itemsPromos = session()->get('portal.checkout.'.SessionHdl::getCorbizCountryKey().'.promotions.items.A');


        $result['success'] = false; //result final de la funcion
        $resultBefore = true; //result auxiliar en caso de que exista mas de una promocion, para comprobar que todos las promociones sean exitosas
        if($headPromos != null) {
            foreach ($headPromos as $indexHead => $promo) {

                $resultValidatePromoB = $this->getValidateQuantityPromo($qtyPromoB[$indexHead], $promo['quantity']);

                //Se comprueba si la promocion es obligatoria
                if ($promo['required']) {
                    //Se comprueba si existe un paquete seleccionado
                    //Se comprueba si el paquete seleccionado tiene una cantidad mayor que cero
                    if ($resultValidatePromoB['quantity'] && $resultValidatePromoB['quantity'] > 0) {
                        //Se comprueba si la cantidad es menor que la maxima permitida
                        if ($resultValidatePromoB['max_allowed']) {
                            if ($resultBefore) {
                                $result['success'] = true;
                                //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, linea, cantidad.
                                $this->addItemPromoTempByLine("B", $indexHead, $resultValidatePromoB['line'], (int)$resultValidatePromoB['quantity'], $process);
                            }
                        } else {
                            //Mensaje para cantidad maxima excedida
                            $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty', ['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity']]);
                            $resultBefore = false;
                        }
                    } else {
                        //Mensaje para cantidad promocion no seleccionada/igual a cero
                        $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_obliga', ['name_promo' => $promo['description']]);
                        $resultBefore = false;
                    }
                } else {
                    //Validaciones de promocion no obligatoria

                    //Se comprueba si existe un paquete seleccionado
                    //Se comprueba si el paquete seleccionado tiene una cantidad mayor que cero
                    if ($resultValidatePromoB['quantity'] && $resultValidatePromoB['quantity'] > 0) {
                        //Se comprueba si la cantidad es menor que la maxima permitida
                        if ($resultValidatePromoB['max_allowed']) {
                            if ($resultBefore) {
                                $result['success'] = true;
                                //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, linea, cantidad.
                                $this->addItemPromoTempByLine("B", $indexHead, $$resultValidatePromoB['line'], (int)$resultValidatePromoB['quantity'], $process);
                            }
                        } else {
                            //Mensaje para cantidad maxima excedida
                            $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty', ['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity']]);
                            $resultBefore = false;
                        }$resultBefore = false;

                    } else {
                        //Mensaje para cantidad promocion no seleccionada/igual a cero
                        if ($resultBefore) {
                            $result['success'] = true;
                        }
                        //$result['messages'][$indexHead][] = trans('shopping::checkout.promotions.msg_promo_obliga',['name_promo' => $promo['description']]);
                    }
                }
            }
        }else{
            $result['success'] = true;
        }
        return $result;
    }

    private function validatePromotionC($qtyPromoC, $process = "checkout"){
        $headPromos = session()->get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions.head.C');

        $result['success'] = false; //result final de la funcion
        $resultBefore = true; //result auxiliar en caso de que exista mas de una promocion, para comprobar que todos las promociones sean exitosas

        $qtyUserIntro = array();

        foreach($qtyPromoC as $clvPromo => $qpc){
            foreach($qpc as $qt){
                if(!isset($qtyUserIntro[$clvPromo])){
                    $qtyUserIntro[$clvPromo] = 0;
                }

                $qtyUserIntro[$clvPromo] = $qtyUserIntro[$clvPromo] + (int)$qt;

            }
        }

        foreach($headPromos as $indexHead => $promo){
            //dd($qtyPromoC, $qtyUserIntro, $promo['quantity']);
            //Se comprueba si la promocion es requiredtoria
            if($promo['required']){

                    //Se comprueba si los productos seleccionados tienen una cantidad mayor que cero
                    if($qtyUserIntro[$indexHead] > 0){
                        //Se comprueba si la cantidad es menor que la maxima permitida
                        if($qtyUserIntro[$indexHead] <= (int)$promo['quantity']) {
                            if($resultBefore) {
                                $result['success'] = true;
                                //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, cantidad.
                                $this->addItemPromoTempByClvArti("C", $indexHead ,$qtyPromoC[$indexHead], $process);
                            }
                        } else {
                            //Mensaje para cantidad maxima excedida
                            $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty',['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity'] ]);
                            $resultBefore = false;
                        }
                    } else {
                        //Mensaje para cantidad promocion no seleccionada/igual a cero
                        $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_obliga', ['name_promo' => $promo['description']]);
                        $resultBefore = false;
                    }
            } else {
                //Validaciones de promocion no obligatoria

                if($qtyUserIntro[$indexHead] > 0){
                    //Se comprueba si la cantidad es menor que la maxima permitida
                    if($qtyUserIntro[$indexHead] <= $promo['quantity']) {
                        if($resultBefore) {
                            $result['success'] = true;
                            //Parametros de envio para guardar en items temporales: Tipo promocion, clave promocion, cantidad.
                            $this->addItemPromoTempByClvArti("C", $indexHead ,$qtyPromoC[$indexHead], $process);
                        }
                    } else {
                        //Mensaje para cantidad maxima excedida
                        $result['messages'][$indexHead] = trans('shopping::checkout.promotions.msg_promo_qty',['name_promo' => $promo['description'], 'qty_promo' => $promo['quantity'] ]);
                        $resultBefore = false;
                    }
                } else {
                    $result['success'] = true;
                }
            }
        }

        return $result;
    }

    private function addItemPromoTempByLine($typePromo, $clvPromo, $linePromo, $qtyItems, $process = "checkout"){

        //Se obtienen de sesion los articulos de promocion originales
        $itemsPromos = session()->get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions.items.'.$typePromo.'.'.$clvPromo);

        //Se obtienen de sesion los articulos de promocion temporales para cotizacion
        $arrayItems = Session::has('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') ?
            Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') : array();
        //$arrayItems = array();
        $count = 0;
        foreach($itemsPromos as $itmLine){
            foreach($itmLine as $index => $isc){
                if($linePromo ==  $isc['line']) {
                    $arrayItems[$clvPromo][$isc['key_item']] = [
                        'numline' => $count,
                        'countrysale' => SessionHdl::getCorbizCountryKey(),
                        'item' => $isc['key_item'],
                        'quantity ' => $isc['quantity'] * $qtyItems,
                        'listPrice' => $isc['price_no_format'],
                        'discPrice' => '',
                        'points' => 0,
                        'promo' => true
                    ];
                    $count++;
                }
            }
        }
        //Se guardan en sesion los articulos de promocion temporales para cotizacion
        Session::put('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate', $arrayItems);
    }

    private function addItemPromoTempByClvArti($typePromo, $clvPromo, $qtyItems, $process = "checkout"){

        //Se obtienen de sesion los articulos de promocion originales
        $itemsPromos = session()->get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotions.items.'.$typePromo.'.'.$clvPromo);

        //Se obtienen de sesion los articulos de promocion temporales para cotizacion
        $arrayItems = Session::has('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') ?
            Session::get('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate') : array();
        //$arrayItems = array();
        $count = 0;
        foreach ($itemsPromos as $itmLine) {
            foreach ($itmLine as $index => $isc) {
                foreach ($qtyItems as $indexQI => $qi) {
                    if (($indexQI == $isc['key_item']) && ((int)$qi > 0)) {
                        $arrayItems[$clvPromo][$isc['key_item']] = [
                            'numline' => $count,
                            'countrysale' => SessionHdl::getCorbizCountryKey(),
                            'item' => $isc['key_item'],
                            'quantity ' => $isc['quantity'] * (int)$qi,
                            'listPrice' => $isc['price_no_format'],
                            'discPrice' => '',
                            'points' => 0,
                            'promo' => true
                        ];
                        $count++;
                    }
                }
            }
        }
        //Se guarda en sesion los articulos de promocion temporales para cotizacion
        Session::put('portal.'.$process.'.'.SessionHdl::getCorbizCountryKey().'.promotionsItemsTempValidate', $arrayItems);
    }

    private function addPromotionsSent($whereSaveSession){
        $promotionsSent = array();
        $headPromotions = Session::get("portal.{$whereSaveSession}.".SessionHdl::getCorbizCountryKey().".promotions.head") != null ?
            Session::get("portal.{$whereSaveSession}.".SessionHdl::getCorbizCountryKey().".promotions.head") : array();

        foreach($headPromotions as $hp) {
            foreach($hp as $promo) {
                $promotionsSent[] = trim($promo["key_promo"]);
                //dd($itemsPromoSession,$itemsPromoValidation, $newItemsPromo);
                Session::push('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent', trim($promo["key_promo"]));
            }
        }
        //Session::put('portal.'.$whereSaveSession.'.'.SessionHdl::getCorbizCountryKey().'.promotionsSent', $promotionsSent);

        return $promotionsSent;
    }

    public function getValidateQuantityPromo($promotion = array(), $max_allowed = 0){
        $result = array('max_allowed' => false, 'line' => false, 'quantity' => false);
        $all_zero = true; //Bandera para verificar si todas las lineas estan en 0, entonces max_allowed = true.
            foreach($promotion as $keyLine => $line) {
                if ((int)$line > 0) {
                    $all_zero = false;
                    if ((int)$line <= $max_allowed) {
                        $result['max_allowed'] = true;
                    }
                    $result['line'] = $keyLine;
                    $result['quantity'] = (int)$line;
                    break;
                } else {
                    $result['line'] = $keyLine;
                    $result['quantity'] = (int)$line;
                }
            }
            if($all_zero){
                $result['max_allowed'] = true;
            }

         return $result;
    }
}

