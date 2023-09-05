<?php
    // RUTAS ALBUMS
    Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1/album'], function () {

        //LISTAR ALBUM O TODOS LOS ALBUMS
        Route::get('/', 'Album\AlbumListController@list');
        Route::get('/{nIdAlbum}', 'Album\AlbumListController@list');

        //CREAR ALBUM NUEVO
        Route::post('/create', 'Album\AlbumController@create');
        //EDITAR ALBUM
        Route::put('/{nIdAlbum}/update', 'Album\AlbumController@update');
        //BORRAR ALBUM
        Route::delete('/{nIdAlbum}/delete', 'Album\AlbumController@delete');

    }); 