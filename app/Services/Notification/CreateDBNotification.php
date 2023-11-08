<?php


namespace App\Services\Notification;


use App\Models\Notification;
use App\Services\BaseService;

class CreateDBNotification extends BaseService
{


    public function rules()
    {
        return [
            'to_user_id' => 'required',
            'title' => 'required',
            'data' => 'required|array',
        ];
    }

    public function execute($data){
        Notification::create([
            'from_user_id' => $this->nullOrValue($data,'from_user_id'),
            'to_user_id' => $data['to_user_id'],
            'title' => $data['title'],
            'notification_type' => $this->nullOrValue($data,'notification_type'),
            'data'=>json_encode($data['data'])
        ]);
    }

}
