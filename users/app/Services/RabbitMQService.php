<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

class RabbitMQService
{
    protected AMQPStreamConnection $connection;

    protected AMQPChannel $channel;

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

        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare($this->exchange, 'direct', false, false, false);
        $this->channel->queue_declare($this->queue, false, false, false, false);
        $this->channel->queue_bind($this->queue, $this->exchange, $this->key);
    }
    
    public function publish(string $message): void
    {
        try {
            $msg = new AMQPMessage($message);
            
            $this->channel->basic_publish($msg, $this->exchange, $this->key);
            $this->channel->close();
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
        }
    }

    public function consume($callback)
    {
        try {
            $this->channel->basic_consume($this->queue, '', false, true, false, false, $callback);

            while (count($this->channel->callbacks)) {
                $this->channel->wait();
            }
        } catch (Throwable $ex) {
            Log::error($ex->getMessage(), $ex->getTrace());
        }
    }

    public function __destruct()
    {
        $this->connection->close();
        $this->channel->close();
    }
}
