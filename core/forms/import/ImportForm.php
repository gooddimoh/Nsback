<?php

namespace core\forms\import;

use core\entities\product\Group;
use core\entities\shop\Shop;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ImportForm extends Model
{
    public $shopId;
    public $groupId;
    public $shouldModerate;

    public function rules()
    {
        return [
            [['shopId', 'groupId', 'shouldModerate'], 'required'],
            [['shouldModerate'], 'boolean'],
            [['shopId'], 'exist', 'targetClass' => Shop::class, 'targetAttribute' => 'id'],
            [['groupId'], 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'shopId' => 'Магазин',
            'groupId' => 'Группа',
            'shouldModerate' => 'Модерировать товары',
        ];
    }

    public function attributeHints()
    {
        return [
            'groupId' => 'В данную группу будут помещены товары, группу которых не удалось определить',
            'shouldModerate' => 'Товар будут скрыты от пользователей, пока их не промодерируют',
        ];
    }

    public static function getShopList()
    {
        return ArrayHelper::map(Shop::find()->where(['status' => Shop::STATUS_ACTIVE])->asArray()->all(), "id", "name");
    }

    public static function getGroupList()
    {
        return ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name');
    }


}