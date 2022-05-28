<?php

namespace core\lib\fileGarbage\actions;

class GarbageEcho implements GarbageAction
{
    public function do($filename, $filePath)
    {
        echo "File $filename not used is $filePath" . PHP_EOL;
    }

}