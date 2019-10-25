<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Crypt;

class contentController extends Controller
{
    
    public function borrarcategoriacontent(){
    
    $usuario = session('user_id');
    $id=request('id');
    
    $resp = new \App\stdclass;
    
    $cont = DB::table('content')->where('content_usr_id', $usuario )->where('content_id', $id)->get();
    
    if(count($cont) == 1){
        
        $deletedRows = \App\content::where('content_id', $id)->delete();
        
        if($deletedRows){
            
            $xres = \App\claves::where('claves_contid', $id)->delete();
            
            $resp->mensaje="Categoria borrada.";
            $resp->valido=1;
            return $resp;
        
        }else{
            
            $resp->mensaje="No se ha podido categoria.";
            $resp->valido=0;
            
            return $resp;
            
        }
        
    }else{
        
        $resp->mensaje="No se puede encontrar categoria.";
        $resp->valido=0;
        
        return $resp;
        
    }
    

    $resp->mensaje = "Fuera de rango al intentar borrar categoria.";
    $resp->valido = 0;
    return $resp;
    
    
    }
    
    public function crearcategoriacontent(){
    
    $usuario = session('user_id');
    $nombre=request('nombre');
    $icono=request('icono');
    
    $resp = new \App\stdclass;
    
    $cont = DB::table('content')->where('content_usr_id', session(['user_id']) )->where('content_label', $nombre)->get();
    
    if(count($cont) != 0){
        
        $resp->mensaje="Ya existe una categoria con ese nombre, use otro.";
        $resp->valido=0;
        return $resp;
        
    }
    
    $content = new \App\content;
        
    $content->content_usr_id=$usuario;
    $content->content_label=$nombre;
    $content->content_icono=$icono;
        
    $xres = $content->save();
    
    if ($xres){

        $resp->mensaje = "Categoria creada.";
        $resp->valido = 1;
        $resp->nombre = $nombre;
        $resp->icono = $icono;
        
        return $resp;
        
    }else{
        
        $resp->mensaje="No se puede crear categoria.";
        $resp->valido=0;
        
        return $resp;
        
    }
    
    $resp->mensaje = "Fuera de rango al intentar crear categoria.";
    $resp->valido = 0;
    return $resp;
    
    
    }
    
    public function modificarcategoriacontent(){
    
    $usuario = session('user_id');
    $nombre=request('nombre');
    $icono=request('icono');
    $id=request('id');
    
    $resp = new \App\stdclass;
    
    $cont = DB::table('content')->where('content_usr_id', session(['user_id']) )->where('content_label', $nombre)->get();
    
    if(count($cont) != 0){
        
        $resp->mensaje="Ya existe una categoria con ese nombre, use otro.";
        $resp->valido=0;
        return $resp;
        
    }
    
    $xres= \App\content::where('content_id', $id)
                     ->update(['content_label' => $nombre,
                               'content_icono' => $icono ]);
    
    
    
    if ($xres){

        $resp->mensaje = "Categoria modificada.";
        $resp->valido = 1;
        $resp->nombre = $nombre;
        $resp->icono = $icono;
        
        return $resp;
        
    }else{
        
        $resp->mensaje="No se puede modificar categoria.";
        $resp->valido=0;
        
        return $resp;
        
    }
    
    $resp->mensaje = "Fuera de rango al intentar modificar categoria.";
    $resp->valido = 0;
    return $resp;
    
    
    }
    
    public function getfullcontent(){
        
        $value = session('status');
        $res = new \App\stdclass;
    
        if($value == 1){
             
            $usrID = session('user_id');
             
            $contenido = DB::table('content')
                            ->where('content_usr_id', $usrID)
                            ->select('content_id as id_etiq','content_label as texto_etiq','content_icono as icono_etiq')
                            ->get();
         

            
        if(count($contenido) == 0){
            $res->mensaje="No hay categorias creadas, cree una.";
            $res->valido=2;
            return $res;
        }

        if(count($contenido) >= 1){
            $res->contenido=$contenido;
            $res->mensaje="Enviando datos.";
            $res->valido=1;
            return $res;
        }
            
             
            
        
        }else{
            
            $res->mensaje="No se pueden enviar datos.";
            $res->valido=0;
            return $res;
  
            
        }
        
    }
    
