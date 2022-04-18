<?php

namespace App\Listeners;

use App\Events\ReservationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ReservationEmail;

class ReservationListener
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
     * @param  UserWasCreatedEvent  $event
     * @return void
     */
    public function handle(ReservationEvent $event)
    {
        Mail::to($event->email)->send(new ReservationEmail($event->name));
    }
}
