<?php

namespace Modules\Admin\Http\Controllers\gym\Auth;

use Modules\Admin\Entities\Gym\User;
use Modules\Admin\Http\Controllers\gym\Controller;
use Modules\Admin\Entities\Gym\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use GuzzleHttp\Client as GuzzleAdapter;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
 protected function create(array $data)
{
 
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'apellido_paterno'=>$data['apellido_paterno'],
        'apellido_materno'=>$data['apellido_materno'],
        'telefono'=>$data['telefono'],
        'telefono_celular'=>$data['telefono_celular'],
        'fecha_nacimiento'=>$data['fecha_nacimiento'],
         'estado_civil'=>$data['estado_civil'],
        'estado'=>$data['estado'], 
        'ciudad'=>$data['estado'],
        'direccion'=>$data['direccion'],
        'pais'=>$data['pais'],           
        'latitud'=>$data['lat'],
        'longitud'=>$data['lon'],
        'password' => bcrypt($data['password']),
    ]);
    $user
        ->roles()
        ->attach(Role::where('name', 'user')->first());
    return $user;
}

public function createUser(array $data)
{
    
    $user = User::firstOrCreate([
     'name' => $data['name'],
        'email' => $data['email'],
        'apellido_paterno'=>$data['apellido_paterno'],
//        'apellido_materno'=>$data['apellido_materno'],
         'apellido_materno'=>"",
        'telefono'=>$data['telefono'],
        'telefono_celular'=>$data['telefono_celular'],
        'fecha_nacimiento'=>$data['fecha_nacimiento'],
         'estado_civil'=>$data['estado_civil'],
        'estado'=>$data['estado'], 
        'ciudad'=>$data['estado'],
        'direccion'=>$data['direccion'],
         'clave_unica'=>$data['clave_unica'],
        'foto'=>$data['flag'],
        'pais'=>$data['pais'],           
        'latitud'=>$data['lat'],
        'longitud'=>$data['lon'],
        'password' => bcrypt($data['password']),
    ]);
    $user
        ->roles()
        ->attach(Role::where('name', 'user')->first());
    return $user;
}
}
