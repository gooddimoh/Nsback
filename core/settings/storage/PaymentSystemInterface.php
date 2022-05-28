<?php

namespace core\settings\storage;

interface PaymentSystemInterface
{
    public function getName();
    public function getIconPath();
    public function getDescription();
    public function getWarning();
    public function isDisabled();

}