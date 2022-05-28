<?php

namespace core\forms\shop;

use core\entities\shop\Leqshop;
use yii\base\Model;

class LeqshopForm extends Model
{
    public $domain;
    public $apiKeyPublic;
    public $apiKeyPrivate;
    public $productKey;
    public $createOrderKey;
    public $userToken;
    public $userEmail;

    public function __construct(Leqshop $leqshop = null, $config = [])
    {
        parent::__construct($config);
        if ($leqshop) {
            $this->domain = $leqshop->domain;
            $this->apiKeyPublic = $leqshop->api_key_public;
            $this->apiKeyPrivate = $leqshop->api_key_private;
            $this->productKey = $leqshop->product_key;
            $this->createOrderKey = $leqshop->create_order_key;
            $this->userToken = $leqshop->user_token;
            $this->userEmail = $leqshop->user_email;
        }
    }

    public function rules()
    {
        return [
            [['apiKeyPublic', 'apiKeyPrivate', 'productKey', 'createOrderKey', 'userToken', 'userEmail', 'domain'], 'required'],
            [['apiKeyPublic', 'apiKeyPrivate', 'productKey', 'createOrderKey', 'userToken', 'domain'], 'string'],
            [['userEmail'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'apiKeyPublic' => 'Api Key Public',
            'apiKeyPrivate' => 'Api Key Private',
            'productKey' => 'Product Key',
            'createOrderKey' => 'Create Order Key',
            'userToken' => 'User Token',
            'userEmail' => 'User Email',
        ];
    }


}