<?php

namespace App\Http\Controllers\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArtistController extends Controller
{
    public function create(Request $request){

        try{
            
            $aData = $request->all();

            $validator = Validator::make($aData, [
                'sNombre' => 'required|string',
                'sApellido' => 'required|string',
                'sRadio' => 'required|string',
                'sType' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                throw new Exception(implode(' ', $errors));
            }

            //CREAMOS EL NUEVO ARTISTA
            DB::table('tb_artist')->insertGetId([
                'artist_name' => $aData['sNombre'],
                'artist_last_name' => $aData['sApellido'],
                'artist_radio' => $aData['sRadio'],
                'artist_type_id' => $aData['sType'],
            ], 'artist_id');

            DB::commit();

            return response()->json(["sMensaje" => "Se creó el artista correctamente."], 200);

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