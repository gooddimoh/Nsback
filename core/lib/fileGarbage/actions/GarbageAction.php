<?php

namespace core\lib\fileGarbage\actions;

interface GarbageAction
{
    public function do($filename, $filePath);

}