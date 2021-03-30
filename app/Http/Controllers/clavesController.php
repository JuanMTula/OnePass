<?php

namespace App\Http\Controllers;

use App\content;
use App\claves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Crypt;

class clavesController extends Controller
{
    public function modificar(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // id
        $toValidate['fields']['id']     = $request['id'];
        $toValidate['constrains']['id'] = 'required|integer|exists:claves,claves_id';

        // titulo
        $toValidate['fields']['titulo']      = $request['titulo'];
        $toValidate['constrains']['titulo']  = 'required|string|min:1';

        // detalle
        $toValidate['fields']['detalle']      = $request['detalle'];
        $toValidate['constrains']['detalle']  = 'nullable|string';

        // telefono
        $toValidate['fields']['telefono']      = $request['telefono'];
        $toValidate['constrains']['telefono']  = 'nullable|string';

        // cuenta
        $toValidate['fields']['cuenta']      = $request['cuenta'];
        $toValidate['constrains']['cuenta']  = 'nullable|string';

        // clave
        $toValidate['fields']['clave']      = $request['clave'];
        $toValidate['constrains']['clave']  = 'nullable|string';

        // url
        $toValidate['fields']['url']      = $request['url'];
        $toValidate['constrains']['url']  = 'nullable|string';

        // tipo
        $toValidate['fields']['tipo']     = $request['tipo'];
        $toValidate['constrains']['tipo'] = 'required|in:'.implode(',', categoriasController::imagesArray);

        // color
        $toValidate['fields']['color']     = $request['color'];
        $toValidate['constrains']['color'] = 'required|in:'.implode(',', categoriasController::colorArray);


        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }

        $clave  = claves::where('content_usr_id',session()->get('user_id')  )
            ->where('claves_id', $request['id'])
            ->join('content','content.content_id','claves.claves_contid')
            ->first();

        if(!$clave)
            content::returnErrorAsObject("Clave no encontrada");

        $updated = claves::where('claves_id', $request['id'])
            ->update(['claves_titulo' => Crypt::encrypt($request['titulo']),
                      'claves_texto'  => Crypt::encrypt($request['detalle']),
                      'claves_url'    => Crypt::encrypt($request['url']),
                      'claves_tel'    => Crypt::encrypt($request['telefono']),
                      'claves_cuenta' => Crypt::encrypt($request['cuenta']),
                      'claves_tipo'   => Crypt::encrypt($request['tipo']),
                      'claves_color'  => Crypt::encrypt($request['color']),
                      'claves_clave'  => Crypt::encrypt($request['clave'])]);

        if($updated)
            content::returnSuccessAsObject('Clave modificada');
        else
            content::returnErrorAsObject('Error modificando clave');
    }

    public function borrar(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // id
        $toValidate['fields']['id']     = $request['id'];
        $toValidate['constrains']['id'] = 'required|integer|exists:claves,claves_id';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }

        $clave  = claves::where('content_usr_id',session()->get('user_id')  )
            ->where('claves_id', $request['id'])
            ->join('content','content.content_id','claves.claves_contid')
            ->first();

        if(!$clave)
            content::returnErrorAsObject("Clave no encontrada");

        $deleted = claves::where('claves_id', $request['id'])->delete();

        if($deleted)
            content::returnSuccessAsObject('Clave borrada');
        else
            content::returnErrorAsObject('Error borrar clave');

    }

    public function crear(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // categoria_id
        $toValidate['fields']['categoria_id']     = $request['categoria_id'];
        $toValidate['constrains']['categoria_id'] = 'required|integer|exists:content,content_id';

        // titulo
        $toValidate['fields']['titulo']      = $request['titulo'];
        $toValidate['constrains']['titulo']  = 'required|string|min:1';

        // detalle
        $toValidate['fields']['detalle']      = $request['detalle'];
        $toValidate['constrains']['detalle']  = 'nullable|string';

        // telefono
        $toValidate['fields']['telefono']      = $request['telefono'];
        $toValidate['constrains']['telefono']  = 'nullable|string';

        // cuenta
        $toValidate['fields']['cuenta']      = $request['cuenta'];
        $toValidate['constrains']['cuenta']  = 'nullable|string';

        // clave
        $toValidate['fields']['clave']      = $request['clave'];
        $toValidate['constrains']['clave']  = 'nullable|string';

        // url
        $toValidate['fields']['url']      = $request['url'];
        $toValidate['constrains']['url']  = 'nullable|string';

        // tipo
        $toValidate['fields']['tipo']     = $request['tipo'];
        $toValidate['constrains']['tipo'] = 'required|in:'.implode(',', categoriasController::imagesArray);

        // color
        $toValidate['fields']['color']     = $request['color'];
        $toValidate['constrains']['color'] = 'required|in:'.implode(',', categoriasController::colorArray);


        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }

        $content = content::where('content_usr_id',session()->get('user_id')  )
            ->where('content_id', $request['categoria_id'])
            ->first();

        if(!$content)
            content::returnErrorAsObject("Categoria no encontrada");

        $clave = new claves;
        $clave->claves_contid = $request['categoria_id'];
        $clave->claves_titulo = Crypt::encrypt($request['titulo']);
        $clave->claves_texto = Crypt::encrypt($request['detalle']);
        $clave->claves_tipo = Crypt::encrypt($request['tipo']);
        $clave->claves_color = Crypt::encrypt($request['color']);
        $clave->claves_url = Crypt::encrypt($request['url']);
        $clave->claves_tel = Crypt::encrypt($request['telefono']);
        $clave->claves_cuenta = Crypt::encrypt($request['cuenta']);
        $clave->claves_clave = Crypt::encrypt($request['clave']);

        if($clave->save())
            content::returnSuccessAsObject('Clave creada');
        else
            content::returnErrorAsObject('Error creando clave');


    }
}
