<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Promocion extends Eloquent
{
    
 protected $table = 'gym_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'nombres', 'apellidos','direccion','fecha_nacimiento','email','fecha_inscripcion','estado','foto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
