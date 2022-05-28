<?php

namespace core\forms\shop;

use core\entities\shop\Coupon;
use core\entities\shop\Shop;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CouponForm extends Model
{
    public $shopId;
    public $percent;
    public $code;
    public $comment;

    public function __construct(Coupon $coupon = null, $config = [])
    {
        parent::__construct($config);
        if ($coupon) {
            $this->shopId = $coupon->shop_id;
            $this->percent = $coupon->percent;
            $this->code = $coupon->code;
            $this->comment = $coupon->comment;
        }
    }

    public function rules()
    {
        return [
            [['shopId', 'percent', 'code'], 'required'],
            [['percent'], 'integer', 'min' => 0, 'max' => 100],
            [['code'], 'string', 'max' => 128],
            [['comment'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shopId' => 'Магазин',
            'percent' => 'Процент',
            'code' => 'Код',
            'comment' => 'Комментарий',
        ];
    }

    public function attributeHints()
    {
        return [
            'percent' => 'Если купонов для магазина несколько - система будет пытаться произвести покупку с самым выгодным процентом',
            'code' => 'Купон на скидку',
            'comment' => 'Есть связанная информация с купоном, о которой стоит запомнить? Можете вписать её сюда',
        ];
    }

    public static function getShopList()
    {
        return ArrayHelper::map(Shop::findPlatform(), "id", "name");
    }

}