<?php

namespace App\Listeners;

use App\Events\SendNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationEventListener
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
     * @param  SendNotificationEvent  $event
     * @return SendNotificationEvent
     */
    public function handle(SendNotificationEvent $event)
    {
        return $event;
    }
}
