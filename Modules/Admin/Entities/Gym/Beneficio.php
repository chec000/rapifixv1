<?php

namespace Modules\Admin\Entities\Gym;

use Eloquent;
class Beneficio extends Eloquent
{
    
 protected $table = 'gym_beneficios';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion','activo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
