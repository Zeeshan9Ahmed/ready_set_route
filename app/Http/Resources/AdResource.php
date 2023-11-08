<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                =>      $this->id,
            'is_favourite'      =>      $this->favourites_count,
            'category'          =>      $this->category??"",
            'skills'            =>      json_decode($this->skills),
            'characteristics'   =>      json_decode($this->characteristics),
            'pet' => $this->whenLoaded('pet',new PetResource($this->pet)),
            'user' => $this->whenLoaded('user' , new UserResource($this->user)),
            'date' => $this->created_at,
        ];
    }
}
