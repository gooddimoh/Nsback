<?php

namespace core\lib\fileManager;

use igogo5yo\uploadfromurl\UploadFromUrl;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class FileSaver
{
    private $storagePath;

    public function __construct($storagePath)
    {
        $this->storagePath = $storagePath;
    }

    public function storeFile(UploadedFile $file)
    {
        $extension = $file->extension ?: "jpg";
        $fileName = $this->generateName($file->name, $file->size, $file->type, $extension);

        if (!$this->isFileExist($fileName)) {
            $file->saveAs($this->getFullPath($fileName));
        }

        Yii::info($file->error, "imageHasError");

        return $fileName;
    }

    public function storeFileByUrl($url)
    {
        $file = UploadFromUrl::initWithUrl($url);

        $extension = $file->extension ?: "jpg";
        $fileName = $this->generateName($file->name, $file->size, $file->type, $extension);

        if (!$this->isFileExist($fileName)) {
            $file->saveAs($this->getFullPath($fileName));
        }

        return $fileName;
    }

    public function removeFile($name)
    {
        FileHelper::unlink($this->getFullPath($name));
    }

    protected function generateName($name, $size, $type, $extension)
    {
        if (is_array($type)) {
            $type = array_slice($type, -1);
            $type = $type[0];
        }

        return md5($name . $size . $type) . "." . $extension;
    }

    protected function isFileExist($filename)
    {
        return file_exists($this->getFullPath($filename));
    }

    protected function getFullPath($fileName)
    {
        return FilePathHelper::getFullPath($this->storagePath, $fileName);
    }


}