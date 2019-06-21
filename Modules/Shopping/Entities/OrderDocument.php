<?php namespace Modules\Shopping\Entities;

use Eloquent;


class OrderDocument extends Eloquent
{


    protected $fillable = ['order_id','document_key','document_name','document_number','document_expiration'];
    protected $table = 'shop_order_documents';


    public function order()
    {
        return $this->belongsTo('Modules\Shopping\Entities\Order');
    }







}
