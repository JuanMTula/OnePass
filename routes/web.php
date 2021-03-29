<?php

// Home Page



    Route::get('/requerimientos', 'LoginController@requerimientos')->name('requerimientos');

// Home & Login

    Route::get('/', 'LoginController@home')->name('home');
    Route::get('/newregist', 'LoginController@newregist')->name('newregist');
    Route::get('/login', 'LoginController@login')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/checkSession', 'LoginController@checkSession')->name('checkSession');

    Route::group(['middleware' => ['isLoggued']], function () {

        // Content
        Route::get('/categorias', 'contentController@categorias')->name('categorias');
        Route::post('/modificarcategoria', 'contentController@modificarcategoria')->name('modificarcategoria');
        Route::post('/crearcategoria', 'contentController@crearcategoria')->name('crearcategoria');
        Route::post('/borrarcategoria', 'contentController@borrarcategoria')->name('borrarcategoria');

        Route::post('/modificarclave', 'contentController@modificarclave')->name('modificarclave');
        Route::post('/borrarclave', 'contentController@borrarclave')->name('borrarclave');
        Route::post('/crearclave', 'contentController@crearclave')->name('crearclave');



        // Claves
        Route::get('/getcontentclaves', 'contentController@getcontentclaves')->name('getcontentclaves');
        Route::get('/modifcontentclaves', 'contentController@modifcontentclaves')->name('modifcontentclaves');

    });

