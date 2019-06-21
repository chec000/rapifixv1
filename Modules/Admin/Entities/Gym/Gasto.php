<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Gasto extends Eloquent
{
    
 protected $table = 'gym_gastos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'cod_producto','nombre','descripcion','cantidad','valor_costo','valor_total','id_usuario','fecha_compra'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
public $timestamps = true;


}
