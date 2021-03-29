<?php

namespace App\Http\Controllers;

use App\content;
use App\claves;
use App\functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Crypt;
use Illuminate\Support\Facades\Validator;

class contentController extends Controller
{
    public function categorias(){

        content::jsonResponse(
            content::where('content_usr_id', session('user_id'))
                ->with('claves')
                ->select('content_id as categoria_id',
                    'content_label as categoria_titulo',
                    'content_icono as categoria_icono')
                ->get());

    }

    public function modificarcategoria(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // id
        $toValidate['fields']['id']     = $request['id'];
        $toValidate['constrains']['id'] = 'required|integer|exists:content,content_id';

        // detalle
        $toValidate['fields']['nombre']     = $request['nombre'];
        $toValidate['constrains']['nombre'] = 'required|string|min:1';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }

        $categria = content::where('content_usr_id',session()->get('user_id')  )
            ->where('content_id', $request['id'])
            ->update(['content_label'=>$request['nombre']]);

        if($categria)
            content::returnSuccessAsObject('Categoria modificada');
        else
            content::returnErrorAsObject('Error modificando categoria');

    }

    public function crearcategoria(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // detalle
        $toValidate['fields']['nombre']     = $request['nombre'];
        $toValidate['constrains']['nombre'] = 'required|string|min:1';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
             content::returnErrorAsObject($resp);
        }

        $categoria = new content();
        $categoria->content_usr_id = session()->get('user_id');
        $categoria->content_label = $request['nombre'];
        $categoria->content_icono = "01";

        if($categoria->save())
             content::returnSuccessAsObject('Categoria creada');
        else
             content::returnErrorAsObject('Error creando categoria');

    }

    public function borrarcategoria(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // id
        $toValidate['fields']['id']     = $request['id'];
        $toValidate['constrains']['id'] = 'required|integer|exists:content,content_id';

        $validator = Validator::make($toValidate['fields'], $toValidate['constrains']);
        if ($validator->fails()) {
            $resp = [];
            foreach ($validator->errors()->toArray() as $obj){
                $resp = array_merge($resp,$obj);
            }
            content::returnErrorAsObject($resp);
        }
        $categoria = content::where('content_usr_id',session()->get('user_id')  )
                            ->where('content_id', $request['id'])
                            ->first();
        if(!$categoria)
            content::returnErrorAsObject("Categoria no encontrada");

        DB::transaction(function() use ($request)
        {
            try
            {
                content::where('content_usr_id',session()->get('user_id')  )
                       ->where('content_id', $request['id'])
                       ->delete();

                claves::where('claves_contid', $request['id'])->delete();

            }
            catch (Exception $e)
            {
                content::returnErrorAsObject('Error borrando categoria');
            }
        });

        content::returnSuccessAsObject('Categoria borrada');

    }

    public function modificarclave(Request $request){

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
                         ->update(['claves_titulo' => $request['titulo'],
                                   'claves_texto'  => $request['detalle'],
                                   'claves_url'    => $request['url'],
                                   'claves_tel'    => $request['telefono'],
                                   'claves_cuenta' => $request['cuenta'],
                                   'claves_clave'  => $request['clave']]);


        if($updated)
            content::returnSuccessAsObject('Clave modificada');
        else
            content::returnErrorAsObject('Error modificando clave');
    }

    public function borrarclave(Request $request){

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

    public function crearclave(Request $request){

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
        $clave->claves_titulo = $request['titulo'];
        $clave->claves_texto = $request['detalle'];
        $clave->claves_tipo = 01;
        $clave->claves_url = $request['url'];
        $clave->claves_tel = $request['telefono'];
        $clave->claves_cuenta = $request['cuenta'];
        $clave->claves_clave = $request['clave'];

        if($clave->save())
            content::returnSuccessAsObject('Clave creada');
        else
            content::returnErrorAsObject('Error creando clave');


    }

}
