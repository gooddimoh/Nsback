<?php

namespace core\lib\fileGarbage;

use core\lib\fileGarbage\actions\GarbageAction;
use core\lib\fileManager\FilePathHelper;
use core\lib\fileGarbage\repositories\FileExist;

class FileGarbageCollector
{
    private string $pathAlias;
    private FileExist $mediaRepository;
    private GarbageAction $garbageAction;

    public function __construct($pathAlias, FileExist $mediaRepository, GarbageAction $garbageAction)
    {
        $this->pathAlias = $pathAlias;
        $this->mediaRepository = $mediaRepository;
        $this->garbageAction = $garbageAction;
    }

    public function start()
    {
        $files = scandir(FilePathHelper::getPathByAlias($this->pathAlias));
        $files = array_diff($files, array('..', '.'));

        foreach ($files as $file) {
            $filePath = FilePathHelper::getFullPath($this->pathAlias, $file);

            if (!$this->mediaRepository->isFileExist($file) && !is_dir($filePath)) {
                $this->garbageAction->do($file, $filePath);
            }
        }
    }

}