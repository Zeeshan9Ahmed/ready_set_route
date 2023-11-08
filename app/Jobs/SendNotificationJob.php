<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private  $message;
    private  $notification_type;
    private  $model_type_id;
    private  $from_user_id;
    private  $payload;
    public function __construct($message,$notification_type='',$model_type_id=0,$from_user_id = 0, $payload=[])
    {
        //
        $this->message = $message;
        $this->notification_type = $notification_type;
        $this->model_type_id = $model_type_id;
        $this->from_user_id = $from_user_id;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        //
    }
}
