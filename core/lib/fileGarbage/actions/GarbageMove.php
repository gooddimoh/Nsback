<?php

namespace core\lib\fileGarbage\actions;

use core\lib\fileManager\FilePathHelper;

class GarbageMove implements GarbageAction
{
    private string $trashcanPathAlias;

    public function __construct($trashcanPathAlias)
    {
        $this->trashcanPathAlias = $trashcanPathAlias;
    }

    public function do($filename, $filePath)
    {
        rename($filePath, FilePathHelper::getFullPath($this->trashcanPathAlias, $filename));
    }

}