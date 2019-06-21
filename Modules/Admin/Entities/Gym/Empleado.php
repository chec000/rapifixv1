<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Empleado extends Eloquent
{
    
 protected $table = 'gym_empleado';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_inscripcion', 'id_usuario', 'estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
