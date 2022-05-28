<?php

namespace core\entities\shop;


/**
 * This is the model class for table "leqshop".
 *
 * @property int $shop_id
 * @property string $domain
 * @property string $api_key_public
 * @property string $api_key_private
 * @property string $product_key
 * @property string $create_order_key
 * @property string $user_token
 * @property string $user_email
 *
 * @property Shop $shop
 */
class Leqshop extends \yii\db\ActiveRecord
{
    public static function make($shopId, $domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail)
    {
        $entity = new static();
        $entity->shop_id = $shopId;
        $entity->domain = $domain;
        $entity->api_key_public = $apiKeyPublic;
        $entity->api_key_private = $apiKeyPrivate;
        $entity->product_key = $productKey;
        $entity->create_order_key = $createOrderKey;
        $entity->user_token = $userToken;
        $entity->user_email = $userEmail;

        return $entity;
    }

    public function edit($domain, $apiKeyPublic, $apiKeyPrivate, $productKey, $createOrderKey, $userToken, $userEmail)
    {
        $this->domain = $domain;
        $this->api_key_public = $apiKeyPublic;
        $this->api_key_private = $apiKeyPrivate;
        $this->product_key = $productKey;
        $this->create_order_key = $createOrderKey;
        $this->user_token = $userToken;
        $this->user_email = $userEmail;
    }


    public static function tableName()
    {
        return 'leqshop';
    }


    public function attributeLabels()
    {
        return [
            'shop_id' => 'Магазин',
            'domain' => 'Домен',
            'api_key_public' => 'Api Key Public',
            'api_key_private' => 'Api Key Private',
            'product_key' => 'Product Key',
            'create_order_key' => 'Create Order Key',
            'user_email' => 'User Email',
            'user_token' => 'User Token',
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
