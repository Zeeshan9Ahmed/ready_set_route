<?php

namespace App\Listeners;

use App\Events\FriendRequestUpdated;
use App\Http\Resources\SearchFriendResourse;
use App\Models\Notification;
use App\Services\Notification\CreateDBNotification;
use App\Services\Notification\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FriendRequestUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FriendRequestUpdated $event)
    {
        
        $title = $event->sender->first_name." accepted your friend request";
        $type = "FRIEND_REQUEST_ACCEPTED";
        $get_friendship_status = $event->recepient->getFriendShipStatus($event->sender);
         if($get_friendship_status === 'REQUEST_DENIED'){
             $title = $event->sender->first_name." rejected your friend request";
             $type = "FRIEND_REQUEST_REJECTED";
         }
        $data = [
            'to_user_id'        =>  $event->recepient->id,
            'from_user_id'      =>  $event->sender->id,
            'notification_type' =>  $type,
            'title'             =>  $title,
            'data'              => (new SearchFriendResourse($event->recepient))->jsonSerialize()
        ];
        $notification = app(CreateDBNotification::class)->execute($data);
        //delete friend request notification
        Notification::where('notification_type','FRIEND_REQUEST')->where(function($q) use($event){
            $q->where('to_user_id',$event->recepient->id)->where('from_user_id',$event->sender->id);
        })->orWhere(function($q) use($event){
            $q->where('to_user_id',$event->sender->id)->where('from_user_id',$event->recepient->id);
        })->delete();
        $send_push = app(PushNotificationService::class)->execute($data,[$event->recepient->device_token]);
    }
}
