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
    public function handle()
    {
        try {
            $callback = function ($message) {
                Log::channel('mq_log')->info(json_encode($message->body));
            };

            $rabbitMQService = app(RabbitMQService::class);
            $rabbitMQService->consume($callback);
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
        }
    }
}
