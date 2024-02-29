<?php

namespace App\Data;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

class CommandBus
{
    public function handle($command)
    {
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        $handler($command);
    }
}
