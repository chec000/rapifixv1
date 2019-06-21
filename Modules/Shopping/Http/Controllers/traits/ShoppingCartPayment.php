<?php
/**
 * Created by PhpStorm.
 * User: vicente.gutierrez
 * Date: 10/08/18
 * Time: 11:56
 */

namespace Modules\Shopping\Http\Controllers\traits;


use App\Helpers\CommonMethods;
use App\Helpers\SessionHdl;
use App\Helpers\ShoppingCart;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Admin\Entities\Country;
use Modules\Shopping\Entities\ConfirmationBanner;
use Modules\Shopping\Entities\CountryProduct;
use Modules\Shopping\Entities\Order;
use Modules\Shopping\Entities\OrderDetail;
use Modules\Shopping\Entities\PromoProd;
use Modules\Shopping\Entities\ShippingAddress;
use Modules\Shopping\Entities\Source;

trait ShoppingCartPayment {

    /**
     * getWSSalesWeb
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWeb']['ttSalesWeb']
     * que se envía en la petición del servicio web addFormSalesTransaction. La información es obtenida desde la sesión
     *
     * @param bool $generateOrder
     * @return array
     */
    private function getWSSalesWeb($generateOrder = false) {
        $salesWeb = [];

        if (SessionHdl::hasEo()) {
            $shippingAddress = SessionHdl::getShippingAddress();
            $eo              = SessionHdl::getEo();
            $quotation       = SessionHdl::getQuotation();

            $salesWeb = [
                'countrysale'     => SessionHdl::getCorbizCountryKey(),
                'distributor'     => $eo['distId'],
                'amount'          => $quotation['total'],
                'receiver'        => $shippingAddress['name'],
                'address'         => $shippingAddress['address'],
                'number'          => $shippingAddress['number'],
                'suburb'          => $shippingAddress['suburb'],
                'complement'      => $shippingAddress['complement'],
                'state'           => $shippingAddress['stateKey'],
                'city'            => $shippingAddress['cityKey'],
                'county'          => $shippingAddress['county'],
                'zipcode'         => $shippingAddress['zipcode'],
                'shippingcompany' => $shippingAddress['shippingCompany'],
                'altAddress'      => $shippingAddress['folio'],
                'email'           => $shippingAddress['email'],
                'phone'           => $shippingAddress['phone'],
                'previousperiod'  => $quotation['period_change'] == 1,
                'source'          => 'WEB'
            ];

            if ($generateOrder) {
                $paymentCodes = config("shopping.paymentCorbizRelation.".SessionHdl::getCorbizCountryKey());

                $salesWeb['no_trans'] = SessionHdl::getTransaction();
                $salesWeb['type_mov'] = 'VENTA';
                $salesWeb['codepaid'] = $paymentCodes[SessionHdl::getPaymentMethod()] ?? $paymentCodes['default'];
                $salesWeb['zcreate']  = true;
            }
        }

        return $salesWeb;
    }

    /**
     * getWSSalesWebDB
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWeb']['ttSalesWeb']
     * que se envía en la petición del servicio web addFormSalesTransaction. La información es obtenida desde la base de datos
     *
     * @param bool $generateOrder
     * @param array $where          ['column' => 'value', 'value'=>'value']
     * @return array
     */
    private function getWSSalesWebDB($generateOrder = false, $where = []) {
        $salesWeb = [];

        if (SessionHdl::hasEo()) {
            # $where = ['column' => 'order_number', 'value' => 111111];
            $order    = Order::where($where['column'], $where['value'])->first();
            $shipping = ShippingAddress::where('order_id', $order->id)->first();

            $salesWeb = [
                'countrysale'     => SessionHdl::getCorbizCountryKey(),
                'distributor'     => $order->distributor_number,
                'amount'          => $order->total,
                'receiver'        => $shipping->eo_name,
                'address'         => $shipping->address,
                'number'          => $shipping->number == 0 ? '' : $shipping->number,
                'suburb'          => $shipping->suburb,
                'complement'      => $shipping->complement,
                'state'           => $shipping->state,
                'city'            => $shipping->city,
                'county'          => $shipping->county,
                'zipcode'         => $shipping->zip_code,
                'shippingcompany' => $order->shipping_company,
                'altAddress'      => (string) $shipping->folio_address,
                'email'           => $shipping->email,
                'phone'           => $shipping->telephone,
                'previousperiod'  => $order->change_period == 1,
                'source'          => 'WEB'
            ];

            if ($generateOrder) {
                $paymentCodes = config("shopping.paymentCorbizRelation.".SessionHdl::getCorbizCountryKey());

                $salesWeb['no_trans'] = $order->corbiz_transaction;
                $salesWeb['type_mov'] = 'VENTA';
                $salesWeb['codepaid'] = $paymentCodes[$order->bank_id] ?? $paymentCodes['default'];
                $salesWeb['zcreate']  = true;
            }
        }

        return $salesWeb;
    }