    public function getcontent(){
        
        $value = session('status');
        
        $resp = new \App\stdclass;
        
        if($value == 1){
             
            $usrID = session('user_id');
             
            $categoria = DB::table('content')
                            ->where('content_usr_id', $usrID)
                            ->where('content_id', request('content_id'))
                            ->get();
            
            if(count($categoria) == 0){
                $resp->mensaje='La categoria no existe.';
                $resp->valido=0;
                return $resp;
            }
            
            $resp->nombre = $categoria[0]->content_label;
            $resp->icono = $categoria[0]->content_icono;
            
            $claves = DB::table('claves')
                        ->where('claves_contid', $categoria[0]->content_id)
                        ->select('claves_id as id','claves_titulo as titulo')
                        ->get();
            
            
            foreach ($claves as $key => $clave) {
          
              
               $claves[$key]->titulo = Crypt::decrypt($claves[$key]->titulo);
            } 
            
            
            
            
            $resp->claves = $claves;
            
            return $resp;
            
        }else{
            
            $resp->mensaje='No hay session iniciada.';
            $resp->valido=0;
            return $resp;
            
        }
        
    }
    
    public function getcontentclaves(){
        
        $value = session('status');
        
        $resp = new \App\stdclass;
        
        if($value == 1){
             
            $usrID = session('user_id');
             
            $clave = DB::table('claves')
                        ->where('claves_id', request('clave'))
                        ->get();
                        
            if(count($clave) != 1){                
                $resp->mensaje='No se puede encontrar la clave.';
                $resp->valido=0;
                return $resp;    
            }
            
            $categoria = DB::table('content')
                            ->where('content_id', $clave[0]->claves_contid)
                            ->get();
            
            if(count($categoria) != 1){                
                $resp->mensaje='No se puede encontrar la categoria.';
                $resp->valido=0;
                return $resp;    
            }

            if($categoria[0]->content_usr_id != $usrID){                
                $resp->mensaje='La clave no pertenece al usuario.';
                $resp->valido=0;
                return $resp;    
            }


            $clave = DB::table('claves')
                        ->where('claves_id', request('clave'))
                        ->select('claves_titulo as titulo','claves_texto as texto','claves_tipo as tipo','claves_url as url','claves_tel as tel','claves_cuenta as cuenta','claves_clave as clave')
                        ->get();
            
            
            $clave[0]->titulo = Crypt::decrypt($clave[0]->titulo);
            $clave[0]->texto = Crypt::decrypt($clave[0]->texto);
            $clave[0]->tipo = Crypt::decrypt($clave[0]->tipo);
            $clave[0]->url = Crypt::decrypt($clave[0]->url);
            $clave[0]->tel = Crypt::decrypt($clave[0]->tel);
            $clave[0]->cuenta = Crypt::decrypt($clave[0]->cuenta);
            $clave[0]->clave = Crypt::decrypt($clave[0]->clave);
            
            
            $resp->claves = $clave[0];
            $resp->mensaje='Entrgando datos.';
            $resp->valido=1;
            return $resp;
            
        }else{
            
            $resp->mensaje='No hay sesion iniciada.';
            $resp->valido=0;
            return $resp;
            
        }
        
    }
    
