<?php

namespace App\Listeners;

use App\Events\RTOrderPlacedNotificationEvent;
use App\Models\OrderPlacedNotification;

class RTOrderPlacedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RTOrderPlacedNotificationEvent $event): void
    {
        $notification = new OrderPlacedNotification();
        $notification->message = $event->message;
        $notification->order_id = $event->orderId;
        $notification->save();

    }
}
