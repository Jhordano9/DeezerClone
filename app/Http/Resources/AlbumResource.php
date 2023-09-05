<?php

namespace App\Http\Resources;

use App\Models\ClientServiceGroupProduct;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\IsTrue;
use Illuminate\Support\Facades\DB;

class AlbumsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $genres = DB::table('tb_genres')
                    ->where('genre_id',$this->album_genre_id)
                    ->select('genre_id as id','genre_name as name','genre_picture as picture','genre_type as type')
                    ->first();

        return [
            "id" => $this->album_id, 
			"title" => $this->album_title, 
            "upc" => $this->album_code,
            "link" =>  $this->album_link,
            "share" => $this->album_share_link, 
            "cover" => $this->album_cover, 
            "cover_small" => $this->album_cover_small ? $this->album_cover_small : 'No small cover',
            "cover_medium" => $this->album_cover_medium ? $this->album_cover_medium : 'No medium cover',
            "cover_big" => $this->album_cover_big ? $this->album_cover_big : 'No big cover',
            "cover_xl" => $this->album_cover_xl ? $this->album_cover_xl : 'No xl cover',
            "md5_image" => $this->album_md5_image ? $this->album_md5_image : 'No md5 image avaible',
            "genre_id" => $this->album_genre_id,
            "genres" => ["data" => $genres],
            "label" => $this->album_name,
            'nb_tracks' => $this->album_nro_tracks,
            'duration' => $this->album_duration,
            'fans' => $this->album_fans_number,
            'release_date' => $this->album_realease_date,
            'record_type' => $this->type_description,
            'avaible' => $this->album_status
        ];
    }
}