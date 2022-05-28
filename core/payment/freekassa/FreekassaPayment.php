<?php

namespace core\payment\freekassa;

class FreekassaPayment
{
    public $merchantId;
    public $sum;
    public $sign;
    public $operationId;
    public $description;
    public $currency;

    private $otherParams = [];

    public function __get($name)
    {
        $name = 'us_' . $name;
        return $this->otherParams[$name] ?? null;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }

        $this->otherParams[$name] = $value;
    }

    public function __isset($name): bool
    {
        return false;
    }

}