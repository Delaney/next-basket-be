<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

class RabbitMQService
{
    protected AMQPStreamConnection $connection;

    protected string $exchange;
    protected string $queue;
    protected string $key;
    
    public function __construct(array $config = [])
    {
        [
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'password' => $password,
            'vhost' => $vhost,
            'queue' => $this->queue,
            'exchange' => $this->exchange,
            'key' => $this->key,
        ] = $config;

        $this->connection = new AMQPStreamConnection(
            $host,
            $port,
            $user,
            $password,
            $vhost
        );

    }

    public function __destruct()
    {
        $this->connection->close();
    }
    
    public function publish(string $message): void
    {
        try {
    
            $channel = $this->connection->channel();
            
            $channel->exchange_declare($this->exchange, 'direct', false, false, false);
            $channel->queue_declare($this->queue, false, false, false, false);
            $channel->queue_bind($this->queue, $this->exchange, $this->key);
            
            $msg = new AMQPMessage($message);
            
            $channel->basic_publish($msg, $this->exchange, $this->key);
            $channel->close();
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
        }

    }
}