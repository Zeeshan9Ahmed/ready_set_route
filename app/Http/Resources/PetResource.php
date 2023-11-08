<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name??"",
            'age'       => $this->age,
            'gender'    => $this->gender,
            'breed'     => $this->breed,
            'bio'     => $this->bio??"",
            'description'     => $this->description??"",
            'image'     =>  $this->image?asset('public/storage/'.$this->image):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
            'pedigree'  =>  $this->pedigree?asset('public/storage/'.$this->pedigree):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
            'characteristics' => json_decode($this->characteristics),
            'profile_visibility' => $this->profile_visibility,
            'media'=>$this->whenLoaded('media',MediaResource::collection($this->media))
        ];
    }
}
