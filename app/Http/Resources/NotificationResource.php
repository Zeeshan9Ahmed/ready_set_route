<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'=>$this->id,
            'title'=>$this->title??"",
            'notification_type'=>$this->notification_type??"",
            'data'=>$this->data?json_decode($this->data):new \stdClass(),
            'date'=>$this->created_at->diffForHumans(),
            'sender'=>$this->sender?[
                "id"=>$this->sender->id,
                'first_name'=>$this->sender->first_name,
                'last_name'=>$this->sender->last_name??"",
                'image'=>$this->sender->image?asset('public/uploads/avatars/'.$this->sender->image):null,
            ]:[
                "id"    =>  0,
                'first_name'  =>  'Flip Side',
                'last_name' =>'',
                'image' =>  '',
            ]
        ];
    }
}
