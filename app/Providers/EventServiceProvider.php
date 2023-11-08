<?php

namespace App\Providers;

use App\Events\FriendRequestUpdated;
use App\Events\MeetupRequestAdded;
use App\Events\NewDeliveryBookingConfirmed;
use App\Events\NotifyReceipient;
use App\Events\UserCreated;
use App\Listeners\FriendRequestUpdatedListener;
use App\Listeners\MeetupRequestAddedListener;
use App\Listeners\NewDeliveryBookingConfirmedListener;
use App\Listeners\NotifyReceipientListener;
use App\Listeners\UserCreatedEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UserCreated::class=>[
            UserCreatedEventListener::class
        ],

        NewDeliveryBookingConfirmed::class=>[
            NewDeliveryBookingConfirmedListener::class
        ],
        NotifyReceipient::class=>[
            NotifyReceipientListener::class
        ],
        FriendRequestUpdated::class=>[
            FriendRequestUpdatedListener::class
        ],
        MeetupRequestAdded::class=>[
            MeetupRequestAddedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
