<?php

namespace App\Listeners;

use App\Events\NewDeliveryBookingConfirmed;
use App\Http\Resources\BookingDetailResource;
use App\Models\Notification;
use App\Services\GetNearBy;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewDeliveryBookingConfirmedListener
{

    public $booking;
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
    public function handle(NewDeliveryBookingConfirmed $event)
    {
        $booking = $event->booking;
        $pickups  = $booking->pickups;
        if(count($pickups)){
            $payload_data= new BookingDetailResource($booking);
            $payload_data =  json_encode($payload_data->jsonSerialize());
            $pickups = $pickups[0];
            $near_by_riders = GetNearBy::getNearByUsers($pickups->pickup_lat,$pickups->pickup_long)->get();
            $notification_service = new PushNotificationService();
            $data['data']=$payload_data;
            $data['notification_type'] = 'NEW_BOOKING';
            $data['model_type_id'] = $booking->id;
            $data['click_action'] = '';
            $data['message'] = 'New Booking';
            $data['title'] = 'Gentleman Journey';
            $data['badge_count'] = 1;
            foreach ($near_by_riders as $rider){
                $notification = new Notification();
                $notification->from_user_id = $booking->user_id;
                $notification->to_user_id = $rider->id;
                $notification->model_type_id = $booking->id;
                $notification->notification_type = 'NEW_BOOKING';
                $notification->data = $payload_data;
                $notification->save();
            }
            $send = $notification_service->sendNotification($data,$near_by_riders->pluck('device_token')->toArray(),'Gentleman Journey');
        }


    }
}
