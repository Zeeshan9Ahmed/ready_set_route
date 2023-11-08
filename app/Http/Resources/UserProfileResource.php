<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'id'                =>$this->id,
            'name'              =>$this->name??"",
            'email'             =>$this->email??"",
            'address'           =>$this->address??"",
            'image'             =>$this->image?asset('public/storage/'.$this->image):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
            'pets' => $this->whenLoaded('pets',PetResource::collection($this->pets)),
        ];
    }
}
