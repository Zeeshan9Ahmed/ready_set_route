<?php

namespace App\Listeners;

use App\Events\MeetupRequestAdded;
use App\Http\Resources\MeetupRequestResource;
use App\Http\Resources\SearchFriendResourse;
use App\Models\MeetupRequest;
use App\Services\Notification\CreateDBNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Notification\PushNotificationService;
class MeetupRequestAddedListener
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
    public function handle(MeetupRequestAdded $event)
    {
        $tokens =[];
        $meetup_requests = MeetupRequest::with('member')->where('meetup_id',$event->meetup->id)->where('status','pending')->get();
        foreach ($meetup_requests as $meetup_request){
            $member = $meetup_request->member;
            if($member && $member->id != auth()->user()->id){
                $tokens[] = $member->device_token;
                $data = [
                    'to_user_id'        =>  $member->id,
                    'from_user_id'      =>  auth()->user()->id,
                    'notification_type' =>  'FOOD_MEETUP_REQUEST',
                    'title'             =>  'Food meetup request',
                    'data'              => (new MeetupRequestResource($meetup_request))->jsonSerialize()
                ];
                $notification = app(CreateDBNotification::class)->execute($data);
            }
        }

        $send_push = app(PushNotificationService::class)->execute([
            'to_user_id'        =>  0,
            'from_user_id'      =>  auth()->user()->id,
            'notification_type' =>  'FOOD_MEETUP_REQUEST',
            'title'             =>  'Food meetup request from '.auth()->user()->first_name,
        ],$tokens);
    }
}
