<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetInfoResource extends JsonResource
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
            'age'       => $this->age,
            'gender'    => $this->gender,
            'breed'     => $this->breed,
            'image'     =>  $this->image?asset('public/storage/'.$this->image):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
            'pedigree'  =>  $this->pedigree?asset('public/storage/'.$this->pedigree):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
            'characteristics' => json_decode($this->characteristics),
        ];
    }
}
