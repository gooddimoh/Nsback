<?php

namespace core\entities\order;

use core\entities\payment\Payment;
use Yii;

/**
 * This is the model class for table "promo_code_activation".
 *
 * @property int $payment_id
 * @property int $promo_id
 * @property int $percent
 * @property float $discount_amount
 * @property int $date
 *
 * @property Payment $payment
 * @property PromoCode $promo
 */
class PromoCodeActivation extends \yii\db\ActiveRecord
{
    public static function make($paymentId, $promoId, $percent, $discountAmount)
    {
        $entity = new static();
        $entity->payment_id = $paymentId;
        $entity->promo_id = $promoId;
        $entity->percent = $percent;
        $entity->discount_amount = $discountAmount;
        $entity->date = time();

        return $entity;
    }

    public static function tableName()
    {
        return 'promo_code_activation';
    }

    public function attributeLabels()
    {
        return [
            'payment_id' => 'Платеж',
            'promo_id' => 'Промо-код',
            'percent' => 'Процент скидки',
            'discount_amount' => 'Сумма скидки',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[Payment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment_id']);
    }

    /**
     * Gets query for [[Promo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromo()
    {
        return $this->hasOne(PromoCode::className(), ['id' => 'promo_id']);
    }
}
