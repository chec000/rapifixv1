<?php namespace Modules\Shopping\Entities;

use Eloquent;
use Dimsav\Translatable\Translatable;
use Illuminate\Support\Facades\Config;
use Modules\CMS\Libraries\Traits\DataPreLoad;

class Order extends Eloquent
{


    protected $fillable = ['country_id','distributor_number','order_estatus_id','order_number','points','total_taxes','total','subtotal','discount','shipping_company','guide_number','corbiz_order_number','bank_transaction','bank_status','bank_authorization','card_type','payment_type','payment_brand','shop_type','error_corbiz','error_user','corbiz_transaction','warehouse_id','management','attempts','change_period','contract_path','source_id','saved_dataeo','terms_checked','policies_checked','advertise_checked','last_modifier_id'];
    protected $table = 'shop_orders';

        public function orderDetail()
        {
            return $this->hasMany('Modules\Shopping\Entities\OrderDetail');
        }


        public function orderDetailPromo()
        {
            return $this->hasMany('Modules\Shopping\Entities\OrderDetailPromo');
        }

        public function orderDocument()
        {
            return $this->hasMany('Modules\Shopping\Entities\OrderDocument');
        }


        public function source()
        {
            return $this->hasOne('Modules\Shopping\Entities\Source','id','source_id');
        }


        public function customerDocument()
        {
            return $this->hasMany('Modules\Shopping\Entities\CustomerDocument');
        }

        public function product(){
            return $this->belongsTo('Modules\Admin\Entities\Product');
        }


        public  function shippingAddress()
        {
            return $this->hasOne('Modules\Shopping\Entities\ShippingAddress','order_id');
        }

        public function country()
        {
             return $this->belongsTo('Modules\Admin\Entities\Country');
        }

        public function country_corbiz()
        {
            return $this->hasOne('Modules\Admin\Entities\Country', 'id', 'country_id');
        }

        public function bank()
        {
            return $this->belongsTo('Modules\Shopping\Entities\Bank', 'bank_id', 'id');
        }

        public function warehouse()
        {
            return $this->belongsTo('Modules\Shopping\Entities\WarehouseCountry','warehouse_id');
        }


        public function estatus()
        {
            return $this->belongsTo('Modules\Shopping\Entities\OrderEstatus','order_estatus_id');
        }


        public function products(){
            return $this->hasMany('Modules\Shopping\Entities\CountryProduct','country_id','country_id')->where('active',1)->where('delete',0);
        }


        public function pt(){
            return $this->hasMany('Modules\Shopping\Entities\Product','product_id','id')->where('active',1)->where('delete',0);
        }



        public function users()
        {
            return $this->belongsTo('Modules\Admin\Entities\ACL\User','last_modifier_id');
        }

        public function orderstatushistory(){
            return $this->hasMany('Modules\Shopping\Entities\OrderStatusHistory');
        }


        public static function exists($column, $value) {
            return self::where($column, $value)->first() != null;
        }

    /*
     * Cron.
     * 1. Listado de Ordenes a procesar.
     * 2. Join con la tabla shop_orderestatus para obtener la descripcion del status.
     * 3. Donde shop_orders.corbiz_order_number sea igual a 0.
     * 4. Donde shop_orderestatus.key_estatus sea igual a payment_successful.
     * 5. Con un limite de 10 ordenes.
     */
    public function getOrders()
    {
        $data = [];
        $countries = Config::get('shopping.cron.country');

        foreach ($countries as $key => $value)
        {
            if ($value > 0)
            {
                $data[] = $this->query()
                    ->join('shop_orderestatus', 'shop_orders.order_estatus_id', '=', 'shop_orderestatus.id')
                    ->join('glob_countries', 'shop_orders.country_id', '=', 'glob_countries.id')
                    ->select('shop_orders.id AS so_id', 'shop_orders.shop_type AS so_shop_type')
                    ->where([
                        ['shop_orders.corbiz_order_number', '=', 0],
                        ['shop_orderestatus.key_estatus', '=', 'PAYMENT_SUCCESSFUL'],
                        ['glob_countries.corbiz_key', '=', $key],
                    ])
                    ->limit($value)
                    ->get();
            }
        }

        if ($data != null)
        {
            return $data;
        }

        return array();
    }

