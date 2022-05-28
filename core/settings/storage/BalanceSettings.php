<?php

namespace core\settings\storage;

class BalanceSettings implements PaymentSystemInterface
{
    public function getName()
    {
        return "Баланс";
    }

    public function isDisabled()
    {
        return \Yii::$app->user->isGuest;
    }

    public function getIconPath()
    {
        return "/img/icons/payments/wallet.png";
    }

    /***
     * @return string
     */
    public function getDescription()
    {
        $balance = isset(\Yii::$app->user->identity->balance) ? \Yii::$app->user->identity->getPrettyBalance() : "-";

        return "Оплатить балансом на сервисе: $balance";
    }

    public function getWarning()
    {
        return null;
    }

}