<?php namespace Modules\Shopping\Entities;

use Eloquent;


class ShippingAddress extends Eloquent
{


    protected $fillable = ['order_id','sponsor','sponsor_name','sponsor_email','eo_number','eo_name','eo_lastname','eo_lastnamem','type_address','folio_address','address','number','cpf','complement','suburb','zip_code','city','city_name','state','county','email','telephone','cellphone','gender','registration_reference_id','security_question_id','answer','kit_type','order_document_id','birthdate','is_mobile','is_pool','public_ip','last_modifier_id'];
    protected $table = 'shop_shipping_address';


    public function order()
    {
        return $this->belongsTo('Modules\Shopping\Entities\Order');
    }







}
