<?php
    // RUTAS TRACKS
    Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1/track'], function () {

        //LISTAR TRACK O TODOS LOS TRACKS
        Route::get('/search', 'Track\TrackListController@list');

        //CREAR TRACK NUEVO
        Route::post('/create', 'Track\TrackController@create');
        //EDITAR TRACK
        Route::put('/{nIdTrack}/update', 'Track\TrackController@update');
        //BORRAR TRACK
        Route::delete('/{nIdTrack}/delete', 'Track\TrackController@delete');

    }); 