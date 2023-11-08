<?php

namespace App\Jobs;

use App\Models\Raffle;
use App\Models\User;
use App\Services\PushNotificationService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyRaffleParticipants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $raffle;
    public $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($raffle , $message)
    {
        $this->raffle = $raffle;
        $this->message = $message;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $now= Carbon::now('UTC');
        if(
//            $now->gte(Carbon::parse($this->raffle->end_date))&&
            $this->raffle->status == Raffle::RAFFLE_ACTIVE && $this->raffle->winner_id==null){
            $participants  = $this->raffle->participants()->get()->pluck('device_token')->toArray();
            if(count($participants)){

                $notification = PushNotificationService::sendNotification([
                    'id'=>$this->raffle->id,
                    'title'=>$this->raffle->title,
                    'end_date'=>$this->raffle->end_date,
                ], $participants,$this->message);
            }
        }
    }
}
