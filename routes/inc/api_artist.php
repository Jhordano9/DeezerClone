<?php
    // RUTAS ARTISTAS
    Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1/artist'], function () {

        //LISTAR ARTISTA O TODOS LOS ARTISTAS
        Route::get('/', 'Artist\ArtistListController@list');
        Route::get('/{nIdArtist}', 'Artist\ArtistListController@list');

        //CREAR ARTISTA NUEVO
        Route::post('/create', 'Artist\ArtistController@create');
        //EDITAR ARTISTA
        Route::put('/{nIdArtist}/update', 'Artist\ArtistController@update');
        //BORRAR ARTISTA
        Route::delete('/{nIdArtist}/delete', 'Artist\ArtistController@delete');

    }); 