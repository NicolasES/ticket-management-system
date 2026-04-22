<?php

namespace App\Application\Ports;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
