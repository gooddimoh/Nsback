<?php

namespace core\payment\enot;

class EnotPayment
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
        if (array_key_exists($name, $this->otherParams)) {
            return $this->otherParams[$name];
        }

        return null;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }

        $this->otherParams[$name] = $value;
    }

}