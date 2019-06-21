<?php


namespace Modules\Admin\Entities\Gym;

use Illuminate\Database\Eloquent\Model;


class Pais extends Model
{
  
     protected $table = 'gym_pais';
    protected $fillable = ['id'];
            
     
           public  function estados(){
        return $this->hasMany('Modules\Admin\Entities\Gym\Estado');
            
           }
    

}
