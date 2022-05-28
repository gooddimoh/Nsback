<?php

namespace core\lib\attention\operations;

class OperationPlus extends Operation
{
    public function __construct($text, $icon = "plus")
    {
        $this->text = $text;
        $this->icon = $icon;
    }
}