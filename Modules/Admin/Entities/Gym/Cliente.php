<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Cliente extends Eloquent
{
    
 protected $table = 'gym_cliente';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_inscripcion', 'id_usuario', 'estado',
    ];

     public function  membresia(){
      return $this->hasMany('Modules\Admin\Entities\Gym\Membresia');          
    }
    
}
