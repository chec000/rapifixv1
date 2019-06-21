<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Membresia extends Eloquent
{
    
 protected $table = 'gym_membresias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_id', 'nombre', 'precio','descripcion','duracion_meses','activo','imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public  function tipo(){
        return $this->hasOne('Modules\Admin\Entities\Gym\TipoMembresia','id','tipo_id');
            
           }
           public function  deportes(){
                              return $this->belongsToMany('Modules\Admin\Entities\Gym\Deporte', 'gym_membresia_deporte', 'membresia_id', 'deporte_id');

           }

           public function  beneficios(){
                       return $this->belongsToMany('Modules\Admin\Entities\Gym\Beneficio','gym_beneficios_membresia','membresia_id','beneficio_id');
           }

           }