    /**
     * getWSSalesWebItems
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWebItems']['ttSalesWebItems']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *
     * @return array
     */
    private function getWSSalesWebItems() {
        $quotation     = SessionHdl::getQuotation();
        $salesWebItems = [];

        if (isset($quotation['items']) && is_array($quotation['items'])) {
            foreach ($quotation['items'] as $i => $item) {
                $salesWebItems[] = [
                    'numline'     => $i+1,
                    'countrysale' => SessionHdl::getCorbizCountryKey(),
                    'item'        => $item['sku'],
                    'quantity '   => $item['quantity'],
                    'listPrice'   => $item['listPrice'],
                    'discPrice'   => $item['discPrice'],
                    'points'      => $item['points'],
                    'promo'       => $item['promo']
                ];
            }
        }

        return $salesWebItems;
    }

    /**
     * getWSSalesWebItemsDB
     * Regresa un arreglo con la información nesesaría del proceso de compra para el parámetro ['request']['SalesWebItems']['ttSalesWebItems']
     * que se envía en la petición del servicio web addFormSalesTransaction
     *
     * @param array $where          ['column' => 'value', 'value'=>'value']
     * @return array
     */
    private function getWSSalesWebItemsDB($where = []) {
        $order         = Order::where($where['column'], $where['value'])->first();
        $items         = OrderDetail::where('order_id', $order->id)->get();
        $country       = Country::find($order->country_id);
        $salesWebItems = [];

        if ($items->count() > 0) {
            foreach ($items as $i => $item) {
                if ($item->is_promo == 1) {
                    $promoProduct = PromoProd::find($item->promo_prod_id);

                    if (!is_null($promoProduct)){
                        $sku = $promoProduct->clv_producto;
                    } else {
                        $sku = $item->product_code;
                    }

                } else if ($item->is_special == 1) {
                    $sku  = $item->product_code;
                } else {
                    $countryProduct = CountryProduct::find($item->product_id);
                    $sku  = $countryProduct->product->sku;
                }

                $salesWebItems[] = [
                    'numline'     => $i+1,
                    'countrysale' => $country->corbiz_key,
                    'item'        => $sku,
                    'quantity '   => $item->quantity,
                    'listPrice'   => $item->list_price,
                    'discPrice'   => $item->final_price,
                    'points'      => $item->points,
                    'promo'       => $item->is_promo == 1
                ];
            }
        }

        return $salesWebItems;
    }

