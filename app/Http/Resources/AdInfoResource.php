<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdInfoResource extends JsonResource
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
            'category'          =>      $this->category??"",
            'skills'            =>      json_decode($this->skills),
            'characteristics'   =>      json_decode($this->characteristics),
            'pet' => $this->whenLoaded('pet',new PetInfoResource($this->pet)),
        ];
    }
}
