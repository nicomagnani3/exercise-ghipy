<?php

namespace App\Listeners;

use App\Events\InteractionEvent;
use App\Models\Interaction;

class InteractionListener
{
    /**
     * Handle the event.
     *
     * @param  InteractionEvent  $event
     * @return void
     */
    public function handle(InteractionEvent $event)
    {
        $data = [
            'user_id' => $event->userId,
            'service' => $event->serviceName,
            'request_body' => json_encode($event->request),
            'http_status_code' => $event->responseCode,
            'response_body' => json_encode($event->responseData),
            'ip_address' => $event->ip,
        ];

        Interaction::create($data);
    }
}