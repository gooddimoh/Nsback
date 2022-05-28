<?php

namespace core\forms\order\promo;

use yii\base\Model;

class PromoCodeForm extends Model
{
    public $code;
    public $percent;
    public $comment;
    public $activationLimit;

    public function rules()
    {
        return [
            [['percent', 'activationLimit'], 'required'],
            [['percent'], 'integer', 'min' => 1, 'max' => 99],
            [['code'], 'string', 'max' => 128],
            [['comment'], 'string', 'max' => 240],
            [['activationLimit'], 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Промо-код',
            'percent' => 'Процент скидки',
            'activationLimit' => 'Лимит активаций',
            'comment' => 'Комментарий',
        ];
    }

    public function attributeHints()
    {
        return [
            'code' => 'Оставьте незаполненным для автоматической генерации кода',
            'comment' => 'Комментарий видит только администратор',
        ];
    }

}