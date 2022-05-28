<?php

namespace core\entities\order;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;

/**
 * This is the model class for table "promo_code".
 *
 * @property int $id
 * @property string $comment
 * @property string $code
 * @property int $percent
 * @property int $activation_limit
 * @property int $status
 * @property int $date
 *
 * @property PromoCodeActivation[] $promoCodeActivations
 */
class PromoCode extends \yii\db\ActiveRecord
{
    public const STATUS_ACTIVE = 10;
    public const STATUS_INACTIVE = 20;
    public const STATUS_REMOVED = 30;

    public static function make($code, $sum, $comment, $activationLimit)
    {
        $entity = new static();
        $entity->code = $code ?: $entity->generateCode();
        $entity->percent = $sum;
        $entity->status = static::STATUS_ACTIVE;
        $entity->comment = $comment;
        $entity->activation_limit = $activationLimit;
        $entity->date = time();

        return $entity;
    }

    public function activate()
    {
        $this->status = PromoCode::STATUS_ACTIVE;
    }

    public function isActive()
    {
        return $this->status == PromoCode::STATUS_ACTIVE;
    }

    public function inactivate()
    {
        $this->status = PromoCode::STATUS_INACTIVE;
    }

    public function isInactive()
    {
        return $this->status == PromoCode::STATUS_INACTIVE;
    }

    public function remove()
    {
        $this->status = self::STATUS_REMOVED;
    }

    public function generateCode()
    {
        return uniqid();
    }

    public function calculateDiscountSum($sum)
    {
        return round($sum * $this->percent / 100, 2);
    }

    /** PromoCode Activations */

    public function addActivation($paymentId, $percent, $discountAmount)
    {
        $activations = $this->promoCodeActivations;
        $activations[] = PromoCodeActivation::make($paymentId, $this->id, $percent, $discountAmount);
        $this->promoCodeActivations = $activations;
    }

    public function isActivationLimitReached()
    {
        return count($this->promoCodeActivations) >= $this->activation_limit;
    }

    public static function tableName()
    {
        return 'promo_code';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['promoCodeActivations'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Комментарий',
            'code' => 'Промо-код',
            'percent' => 'Процент',
            'activation_limit' => 'Лимит активаций',
            'status' => 'Статус',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[PromoCodeActivations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromoCodeActivations()
    {
        return $this->hasMany(PromoCodeActivation::className(), ['promo_id' => 'id']);
    }

}
