<?php

namespace Tests\Unit;

use App\Console\Commands\MQConsume;
use App\Services\RabbitMQService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Mockery\MockInterface;
use Tests\TestCase;

class ConsumeEventTest extends TestCase
{
    public function testCallbackWritesToLog(): void
    {
        $message = $this->faker->text;

        Log::shouldReceive('channel')
            ->once()
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($log) use ($message) {
                return strpos($log, $message) !== false;
            })
            ->andReturnNull();

        $command = new MQConsume;
        $command->messageCallback($message);
    }
}
