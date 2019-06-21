<?php


namespace Modules\Admin\Http\Controllers\gym;


use Illuminate\Http\Request;
use Modules\Admin\Entities\Gym\User;
use View;
class UsuarioController extends Controller
{
    
    public function  getUsuarios(){
        
        return session()->all();
        return User::find(1);
    }
    
    public function addUsuario(Request $request){
        
    }
    
    public function updateUsuario(Request $request){
        
    }
    
    public function deleteUsuario(Request $request){
        
    }
    
    public function AddMembreciaUsuario(){
        
    }
    
    
    public function PaseListaUsuario(){
        
    }
    
    
    
}
