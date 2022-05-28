<?php

namespace core\services;

use yii\mutex\FileMutex;

class MutexManager
{
    private $mutex;

    public function __construct()
    {
        $this->mutex = new FileMutex(['mutexPath' => '@common/runtime/mutex']);
    }

    public function execute(callable $function, $name)
    {
        if ($this->mutex->acquire($name, 30)) {
            try {
                call_user_func($function);
                $this->mutex->release($name);
            } catch (\Exception $e) {
                $this->mutex->release($name);
                throw $e;
            }
        }
    }
}