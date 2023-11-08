<?php

namespace App\Listeners;

use App\Events\NotifyReceipient;
use App\Http\Resources\SearchFriendResourse;
use App\Services\Notification\CreateDBNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Notification\PushNotificationService;
class NotifyReceipientListener
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
    public function handle(NotifyReceipient $event)
    {

        $data = [
            'to_user_id'        =>  $event->recepient->id,
            'from_user_id'      =>  $event->sender->id,
            'notification_type' =>  'FRIEND_REQUEST',
            'title'             =>  $event->sender->first_name ." sent you a friend request",
            'data'              => (new SearchFriendResourse($event->recepient))->jsonSerialize()
        ];
        $notification = app(CreateDBNotification::class)->execute($data);
        $send_push = app(PushNotificationService::class)->execute($data,[$event->recepient->device_token]);

    }
}
