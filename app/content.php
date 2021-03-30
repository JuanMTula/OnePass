<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class content extends Model
{
    protected $table = 'content';
    public $timestamps = false;

    public static function returnErrorAsObject($message){
        $message = ['status'=>'error','message'=>$message];
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($message);
        exit();
    }

    public static function returnSuccessAsObject($message){
        $message = ['status'=>'success','message'=>$message];
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($message);
        exit();
    }

    public static function jsonResponse($data){
        header_remove();
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    public function claves()
    {
        return $this->hasMany('App\claves', 'claves_contid','categoria_id')
            ->select(['claves_id', 'claves_contid','claves_titulo', 'claves_texto', 'claves_tipo',  'claves_color', 'claves_url', 'claves_tel', 'claves_cuenta', 'claves_clave']);
    }

}
