<?php

namespace core\entities\shop;

use Yii;

/**
 * This is the model class for table "coupon".
 *
 * @property int $id
 * @property int $shop_id
 * @property int $percent
 * @property string $code
 * @property string|null $comment
 *
 * @property Shop $shop
 */
class Coupon extends \yii\db\ActiveRecord
{

    public static function make($shopId, $percent, $code, $comment)
    {
        $entity = new static();
        $entity->shop_id = $shopId;
        $entity->percent = $percent;
        $entity->code = $code;
        $entity->comment = $comment;

        return $entity;
    }

    public function edit($shopId, $percent, $code, $comment)
    {
        $this->shop_id = $shopId;
        $this->percent = $percent;
        $this->code = $code;
        $this->comment = $comment;
    }

    public static function tableName()
    {
        return 'coupon';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Магазин',
            'percent' => 'Процент',
            'code' => 'Код',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
