<?php


namespace App\Services\Conversation;


use App\Models\Conversation;
use App\Services\BaseService;

class CreateConversation extends BaseService
{


    public function rules()
    {
        return [
            'type' => 'required',
            'participants' => 'required|array'
        ];
    }

    public function execute($data){
        $conversation = Conversation::create([
            'type' => $data['type']
        ]);
        if(isset($data['participants'])){
            $conversation->participants()->syncWithoutDetaching($data['participants']);
        }
        return $conversation;
    }

}
