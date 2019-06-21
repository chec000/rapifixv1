<?php


namespace Modules\Admin\Entities\Gym;


use Eloquent;
class Venta extends Eloquent
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'id_cliente', 'id_empleado','nombre_cliente','tipo_pago','total','estatus','descuento_id','factura','diferencia'
    ];
 protected $table = 'gym_venta';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $timestamps = true;
     public function  detalleVenta(){
    return $this->hasMany('Modules\Admin\Entities\Gym\DetalleVenta');          
    }
    
    
        public function  cliente(){
               return $this->belongsTo('Modules\Admin\Entities\Gym\UsuarioCliente','id_cliente','id_usuario');
           }
           
                   public function  usuario(){
                              return $this->belongsTo('Modules\Admin\Entities\Gym\User','id_cliente','id');
           }
                   public function  seller(){
                              return $this->belongsTo('Modules\Admin\Entities\ACL\User','id_empleado','id');
           }
           
}
