<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'id'    => $this->id,
            'type'  => $this->type,
            'name'  =>$this->name?asset('public/storage/'.$this->name):'https://cdn.pixabay.com/photo/2016/05/05/02/37/sunset-1373171__340.jpg',
        ];
    }
}
