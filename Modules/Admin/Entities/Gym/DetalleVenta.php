<?php


namespace Modules\Admin\Entities\Gym;

use Eloquent;
class DetalleVenta extends Eloquent
{
    
 protected $table = 'gym_detalle_venta';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'venta_id', 'product_id','tipo_producto_id', 'producto','cantidad','subtotal'
    ];
 public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
