<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\RabbitMQService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PublishUser
{
    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->getUser();
        $json = json_encode($user);

        $rabbitMQService = app(RabbitMQService::class);
        $rabbitMQService->publish($json);
    }
}
