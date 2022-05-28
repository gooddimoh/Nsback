<?php

namespace core\lib\fileManager;

class FilePathHelper
{
    public static function getPathByAlias($alias)
    {
        return \Yii::getAlias($alias);
    }

    public static function getFullPath($alias, $fileName)
    {
        return rtrim(\Yii::getAlias($alias), "/") . "/" . $fileName;
    }

}