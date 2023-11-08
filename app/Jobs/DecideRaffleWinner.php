<?php

namespace App\Jobs;

use App\Http\Resources\RaffleResource;
use App\Models\Raffle;
use App\Models\Refund;
use App\Services\PushNotificationService;
use App\Services\Transactions\CreditTransaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DecideRaffleWinner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $raffle;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(  $raffle)
    {
        $this->raffle = $raffle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = 'Raffle abandoned due to low participants';
        $now= Carbon::now('UTC');
        if(
//            $now->gte(Carbon::parse($this->raffle->end_date))   &&
            $this->raffle->status == Raffle::RAFFLE_ACTIVE && $this->raffle->winner_id==null ) {
            $raffle = Raffle::with('images', 'category', 'winner')
                ->withCount('participants')->find($this->raffle->id);
            $participants = $raffle->participants()->get()->pluck('device_token')->toArray();
            if ($raffle->participants_count == $raffle->total_participants) {
                $winner = DB::table('raffle_participants')->where('raffle_id', $raffle->id)->inRandomOrder()->first();
                $raffle->winner_id = $winner->user_id;
                $raffle->status = Raffle::RAFFLE_WINNER;
                $raffle->save();
                $raffle->load('winner');
                $message = 'Raffle winner announced';
                app(CreditTransaction::class)->execute(['tokens'=>$raffle->price,'type'=>'credit','user_id'=>$raffle->user_id]);
            } else {
                $raffle->status = Raffle::RAFFLE_ABUNDANT;
                $raffle->save();
                //refund credits
                foreach ($raffle->participants as $participant){
                    tap(Refund::create([
                        'user_id' => $participant->id,
                        'amount' => $raffle->bidding_price,
                        'status' => 1,
                    ]), function ($refund) use ($raffle): void {
                        $raffle->refunds()->save($refund);
                    });
                    app(CreditTransaction::class)->execute(['tokens'=>$raffle->bidding_price,'type'=>'credit','user_id'=>$participant->id]);
                }
            }
            $raffle_data = new RaffleResource($raffle);
            if (count($participants)) {
                $notification = PushNotificationService::sendNotification($raffle_data->jsonSerialize(), $participants, $message);
            }
        }
    }
}
