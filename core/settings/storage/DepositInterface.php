<?php

namespace core\settings\storage;

interface DepositInterface
{
    public function getMinimum();

    public function getMaximum();

}