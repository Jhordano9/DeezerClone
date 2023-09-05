<?php

namespace App\Http\Resources;

use App\Models\ClientServiceGroupProduct;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use PHPUnit\Framework\Constraint\IsTrue;
use Illuminate\Support\Facades\DB;

class ArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        return [
            "id" => $this->artist_id, 
			"name" => $this->artist_name.' '.$this->artist_lastname, 
            "link" =>  $this->artist_link,
            "share" => $this->artist_share_link, 
            "picture" => $this->artist_picture ? $this->artist_picture : 'No picture', 
            "picture_small" => $this->artist_picture_small ? $this->artist_picture_small : 'No small picture',
            "picture_medium" => $this->artist_picture_medium ? $this->artist_picture_medium : 'No medium picture',
            "picture_big" => $this->artist_picture_big ? $this->artist_picture_big : 'No big picture',
            "picture_xl" => $this->artist_picture_xl ? $this->artist_picture_xl : 'No xl picture',
            "nb_album" => $this->artist_nro_albums,
            "nb_fan" => $this->artist_nro_fans,
            'radio' => $this->artist_radio,
            "tracklist" => $this->artist_track_list,
            "type" => $this->type_description
        ];
    }
}