    /*
     * Cron.
     * 1. Obtener info de la orden.
     * 2. Join con la tabla shop_orderestatus para obtener la descripcion del status.
     * 3. Join con la tabla shop_shipping_address para obtener la info de envio.
     * 4. Donde shop_orders.corbiz_order_number sea igual a 0.
     * 5. Donde shop_orderestatus.key_estatus sea igual a payment_successful.
     * 6. Donde shop_orders.id sea igual a $order_id.
     */
    public function getOrderInfo($order_id)
    {
        $data = $this->query()
            ->join('shop_orderestatus', 'shop_orders.order_estatus_id', '=', 'shop_orderestatus.id')
            ->leftjoin('shop_shipping_address', 'shop_orders.id', '=', 'shop_shipping_address.order_id')
            ->select(
                'shop_orders.id AS so_id',
                'shop_orders.country_id AS so_country_id',
                'shop_orders.distributor_number AS so_distributor_number',
                'shop_orders.order_number AS so_order_number',
                'shop_orders.total AS so_total',
                'shop_orders.shipping_company AS so_shipping_company',
                'shop_orders.bank_id AS so_bank_id',
                'shop_orders.corbiz_transaction AS so_corbiz_transaction',
                'shop_orders.change_period AS so_change_period',
                'shop_orders.contract_path AS so_contract_path',
                'shop_orders.saved_dataeo AS so_saved_dataeo',
                'shop_orders.warehouse_id AS so_warehouse_id',
                'shop_orders.cent_dist AS so_cent_dist',
                'shop_orders.terms_checked AS so_terms_checked',
                'shop_orders.advertise_checked AS so_advertise_checked',
                'shop_shipping_address.id AS ssa_id',
                'shop_shipping_address.sponsor AS ssa_sponsor',
                'shop_shipping_address.sponsor_name AS ssa_sponsor_name',
                'shop_shipping_address.sponsor_email AS ssa_sponsor_email',
                'shop_shipping_address.eo_name AS ssa_eo_name',
                'shop_shipping_address.eo_lastname AS ssa_eo_lastname',
                'shop_shipping_address.eo_lastnamem AS ssa_eo_lastnamem',
                'shop_shipping_address.folio_address AS ssa_folio_address',
                'shop_shipping_address.address AS ssa_address',
                'shop_shipping_address.number AS ssa_number',
                'shop_shipping_address.complement AS ssa_complement',
                'shop_shipping_address.suburb AS ssa_suburb',
                'shop_shipping_address.zip_code AS ssa_zip_code',
                'shop_shipping_address.city AS ssa_city',
                'shop_shipping_address.city_name AS ssa_city_name',
                'shop_shipping_address.state AS ssa_state',
                'shop_shipping_address.county AS ssa_county',
                'shop_shipping_address.email AS ssa_email',
                'shop_shipping_address.telephone AS ssa_telephone',
                'shop_shipping_address.cellphone AS ssa_cellphone',
                'shop_shipping_address.gender AS ssa_gender',
                'shop_shipping_address.security_question_id AS ssa_security_question_id',
                'shop_shipping_address.answer AS ssa_answer',
                'shop_shipping_address.birthdate AS ssa_birthdate',
                'shop_shipping_address.is_pool AS ssa_is_pool',
                'shop_shipping_address.public_ip AS ssa_public_ip'
            )
            ->where([
                ['shop_orders.corbiz_order_number', '=', 0],
                ['shop_orderestatus.key_estatus', '=', 'PAYMENT_SUCCESSFUL'],
                ['shop_orders.id', '=', $order_id],
            ])
            ->first();

        if ($data != null)
        {
            return $data;
        }

        return false;
    }

    public static function getOrdersByStatus($status) {
        $totalOrders = [];
        $countries   = Config::get('shopping.cron.country');

        foreach ($countries as $countryKey => $limitOrders) {
            if ($limitOrders > 0) {

                $orders = Order::select('shop_orders.*')
                    ->join('shop_orderestatus', 'shop_orders.order_estatus_id', '=', 'shop_orderestatus.id')
                    ->join('glob_countries', 'shop_orders.country_id', '=', 'glob_countries.id')
                    ->where([
                        ['shop_orders.corbiz_order_number', '=', 0],
                        ['glob_countries.corbiz_key', '=', $countryKey],
                        ['shop_orderestatus.key_estatus', '=', $status]
                    ])
                    ->whereIn('shop_orders.bank_id', [1, 2])
                    ->limit($limitOrders)
                    ->get();

                if ($orders->count() > 0) {
                    $totalOrders[$countryKey] = $orders;
                }
            }
        }

        return $totalOrders;
    }
}