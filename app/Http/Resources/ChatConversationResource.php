<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'type' => $this->type,
            'last_message'=> $this->lastMessage?new ChatMessageResource($this->lastMessage):new \stdClass(),
            'participants' => ChatParticipantResource::collection($this->participants),
            'messages' => ChatMessageResource::collection($this->whenLoaded('messages')),
            'ad'=>$this->whenLoaded('ad',new AdInfoResource($this->ad))
        ];
    }
}
