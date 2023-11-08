<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInUser extends JsonResource
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
            'first_name'              =>$this->first_name??"",
            'last_name'              =>$this->last_name??"",
            'email'             =>$this->email??"",
            'phone_no'          =>$this->phone_no??"",
            'image'             =>$this->image?asset('public/storage/'.$this->image):"",
            'is_verified'       =>$this->email_verified_at?1:0,
            'profile_completed'=>$this->profile_completed,
        ];
    }
}
