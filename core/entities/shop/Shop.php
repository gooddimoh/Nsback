<?php

namespace core\entities\shop;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property float $shop_markup
 * @property float $internal_markup
 * @property string $platform
 *
 * @property Leqshop $leqshop
 * @property Coupon[] $coupons
 */
class Shop extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 20;

    public const PLATFORM_DJEKXA = "djekxa";
    public const PLATFORM_LEQSHOP = "leqshop";
    public const PLATFORM_RAPTOR = "raptor";

    public static function make($name, $shopMarkup, $internalMarkup, $platform)
    {
        $entity = new static();
        $entity->name = $name;
        $entity->shop_markup = $shopMarkup;
        $entity->setInternalMarkup($internalMarkup);
        $entity->platform = $platform;
        $entity->status = self::STATUS_ACTIVE;

        return $entity;
    }

    public function edit($name, $shopMarkup, $internalMarkup)
    {
        $this->name = $name;
        $this->shop_markup = $shopMarkup;
        $this->setInternalMarkup($internalMarkup);
    }

    public function block()
    {
        $this->status = self::STATUS_BLOCKED;
    }

    public function isBlocked()
    {
        return $this->status == self::STATUS_BLOCKED;
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function setInternalMarkup($markup)
    {
        if ($this->shop_markup > 0 && $markup > 0) {
            throw new \DomainException("Наценка магазина, и внутренняя наценка товара не могут быть установлены одновременно");
        }

        $this->internal_markup = $markup;
    }

    public function setLeqshop($domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail)
    {
        // TODO: Решить проблему Save
        $leqshop = Leqshop::make($this->id, $domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail);
        $leqshop->save();
    }

    public function editLeqshop($domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail)
    {
        $leqshop = $this->leqshop;
        $leqshop->edit($domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail);
        $leqshop->save();
    }

    public function isPlatformLeqshop()
    {
        return $this->platform === self::PLATFORM_LEQSHOP;
    }

    public static function findPlatform()
    {
        return Shop::find()->where(['platform' => Shop::PLATFORM_LEQSHOP])->all();
    }

    public static function tableName()
    {
        return 'shop';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['leqshop'],
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'platform' => 'Платформа',
            'shop_markup' => 'Наценка магазина',
            'internal_markup' => 'Внутренняя наценка',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Leqshop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeqshop()
    {
        return $this->hasOne(Leqshop::className(), ['shop_id' => 'id']);
    }

    public function getCouponsSortedByPercent()
    {
        return $this->getCoupons()->orderBy(['percent' => SORT_DESC])->all();
    }

    /**
     * Gets query for [[Coupons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['shop_id' => 'id']);
    }

}
