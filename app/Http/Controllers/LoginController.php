<?php

namespace App\Http\Controllers;

use App\content;
use App\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function home(){
        return view('home');
    }

    public function nuevoUsuario(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // nombre
        $toValidate['fields']['nombre']      = $request['nombre'];
        $toValidate['constrains']['nombre']  = 'required|string|between:3,255';

        // mail
        $toValidate['fields']['mail']      = $request['mail'];
        $toValidate['constrains']['mail']  = 'required|email|unique:usuarios,usr_mail';

        // clave
        $toValidate['fields']['password']      = $request['password'];
        $toValidate['constrains']['password']  = 'required|between:6,255';

        // clave_confirmation
        $toValidate['fields']['password_confirmation']      = $request['password_confirmation'];
        $toValidate['constrains']['password_confirmation']  = 'required|min:6|max:255|same:password';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }

        $usuario = new usuarios;
        $usuario->usr_nombre=$request['nombre'];
        $usuario->usr_mail  =$request['mail'];
        $usuario->usr_clave =Hash::make($request['password']);

        if($usuario->save())
            content::returnSuccessAsObject('Usuario creada');
        else
            content::returnErrorAsObject('Error creando usuario');
    }

    public function setSession($userId){

        session(['user_id' => $userId]);
        session(['status' => true]);

        return ['mensaje'=>'Iniciando.','valido'=>true];

    }

    public function login(Request $request){

        $user = DB::table('usuarios')->where('usr_mail', $request['mail'])->first();

        if($user)
            if (Hash::check($request['clave'], $user->usr_clave))
                return $this->setSession($user->usr_id);
            else
                return ['mensaje'=>'Usuario o clave invalida.','valido'=>false];
        else
            return ['mensaje'=>'Usuario o clave invalida.','valido'=>false];

    }

    public static function logout(){

        session()->forget('user_id');
        session()->forget('status');
        session()->flush();

        return ['mensaje'=>'Cerrando sesion.','valido'=>true];
    }

}
