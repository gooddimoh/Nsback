<?php

namespace core\settings\storage;

class MazeBankSettings implements PaymentSystemInterface
{
    private $disable;
    private $description;

    public function __construct()
    {
        $this->description = "Maze Bank: Card Payment / ATM";
        $this->disable = true;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isDisabled()
    {
        return $this->disable;
    }

    public function getName()
    {
        return "MazeBank";
    }

    public function getIconPath()
    {
        return "/img/icons/payments/mazebank.png";
    }

    public function getWarning()
    {
        return null;
    }
}