    public function modifcontentclaves(){
        
        $value = session('status');
        
        $resp = new \App\stdclass;

        if($value == 1){
             
            $usrID = session('user_id');
            
            if(request('titulo') == ''){                
                $resp->mensaje='El campo de titulo no puede estar vacio.';
                $resp->valido=0;
                return $resp;    
            }
             
            $clave = DB::table('claves')
                        ->where('claves_id', request('id'))
                        ->get();
                        
            if(count($clave) != 1){                
                $resp->mensaje='No se puede encontrar la clave.';
                $resp->valido=0;
                return $resp;    
            }
            
            $categoria = DB::table('content')
                            ->where('content_id', $clave[0]->claves_contid)
                            ->get();
            
            if(count($categoria) != 1){                
                $resp->mensaje='No se puede encontrar la categoria.';
                $resp->valido=0;
                return $resp;    
            }

            if($categoria[0]->content_usr_id != $usrID){                
                $resp->mensaje='La clave no pertenece al usuario.';
                $resp->valido=0;
                return $resp;    
            }


            $xres = \App\claves::where('claves_id', request('id'))
                                ->update(['claves_titulo' => Crypt::encrypt(request('titulo')),
                                          'claves_texto' => Crypt::encrypt(request('texto')),
                                          'claves_tipo' => Crypt::encrypt(request('tipo')),
                                          'claves_url' => Crypt::encrypt(request('url')),
                                          'claves_tel' => Crypt::encrypt(request('tel')),
                                          'claves_cuenta' => Crypt::encrypt(request('cuenta')),
                                          'claves_clave' => Crypt::encrypt(request('clave'))]);
                          
            if ($xres){
                    
                    $resp->mensaje='Clave modificada.';
                    $resp->valido=1;
                    return $resp;
                    
            }else{
                
                $resp->mensaje="No se puede modificar categoria.";
                $resp->valido=0;
                return $resp;
                
            }    
                
    
        }else{
            
            $resp->mensaje='No hay sesion iniciada.';
            $resp->valido=0;
            return $resp;
            
        }
        
    }
    
    public function borrarclave(){
        
        $value = session('status');
        
        $resp = new \App\stdclass;

        if($value == 1){
             
            $usrID = session('user_id');
             
            $clave = DB::table('claves')
                        ->where('claves_id', request('id'))
                        ->get();
                        
            if(count($clave) != 1){                
                $resp->mensaje='No se puede encontrar la clave.';
                $resp->valido=0;
                return $resp;    
            }
            
            $categoria = DB::table('content')
                            ->where('content_id', $clave[0]->claves_contid)
                            ->get();
            
            if(count($categoria) != 1){                
                $resp->mensaje='No se puede encontrar la categoria.';
                $resp->valido=0;
                return $resp;    
            }

            if($categoria[0]->content_usr_id != $usrID){                
                $resp->mensaje='La clave no pertenece al usuario.';
                $resp->valido=0;
                return $resp;    
            }

            $xres = \App\claves::where('claves_id', request('id'))->delete();
               
            if ($xres){
                    
                $resp->mensaje='Clave borrada.';
                $resp->valido=1;
                return $resp;
                    
            }else{
                
                $resp->mensaje="No se puede borrar la clave.";
                $resp->valido=0;
                return $resp;
                
            }    
                
    
        }else{
            
            $resp->mensaje='No hay sesion iniciada.';
            $resp->valido=0;
            return $resp;
            
        }
        
    }
    
    public function crearclave(){
    
    $usuario = session('user_id');
    
    $cont = DB::table('content')->where('content_usr_id', $usuario )->get();
   
    $resp = new \App\stdclass;
    
    if(count($cont) == 0){
        
        $resp->mensaje="La categoria no es propiedad del usuario.";
        $resp->valido=0;
        
        return $resp;
        
    }

    if( request('titulo') == ''){
        
        $resp->mensaje="El campo Titulo no puede estar vacio.";
        $resp->valido=0;
        return $resp;
        
    }
    if( request('categoria') <= 0){
        
        $resp->mensaje="La categoria no esta definida.";
        $resp->valido=0;
        return $resp;
        
    }

    $claves = new \App\claves;

    $claves->claves_contid = request('categoria');
    $claves->claves_titulo = Crypt::encrypt(request('titulo'));
    $claves->claves_texto = Crypt::encrypt(request('texto'));
    $claves->claves_tipo = Crypt::encrypt(request('tipo'));
    $claves->claves_url = Crypt::encrypt(request('url'));
    $claves->claves_tel = Crypt::encrypt(request('tel'));
    $claves->claves_cuenta = Crypt::encrypt(request('cuenta'));
    $claves->claves_clave = Crypt::encrypt(request('clave'));
        
    $xres = $claves->save();
    
    if ($xres){

        $resp->mensaje = "Clave creada.";
        $resp->valido = 1;
    
        return $resp;
        
    }else{
        
        $resp->mensaje="No se puede crear clave.";
        $resp->valido=0;
        
        return $resp;
        
    }
    
    $resp->mensaje = "Fuera de rango al intentar crear clave.";
    $resp->valido = 0;
    return $resp;
    
    
    }
    
    
}
