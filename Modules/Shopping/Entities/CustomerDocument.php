<?php namespace Modules\Shopping\Entities;

use Eloquent;


class CustomerDocument extends Eloquent
{


    protected $fillable = ['customer_id','document_key','document_name','document_number'];
    protected $table = 'shop_customer_documents';


    public function order()
    {
        return $this->belongsTo('Modules\Shopping\Entities\Order');
    }







}
