<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page

    Route::get('/', function () {
        
        
    //requerimentos
    if(true){

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

        }
        
        return view('home');
        
    })->name('home');


// Login

    Route::get('/newregist', 'LoginController@newregist')->name('newregist');
    Route::get('/setsession', 'LoginController@setsession')->name('setsession');
    Route::get('/login', 'LoginController@login')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');

// Content

    Route::get('/getfullcontent', 'contentController@getfullcontent')->name('getfullcontent');
    Route::get('/getcontent', 'contentController@getcontent')->name('getcontent');
    Route::get('/crearcategoriacontent', 'contentController@crearcategoriacontent')->name('crearcategoriacontent');
    Route::get('/modificarcategoriacontent', 'contentController@modificarcategoriacontent')->name('modificarcategoriacontent');
    Route::get('/borrarcategoriacontent', 'contentController@borrarcategoriacontent')->name('borrarcategoriacontent');

//claves    
    Route::get('/getcontentclaves', 'contentController@getcontentclaves')->name('getcontentclaves');
    Route::get('/crearclave', 'contentController@crearclave')->name('crearclave');
    Route::get('/modifcontentclaves', 'contentController@modifcontentclaves')->name('modifcontentclaves');
    Route::get('/borrarclave', 'contentController@borrarclave')->name('borrarclave');
    
    
    
    
