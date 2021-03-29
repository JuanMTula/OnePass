<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{

    public function home(){
        return view('home');
    }

    public function requerimientos(){

        //php 7.1
        $M_php_version_req = 7.1;
        if(floatval(substr(phpversion(),0,3)) < $M_php_version_req) {
            die("Requisito necesario : php ".$M_php_version_req." o superior.");
        }

        //Modulos requeridos de php
        $M_php_lib_req = array("mysqli", "mbstring","json");
        foreach ($M_php_lib_req as &$M_php_lib) {
            if(array_search($M_php_lib, get_loaded_extensions()) == false){
                die("Requisito necesario : libreria '".$M_php_lib."' instalada.");
            }
        }

        die("Requisito cumplidos.");
    }

    public function newregist(){

        $nombre = request('nombre');
        $mail = request('mail');
        $pass = request('pass');
        $pass2 = request('pass2');

        $res = new \App\stdclass;

        if($nombre ==""){
            $res->mensaje="Campo nombre sin completar.";
            $res->valido=0;
            return $res;
        }
        if($mail ==""){
            $res->mensaje="Campo mail sin completar.";
            $res->valido=0;
            return $res;
        }
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $res->mensaje="Campo mail no es valido.";
            $res->valido=0;
            return $res;
        }
        if($pass ==""){
            $res->mensaje="Campo clave sin completar.";
            $res->valido=0;
            return $res;
        }
        if($pass2 ==""){
            $res->mensaje="Campo repetir clave sin completar.";
            $res->valido=0;
            return $res;
        }
        if($pass2 != $pass){
            $res->mensaje="Las claves no coniciden.";
            $res->valido=0;
            return $res;
        }

        $user = DB::table('usuarios')->where('usr_mail', $mail)->get();

        if(count($user) != 0){
            $res->mensaje="Ya existe un usuario con ese mail, use otro.";
            $res->valido=0;
            return $res;
        }

        $usr = new \App\usuarios;

        $usr->usr_nombre=$nombre;
        $usr->usr_mail=$mail;
        $usr->usr_clave=Hash::make($pass);

        $xres = $usr->save();
        if ($xres){
            $res->mensaje="Creado, redirigiendo...";
            $res->valido=1;

            $user = DB::table('usuarios')->where('usr_mail', $mail)->get();

            session(['user_id' => $user[0]->usr_id]);
            session(['status' => '1']);

            return $res;

        }else{
            $res->mensaje="No se puede crear usuario.";
            $res->valido=0;
            return $res;
        }

        $res->mensaje="Funcion fuera de campo.";
        $res->valido=0;

        return $res;

    }

    public function setSession($userId){

        session(['user_id' => $userId]);
        session(['status' => true]);

        return ['mensaje'=>'Iniciando.','valido'=>true];

    }

    public function login(Request $request){

        if(env('GOOGLE_CAPTCHA_PRIV') && env('GOOGLE_CAPTCHA_PUBL')){

            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".env('GOOGLE_CAPTCHA_PRIV')."&response=".$request['grc']."&remoteip=".$_SERVER['REMOTE_ADDR']);
            $response = json_decode($response, true);
            $resxresponse = $response["success"];
            $resxresponse = intval($resxresponse);
            if(!$resxresponse)
                return ['mensaje'=>'Eres un robot.','valido'=>false];

        }

        $user = DB::table('usuarios')->where('usr_mail', $request['mail'])->get();

        if(count($user))
            if (Hash::check($request['clave'], $user[0]->usr_clave))
                return $this->setSession($user[0]->usr_id);
            else
                return ['mensaje'=>'Usuario o clave invalida.','valido'=>false];
        else
            return ['mensaje'=>'Usuario o clave invalida.','valido'=>false];

    }

    public function checkSession(){
     if(session()->get('status'))
         return '1';
     return 0;
    }

    public static function logout(){

        session()->forget('user_id');
        session()->forget('status');
        session()->flush();

        return ['mensaje'=>'Cerrando sesion.','valido'=>true];
    }

}
