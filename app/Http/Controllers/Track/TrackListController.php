<?php

namespace App\Http\Controllers\Track;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrackResource;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class TrackListController extends Controller
{
    public function list(Request $request){

        try{
            
            $aData = $request->all();
            dd($aData);
            $query = DB::table('tb_tracks')
                        ->leftJoin('tb_artist','tb_tracks.track_artist_id','=','tb_artist.artist_id')
                        ->leftJoin('tb_albums','tb_albums.album_artist_id','=','tb_artist.artist_id');

            if($aData['q'] != ''){
                $query->where('artist_name','ilike','%'.$aData['q'].'%');
            }

            $track = $query->paginate(30);

            TrackResource::collection($track);

            return response()->json(["aData" =>  $track]);

        }catch(Exception $ex){
            return response()->json(["sMessage" =>  $ex->getMessage()], 500);
        }

    }

}