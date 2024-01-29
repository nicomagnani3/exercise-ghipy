<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class Gif extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gif_id' => $this->gif_id,
            'alias' => $this->alias,
            'user' => [
                $this->user,            
            ],
            'giphy_info' => $this->when($this->giphy_info, $this->giphy_info),
        ];
    }
}
