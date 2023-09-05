<?php

namespace App\Http\Controllers\Album;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class AlbumListController extends Controller
{
    public function list(Request $request, $id = null){

        try{
            
            $aData = $request->all();

            $query = DB::table('tb_albums')
                        ->leftJoin('tb_types','tb_types.type_id','=','tb_albums.album_record_type_id');

            if($id){
                $query->where('album_id',$id);
            }

            $albums = $query->paginate(30);

            AlbumsResource::collection($albums);

            return response()->json(["aData" =>  $albums]);

        }catch(Exception $ex){
            return response()->json(["sMessage" =>  $ex->getMessage()], 500);
        }

    }

}