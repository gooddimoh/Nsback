<?php


namespace core\settings;

/**
 * Class Settings
 * @package core\settings
 * Настройки со своей моделью для валидации
 */
class Settings extends \yii2mod\settings\components\Settings
{
    public $modelClass = 'core\settings\SettingModel';

}