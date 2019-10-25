<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
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
    
    public function setsession(){
        
        $value = session('status');
        if($value == 1){
             
            return 'ok'; 
             
        }
        
    }
    
    public function login(){
        
        $res = new \App\stdclass;
        
        $captcha=request('grc');        

        $secret = env('GOOGLE_CAPTCHA_PRIV');
        
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        
        $response = json_decode($response, true);
        $resxresponse = $response["success"];
        $resxresponse = intval($resxresponse);

        if($resxresponse == 0)
        {
            $res->mensaje='Eres un robot.';
            $res->valido=0;
            return $res;
        }
    
        $mail = request('mail');
        $pass = request('pass');  
        
        $user = DB::table('usuarios')->where('usr_mail', $mail)->get();
        
        if(count($user) == 1){
        
            if (Hash::check($pass, $user[0]->usr_clave)) {
                
                $res->mensaje='Iniciando.';
                $res->valido=1;
                
                session(['user_id' => $user[0]->usr_id]);
                session(['status' => '1']);
                
                return $res;
            }else{
                
                $res->mensaje='Usuario o clave invalida.';
                $res->valido=0;
                return $res;
            }
        }else{
            
            $res->mensaje='Usuario o clave invalida.';
            $res->valido=0;
            return $res;
        }
        
        
    }
    
    public function logout(){
  
        $res = new \App\stdclass;

        session()->forget('user_id');
        session()->forget('status');
        session()->flush();
        
        $res->mensaje='Cerrando sesion.';
        $res->valido=1;
        return $res;
        
        
    }
    
}