    /**
     * getOrderDataFromQuotation
     * Regresa un arreglo con la información necesaria del proceso de compra para guardar en la tabla de shop_orders
     *
     * TODO Obtener el campo 'corbiz_payment_key''
     *
     * @param array $aditionalData  Campos adicionales para insertar
     * @return array
     */
    private function getOrderDataFromQuotation($aditionalData = []) {
        $common    = new CommonMethods();
        $quotation = $this->getQuotation();
        $salesWeb  = $this->getWSSalesWeb();
        $source    = Source::where('source_name', 'web')->first();
        $date      = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));

        $order = [
            'country_id'          => SessionHdl::getCountryID(),
            'distributor_number'  => SessionHdl::getDistributorId(),
            'order_estatus_id'    => $common->getOrderStatusId('NEW_ORDER', SessionHdl::getCountryID()),
            'order_number'        => $common->getNextOrderNumber(SessionHdl::getCountryID()), //'1200000002'
            'points'              => $quotation['points'],
            'total_taxes'         => $quotation['taxes'],
            'total'               => $quotation['total'],
            'subtotal'            => $quotation['subtotal'],
            'discount'            => $quotation['discount'],
            'shipping_company'    => $salesWeb['shippingcompany'],
            'guide_number'        => '',
            'corbiz_order_number' => '0',
            'bank_id'             => SessionHdl::getPaymentMethod(),
            'shop_type'           => 'Sell',
            'corbiz_transaction'  => SessionHdl::getTransaction(),
            'warehouse_id'        => $common->getWarehouseId(SessionHdl::getCountryID(), SessionHdl::getWarehouse()),
            'management'          => $quotation['handling'],
            'attempts'            => 0,
            'change_period'       => $quotation['period_change'],
            'source_id'           => $source->id,
            'last_modifier_id'    => 1,
            'created_at'          => $date->format('Y-m-d H:i:s'),
            'updated_at'          => $date->format('Y-m-d H:i:s'),
        ];

        $order = array_merge($order, $aditionalData);

        return $order;
    }

    /**
     * getOrderDetailDataFromQuotation
     * Regresa un arreglo con la información necesaria por cada item del proceso de compra para guardar en la tabla
     * shop_orders_detail
     *
     * @return array
     */
    private function getOrderDetailDataFromQuotation($orderId) {
        $quotation   = SessionHdl::getQuotation();
        $date        = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));
        $orderDetail = [];

        foreach ($quotation['items'] as $i => $item) {

            $productCode = '';
            $productName = '';

            if ($item['is_special']) {
                $productCode = $item['sku'];
                $productName = $item['name'];
            } else if ($item['promo']) {
                if ($item['id'] == 0 || empty($item['id'])) {
                    $productCode = $item['sku'];
                    $productName = $item['name'];
                }
            }

            $orderDetail[] = [
                'order_id'           => $orderId,
                'product_id'         => $item['is_special'] ? 0 : $item['id'], #id
                'promo_prod_id'      => $item['is_special'] ? 0 : ($item['promo'] ? $item['id'] : 0),
                'quantity'           => $item['quantity'], # quantity
                'final_price'        => $item['discPrice'], # discPrice
                'list_price'         => $item['listPrice'], # listPrice
                'points'             => $item['points'], # points
                'active'             => 1,
                'is_promo'           => $item['promo'], # promo
                'tax_percentage'     => '',
                'tax_currency'       => '',
                'tax_amount'         => $item['tot_tax'], # unit_tax
                'tax_unit'           => $item['unit_tax'], # tot_tax
                'is_special'         => $item['is_special'] ? 1 : 0,
                'product_code'       => $productCode,
                'product_name'       => $productName,
                'last_modifier_id'   => 1,
                'created_at'         => $date->format('Y-m-d H:i:s'),
                'updated_at'         => $date->format('Y-m-d H:i:s'),
            ];
        }

        return $orderDetail;
    }

    /**
     * getOrderShippingAddressFromQuotation
     * Regresa un arreglo con la información de la cotización para ser guardada en la tabla shop_shipping_address
     *
     * @param $orderId
     * @return array
     */
    private function getOrderShippingAddressFromQuotation($orderId) {
        $shippingAddress = SessionHdl::getShippingAddress();
        $eo              = SessionHdl::getEo();
        $date            = new \DateTime('now', new \DateTimeZone(SessionHdl::getTimeZone()));

        $orderShipping = [
            'order_id'             => $orderId,
            'sponsor'              => '',
            'sponsor_name'         => '',
            'sponsor_email'        => '',
            'eo_number'            => $eo['distId'], # OBLIGATORIO
            'eo_name'              => $shippingAddress['name'],
            'eo_lastname'          => '',
            'type_address'         => $shippingAddress['type'], # OBLIGATORIO
            'folio_address'        => $shippingAddress['folio'], # OBLIGATORIO
            'address'              => $shippingAddress['address'], # OBLIGATORIO
            'number'               => $shippingAddress['number'], # OBLIGATORIO
            'complement'           => $shippingAddress['complement'],
            'suburb'               => $shippingAddress['suburb'], # OBLIGATORIO
            'zip_code'             => $shippingAddress['zipcode'], # OBLIGATORIO
            'city'                 => $shippingAddress['cityKey'], # OBLIGATORIO
            'city_name'            => $shippingAddress['cityName'], # OBLIGATORIO
            'state'                => $shippingAddress['stateKey'], # OBLIGATORIO
            'county'               => $shippingAddress['county'], # OBLIGATORIO
            'email'                => $shippingAddress['email'], # OBLIGATORIO
            'telephone'            => $shippingAddress['phone'], # OBLIGATORIO
            'last_modifier_id'     => 1,
            'created_at'           => $date->format('Y-m-d H:i:s'),
            'updated_at'           => $date->format('Y-m-d H:i:s'),
        ];

        if (isset($shippingAddress['cpf'])) {
            $orderShipping['cpf'] = $shippingAddress['cpf'];
        }

        return $orderShipping;
    }

    /**
     * getQuotation
     * Regresa la cotización de la venta de la sesión
     *
     * @return array
     */
    private function getQuotation() {
        $quotation = [];
        if (SessionHdl::hasQuotation()) {
            $quotation = SessionHdl::getQuotation();
        }

        return $quotation;
    }

    /**
     * saveOrder
     * Guarda la información de una orden en las tablas shop_orders y shop_orders_detail
     *
     * @return array
     */
    private function saveOrder() {
        $response = ['status' => false];
        $error    = false;

        DB::beginTransaction();

        try {
            $order = $this->CommonMethods->saveModelData($this->getOrderDataFromQuotation(), Order::class);
            if ($order !== false) {
                $items = $this->getOrderDetailDataFromQuotation($order->id);
                foreach ($items as $item) {
                    $this->CommonMethods->saveModelData($item, OrderDetail::class);
                }
                $this->CommonMethods->saveModelData($this->getOrderShippingAddressFromQuotation($order->id), ShippingAddress::class);

                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['errors'] = [trans('shopping::checkout.payment.errors.sys003')];
                Log::error('ERR (SYS003): Problema al guardar en la tabla shop_orders');
            }
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                $response['status'] = false;
                $response['errors'] = [trans('shopping::checkout.payment.errors.sys001')];
                Log::error('ERR (SYS001): ' . $e->getMessage());
            }

            $error = true;
        } catch (\Exception $e) {
            $response['status'] = false;
            $response['errors'] = [trans('shopping::checkout.payment.errors.sys002')];
            Log::error('ERR (SYS002): ' . $e->getMessage());

            $error = true;
        }

        $error ? DB::rollBack() : DB::commit();

        return $response;
    }

    /**
     * forgetSession
     * Elimina la sesión del checkout y del carrito de compras
     *
     * @param $country          Corbiz key del país
     */
    private function forgetSession($country) {
        Session::forget("portal.checkout.{$country}");
        ShoppingCart::deleteSession($country);
    }

    /**
     * getBanners
     * Obtiene los ConfirmationBanners que se deben mostrar
     *
     * @param $type             Tipo del banner
     * @param $purpose          Propósito del banner
     * @param $countryID        ID del país
     * @return mixed
     */
    private function getBanners($type, $purpose, $countryID, $brandID) {
        return ConfirmationBanner::whereHas('type', function ($q) use ($type) {
            $q->where('type', $type);
        })->whereHas('purpose', function ($q) use ($purpose) {
            $q->where('purpose', $purpose);
        })->where('country_id', $countryID)->where('brand_id', $brandID)->where('active', 1)->where('delete', 0)->get();
    }

    /**
     * hasChangesInQuotation
     * Verifica si ha habido cambios en la cotización contra lo que hay en shop_orders
     *
     * @return bool
     */
    private function hasChangesInQuotation() {
        $order = Order::where('corbiz_transaction', SessionHdl::getTransaction())->first();

        if ($order != null) {
            $quotation    = SessionHdl::getQuotation();
            $itemsInOrder = $order->orderDetail->toArray();

            if (isset($quotation['items'])) {
                $results = [];
                foreach ($quotation['items'] as $item) {
                    $result = false;

                    foreach ($itemsInOrder as $itemInOrder) {
                        if ( ((int)$item['id']) == ((int)$itemInOrder['product_id']) && ((int)$item['quantity']) == ((int)$itemInOrder['quantity']) ) {
                            $result = true;
                        }
                    }

                    $results[] = $result;
                }

                foreach ($itemsInOrder as $itemInOrder) {
                    $result = false;

                    foreach ($quotation['items'] as $item) {
                        if ( ((int)$item['id']) == ((int)$itemInOrder['product_id']) && ((int)$item['quantity']) == ((int)$itemInOrder['quantity']) ) {
                            $result = true;
                        }
                    }

                    $results[] = $result;
                }

                return in_array(false, $results);
            }
        }

        return false;
    }

    private function hasChangeInAddress() {
        $order = Order::where('corbiz_transaction', SessionHdl::getTransaction())->first();

        if ($order != null) {
            $address      = SessionHdl::getShippingAddress();
            $orderAddress = $order->shippingAddress;

            if ( ((int) $address['folio']) !=  ((int) $orderAddress->folio_address) ) {
                return true;
            }
        }

        return false;
    }
}