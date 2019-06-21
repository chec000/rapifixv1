<?php

namespace Modules\Admin\Entities\Gym;


use Eloquent;
class ClienteMembresia extends Eloquent
{
    
 protected $table = 'gym_compra_cliente_membresia';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id', 'membresia_id','tipo','nombre_membresia', 'precio','venta_id','fecha_compra','fecha_proximo_pago','estatus'
    ];

    

}