<?php namespace Modules\Shopping\Entities;

use Eloquent;


class Customer extends Eloquent
{


    protected $fillable = ['country_id','sponsor','sponsor_name','sponsor_email','ca_number','ca_name','ca_lastname','password','address','number','complement','suburb','zip_code','city','city_name','state','county','email','telephone','cell_number','gender','security_question_id','answer','kit_type','document_key','document_number','shipping_company','corbiz_transaction','error_corbiz','error_user','birthdate','last_modifier_id'];
    protected $table = 'shop_customers';



    public function country()
    {
        return $this->belongsTo('Modules\Admin\Entities\Country');
    }








}
