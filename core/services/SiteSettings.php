<?php


namespace core\services;


class SiteSettings
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getValue($key, $throwIfNotFound = false)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }

        if ($throwIfNotFound) {
            throw new \RuntimeException("Param $key not found");
        }

        return  false;
    }

}