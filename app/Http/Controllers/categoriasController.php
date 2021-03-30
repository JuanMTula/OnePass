<?php

namespace App\Http\Controllers;

use App\content;
use App\claves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Crypt;

class categoriasController extends Controller
{
    const imagesArray = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15'];
    const colorArray  = ['primary','success','info','warning','danger'];

    public function listaConClaves(){

       $lista = content::where('content_usr_id', session('user_id'))
                       ->with('claves')
                       ->select('content_id as categoria_id',
                           'content_label as categoria_titulo',
                           'content_icono as categoria_icono')
                       ->get();

       $lista = $lista->map(function ($item) {
           foreach ($item['claves'] as $clave){
               $clave['claves_clave']  = Crypt::decrypt($clave['claves_clave']);
               $clave['claves_color']  = Crypt::decrypt($clave['claves_color']);
               $clave['claves_cuenta'] = Crypt::decrypt($clave['claves_cuenta']);
               $clave['claves_tel']    = Crypt::decrypt($clave['claves_tel']);
               $clave['claves_texto']  = Crypt::decrypt($clave['claves_texto']);
               $clave['claves_tipo']   = Crypt::decrypt($clave['claves_tipo']);
               $clave['claves_titulo'] = Crypt::decrypt($clave['claves_titulo']);
               $clave['claves_url']    = Crypt::decrypt($clave['claves_url']);
           }
            return $item ;
       });

       content::jsonResponse($lista);
    }

    public function modificar(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // id
        $toValidate['fields']['id']     = $request['id'];
        $toValidate['constrains']['id'] = 'required|integer|exists:content,content_id';

        // nombre
        $toValidate['fields']['nombre']     = $request['nombre'];
        $toValidate['constrains']['nombre'] = 'required|string|min:1';

        // tipo
        $toValidate['fields']['tipo']     = $request['tipo'];
        $toValidate['constrains']['tipo'] = 'required|in:'.implode(',', self::imagesArray);

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
            ->update(['content_label'=>$request['nombre'],'content_icono'=>$request['tipo']]);

        if($categria)
            content::returnSuccessAsObject('Categoria modificada');
        else
            content::returnErrorAsObject('Error modificando categoria');
    }

    public function crear(Request $request){

        // validate
        $toValidate = [
            'fields'     => [],
            'constrains' => []
        ];

        // detalle
        $toValidate['fields']['nombre']     = $request['nombre'];
        $toValidate['constrains']['nombre'] = 'required|string|min:1';

        // tipo
        $toValidate['fields']['tipo']     = $request['tipo'];
        $toValidate['constrains']['tipo'] = 'required|in:'.implode(',', self::imagesArray);

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
        $categoria->content_icono = $request['tipo'];

        if($categoria->save())
             content::returnSuccessAsObject('Categoria creada');
        else
             content::returnErrorAsObject('Error creando categoria');

    }

    public function borrar(Request $request){

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
}
