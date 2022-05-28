<?php

namespace core\lib\raptor;

use core\entities\order\Order;
use core\lib\productProvider\BuyInterface;

class RaptorBuy implements BuyInterface
{

    public function buy(Order $order)
    {
        return mt_rand(0, 1) ? mt_rand(1, 100000) : \Yii::$app->security->generateRandomString(6);
    }

    public function download(Order $order)
    {
        $result = "";
        $accountNumbers = mt_rand(1, 50);

        while ($accountNumbers--) {
            $result .= $this->generateRandomAccount() . PHP_EOL;
        }

        return $result;
    }

    protected function generateRandomAccount()
    {
        $emailProviders = ["gmail.com", "yandex.ru", "mail.ru", 'yahoo.com'];

        $randomEmailProvider = $emailProviders[array_rand($emailProviders)];
        $username = \Yii::$app->security->generateRandomString(6);

        return "$username@$randomEmailProvider";
    }
}