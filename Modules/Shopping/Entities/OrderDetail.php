<?php namespace Modules\Shopping\Entities;

use Eloquent;


class OrderDetail extends Eloquent
{


    protected $fillable = ['order_id','product_id','promo_product_id','quantity','list_price','final_price','points','iskit','active','is_promo','tax_percentage','tax_currency','tax_amount','country_group_id','last_modifier_id'];
    protected $table = 'shop_order_detail';


    public function products()
    {
        return $this->belongsTo('Modules\Shopping\Entities\Product','product_id');
    }

    public function countryProduct()
    {
        return $this->belongsTo('Modules\Shopping\Entities\CountryProduct', 'product_id', 'id');
    }


    public function productSkuPromo()
    {
        return $this->belongsTo('Modules\Shopping\Entities\PromoProd', 'promo_prod_id', 'id');
    }

    public function reference()
    {
        return $this->belongsTo('Modules\Shopping\Entities\RegistrationReferences', 'registration_reference_id', 'id');
    }
}