<?php

namespace App\Http\Controllers\Artist;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistResource;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class ArtistListController extends Controller
{
    public function list(Request $request, $id = null){

        try{
            
            $aData = $request->all();

            $query = DB::table('tb_artist')
                        ->leftJoin('tb_types','tb_types.type_id','=','tb_artist.artist_type_id');

            if($id){
                $query->where('artist_id',$id);
            }

            $artist = $query->paginate(30);

            ArtistResource::collection($artist);

            return response()->json(["aData" =>  $artist]);

        }catch(Exception $ex){
            return response()->json(["sMessage" =>  $ex->getMessage()], 500);
        }

    }

}