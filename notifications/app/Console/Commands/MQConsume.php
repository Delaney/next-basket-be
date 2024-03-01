<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class MQConsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume from the MQ Queue';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $rabbitMQService = app(RabbitMQService::class);
            $rabbitMQService->consume([$this, 'messageCallback']);
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
        }
    }

    public function messageCallback ($message): void {
        if (gettype($message) === 'object' && $message->body) {
            $message = $message->body;
        }

        Log::channel(config('services.rabbitmq.log'))->info($message);
    }
}
