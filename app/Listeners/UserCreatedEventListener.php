<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\AccountVerificationOTPMail;
use App\Models\OTPCode;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserCreatedEventListener
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
    public function handle(UserCreated $event)
    {

        OTPCode::where(['email'=>$event->user->email,'ref'=>'ACCOUNT_VERIFICATION'])->delete();
        $otp = new OTPCode();
        $otp->user_id = $event->user->id;
        $otp->email = $event->user->email;
        $otp->ref = 'ACCOUNT_VERIFICATION';
        $otp->code = rand(100001,999999);
        $otp->expiring_at = Carbon::now()->addMinutes(60);
        $otp->save();
        Mail::to($event->user->email)->send(new AccountVerificationOTPMail($event->user,$otp));
    }
}
