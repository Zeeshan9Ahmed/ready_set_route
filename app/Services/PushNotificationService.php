<?php


namespace App\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PushNotificationService
{


    public static function sendNotification($data, $token,$message)
    {
        $date = Carbon::now();
        $header = [
            'Authorization: key= AAAAQBuqWPQ:APA91bEeRYI7SmhNW8Lc8pmI1Vae00VmytPDeWqFssiGTUqpX9MhoRAR0lI72tJKJ83aBu3FAAa22bz82lHzYtwfreDKe_uoM6irUuGsF8Iv3t49CB64kmYKtT2zAiy9lAruPiWaDFjW',
            'Content-Type: Application/json'
        ];
        $notification = [
            'title' => 'Raffish',
            'body' =>  $message,
            'icon' => '',
            'image' => '',
            'sound' => 'default',
            'date' => $date->diffForHumans(),
            'content_available' => true,
            "priority" => "high",
            'badge' =>0
//            'badge' => $data['badge_count']
        ];
        if (gettype($token) == 'array') {
            $payload = [
                'registration_ids' => $token,
                'data' => (object)$data,
                'notification' => (object)$notification
            ];
        } else {
            $payload = [
                'to' => $token,
                'data' => (object)$data,
                'notification' => (object)$notification
            ];
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $header
        ));
        $response = curl_exec($curl);
        $d  =[ 'res'=>$response,'data'=>$data];
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
