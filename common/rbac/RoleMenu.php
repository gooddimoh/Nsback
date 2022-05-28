<?php

namespace common\rbac;

use backend\helpers\MenuHelper;
use core\readModels\OrderReadRepository;

class RoleMenu
{

    public static function get($userId)
    {
        foreach (\Yii::$app->authManager->getRolesByUser($userId) as $role) {
            switch ($role->name) {
                case Roles::ROLE_ADMINISTRATOR:
                    return self::admin();
                case Roles::ROLE_SENIOR_MANAGER:
                    return self::seniorManager();
                case Roles::ROLE_SUPPORT:
                    return self::juniorSupport();
            }
        }

        return [];
    }

    protected static function admin()
    {
        return [
            ['label' => 'Продукция', 'options' => ['class' => 'header']],
            ['label' => 'Категории', 'icon' => 'list', 'url' => ['/product/category/index']],
            ['label' => 'Группы', 'icon' => 'list-ul', 'url' => ['/product/group/index']],
            [
                'label' => 'Товары',
                'icon' => 'window-minimize',
                'url' => ['/product/product/index'],
                'items' => [
                    ['label' => 'Товары', 'url' => ['/product/product/index']],
                    ['label' => 'Массово редактировать', 'url' => ['/product/incomplete-product/index']],
                    ['label' => 'Шаблоны правил', 'url' => ['/product/rules-template/index']],
                    [
                        'label' => 'Свойства',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Категории', 'url' => ['/product/property/category/index']],
                            ['label' => 'Свойства', 'url' => ['/product/property/property/index']],
                        ]
                    ]
                ],
            ],
            ['label' => 'Поставщики', 'icon' => 'ellipsis-h', 'url' => ['/shop/shop/index']],
            ['label' => 'Импорт', 'icon' => 'cloud-download', 'url' => ['/product/import/index']],


            ['label' => 'Финансы', 'options' => ['class' => 'header']],
            [
                'label' => 'Заказы',
                'icon' => 'cart-plus',
                'url' => ['/finance/order/index'],
                'template' => MenuHelper::getCounterTemplate(OrderReadRepository::create()->countNotDelivered(), 'red')
            ],
            ['label' => 'Возвраты', 'icon' => 'share', 'url' => ['/finance/refund/index']],
            ['label' => 'Платежи', 'icon' => 'credit-card', 'url' => ['/finance/payment/index']],
            ['label' => 'Переводы', 'icon' => 'retweet', 'url' => ['/finance/transfer/index']],
            ['label' => 'Промо-коды', 'icon' => 'percent', 'url' => ['/finance/promo-code/index']],


            ['label' => 'Коммуникация', 'options' => ['class' => 'header']],
            ['label' => 'Баннеры', 'icon' => 'window-restore', 'url' => ['/communication/banner/index']],

            ['label' => 'Другое', 'options' => ['class' => 'header']],
            ['label' => 'Пользователи', 'icon' => 'user-o', 'url' => ['/user/index']],

            ['label' => 'Страницы', 'icon' => 'file-o', 'url' => ['/content/page/index']],
        ];
    }

    protected static function seniorManager()
    {
        return [
            ['label' => 'Продукция', 'options' => ['class' => 'header']],
            ['label' => 'Категории', 'icon' => 'list', 'url' => ['/product/category/index']],
            ['label' => 'Группы', 'icon' => 'list-ul', 'url' => ['/product/group/index']],
            [
                'label' => 'Товары',
                'icon' => 'window-minimize',
                'url' => ['/product/product/index'],
                'items' => [
                    ['label' => 'Товары', 'url' => ['/product/product/index']],
                    ['label' => 'Массово редактировать', 'url' => ['/product/fill-product/index']],
                    ['label' => 'Шаблоны инструкций', 'url' => ['/product/rules-template/index']],
                ],
            ],
            ['label' => 'Поставщики', 'icon' => 'ellipsis-h', 'url' => ['/shop/shop/index']],
            ['label' => 'Импорт', 'icon' => 'cloud-download', 'url' => ['/product/import/index']],


            ['label' => 'Финансы', 'options' => ['class' => 'header']],
            [
                'label' => 'Заказы',
                'icon' => 'cart-plus',
                'url' => ['/finance/order/index'],
                'template' => MenuHelper::getCounterTemplate(OrderReadRepository::create()->countNotDelivered(), 'red')
            ],
            ['label' => 'Возвраты', 'icon' => 'share', 'url' => ['/finance/refund/index']],
            ['label' => 'Платежи', 'icon' => 'credit-card', 'url' => ['/finance/payment/index']],
            ['label' => 'Промо-коды', 'icon' => 'percent', 'url' => ['/finance/promo-code/index']],


            ['label' => 'Коммуникация', 'options' => ['class' => 'header']],
            ['label' => 'Баннеры', 'icon' => 'window-restore', 'url' => ['/communication/banner/index']],


            ['label' => 'Другое', 'options' => ['class' => 'header']],
            ['label' => 'Пользователи', 'icon' => 'file-o', 'url' => ['/user/index']],
            ['label' => 'Страницы', 'icon' => 'file-o', 'url' => ['/content/page/index']],
        ];
    }

    protected static function juniorSupport()
    {
        return [
            ['label' => 'Товары', 'icon' => 'binoculars', 'url' => ['/product/product/index']],
            [
                'label' => 'Заказы',
                'icon' => 'cart-plus',
                'url' => ['/finance/order/index'],
                'template' => MenuHelper::getCounterTemplate(OrderReadRepository::create()->countNotDelivered(), 'red')
            ],
            ['label' => 'Возвраты', 'icon' => 'share', 'url' => ['/finance/refund/index']],
            ['label' => 'Платежи', 'icon' => 'credit-card', 'url' => ['/finance/payment/index']],
            ['label' => 'Пользователи', 'icon' => 'user-o', 'url' => ['/user/index']],
        ];
    }

}