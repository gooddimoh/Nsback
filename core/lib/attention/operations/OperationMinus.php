<?php

namespace core\lib\attention\operations;

class OperationMinus extends Operation
{
    public function __construct($text, $icon = "minus")
    {
        $this->text = $text;
        $this->icon = $icon;
    }
}