<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Deporte extends Eloquent
{
    
 protected $table = 'gym_deportes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'nombre', 'descripcion','active','foto','precio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
public $timestamps = false;

     public function  objetivos(){
    return $this->belongsToMany('Modules\Admin\Entities\Gym\ObjetivosDeporte', 'gym_objetivos_as_deporte', 'deporte_id','objetivo_deporte_id');

           }

}
