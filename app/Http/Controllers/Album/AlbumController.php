<?php

namespace App\Http\Controllers\Album;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    public function create(Request $request){

        try{

            $aData = $request->all();

            $validator = Validator::make($aData, [
                'sAlbumTitle' => 'required|string',
                'sAlbumLabel' => 'required|string',
                'sType' => 'required|numeric',
                'sGenre' => 'required|string',
                'sArtist' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                throw new Exception(implode(' ', $errors));
            }

            //CREAMOS EL NUEVO ALBUM
            DB::table('tb_albums')->insertGetId([
                'album_title' => $aData['sAlbumTitle'],
                'album_label' => $aData['sAlbumLabel'],
                'album_record_type_id' => $aData['sType'],
                'album_genre_id' => $aData['sGenre'],
                'album_artist_id' => $aData['sArtist'],
            ], 'album_id');

            DB::commit();

            return response()->json(["sMensaje" => "Se creó el albúm correctamente."], 200);

        }catch(Exception $ex){
            DB::rollBack();
            return response()->json(["sMessage" =>  $ex->getMessage()], 500);
        }

    }

    public function update(Request $request, $id){

    }

    public function delete(Request $request, $id){
        
    }

}