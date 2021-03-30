<?php

    // Home
    Route::get('/', 'LoginController@home')->name('home');

    // Registro
    Route::post('/nuevoUsuario', 'LoginController@nuevoUsuario')->name('nuevoUsuario');
    Route::get('/login', 'LoginController@login')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');


    Route::group(['middleware' => ['isLoggued']], function () {

        // Landing
        Route::get('/lista', 'categoriasController@listaConClaves')->name('lista');

        // Categorias
        Route::post('/categorias/modificar', 'categoriasController@modificar')->name('modificarCategoria');
        Route::post('/categorias/crear', 'categoriasController@crear')->name('crearCategoria');
        Route::post('/categorias/borrar', 'categoriasController@borrar')->name('borrarCategoria');

        // Claves
        Route::post('/claves/modificar', 'clavesController@modificar')->name('modificarClave');
        Route::post('/claves/borrar', 'clavesController@borrar')->name('borrarClave');
        Route::post('/claves/crear', 'clavesController@crear')->name('crearClave');

    });

