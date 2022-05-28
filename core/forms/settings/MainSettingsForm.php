<?php

namespace core\forms\settings;

use yii\base\Model;
use yii\helpers\Html;

class MainSettingsForm extends Model
{

    public $headCode;
    public $endBodyCode;
    public $disableSite;
    public $disableSiteMessage;
    public $disableProductUpdate;

    public function rules()
    {
        return [
            [['disableSite', 'disableProductUpdate'], 'boolean'],
            [['disableSiteMessage'], 'string'],
            [['headCode', 'endBodyCode'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'disableSite' => 'Отключить сайт',
            'disableSiteMessage' => 'Сообщение при отключении сайта',
            'disableProductUpdate' => 'Отключить обновление товара',
            'headCode' => 'JS/HTML/CSS-код в head',
            'endBodyCode' => 'JS/HTML/CSS-код в конец body',
        ];
    }

    public function attributeHints()
    {
        $warning = Html::tag("span", "Внимание!", ['class' => 'text-warning']) .
            " Убедитесь что код получен из доверенного источника. Изменение данной настройки может помешать работе сайта";
        return [
            'headCode' => $warning,
            'endBodyCode' => $warning,
        ];
    }

}