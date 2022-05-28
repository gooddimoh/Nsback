<?php

namespace core\forms\order\promo;

use yii\base\Model;

class PromoCodeBulkForm extends Model
{
    public $codes;
    public $percent;
    public $comment;
    public $activationLimit;

    public function rules()
    {
        return [
            [['codes', 'percent', 'activationLimit'], 'required'],
            [['percent'], 'number'],
            [['comment'], 'string', 'max' => 250],
            [['activationLimit'], 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'codes' => 'Промо-коды',
            'percent' => 'Процент скидки',
            'activationLimit' => 'Лимит активаций',
            'comment' => 'Комментарий',
        ];
    }

    public function attributeHints()
    {
        return [
            'codes' => '1 промо-код в строке',
        ];
    }



}