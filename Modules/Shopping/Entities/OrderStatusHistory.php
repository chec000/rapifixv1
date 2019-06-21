<?php namespace Modules\Shopping\Entities;

use Eloquent;


class OrderStatusHistory extends Eloquent
{


    protected $fillable = ['order_id','order_estatus_id','comment','last_modifier_id'];
    protected $table = 'shop_order_status_history';


    public function order()
    {
        return $this->belongsTo('Modules\Shopping\Entities\Order','order_id');
    }


    public function countries()
    {
        return $this->belongsToMany('Modules\Admin\Entities\Country', 'shop_orderestatus_countries', 'order_id', 'country_id')->wherePivot('active', 1);
    }

    public function users()
    {
        return $this->belongsToMany('Modules\Admin\Entities\ACL\User', 'glob_user_countries', 'country_id', 'user_id');
    }

    public function estatus()
    {
        return $this->belongsTo('Modules\Shopping\Entities\OrderEstatus','order_estatus_id','id');
    }











}
