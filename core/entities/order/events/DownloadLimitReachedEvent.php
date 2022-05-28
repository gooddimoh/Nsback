<?php

namespace core\entities\order\events;

class DownloadLimitReachedEvent
{
    public $quantity;
    public $userId;

    public function __construct($quantity, $userId)
    {

        $this->quantity = $quantity;
        $this->userId = $userId;
    }

}