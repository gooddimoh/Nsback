<?php

namespace core\dispatchers;

interface EventDispatcher
{
    public function dispatchAll(array $events);
    public function dispatch($event);
}