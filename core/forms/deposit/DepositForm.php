<?php

namespace core\forms\deposit;

use core\helpers\finance\PaymentHelper;
use core\lib\payment\PaymentSystemList;
use core\settings\storage\DepositInterface;
use Yii;
use yii\base\Model;

class DepositForm extends Model
{
    public $sum;
    public $method;

    private static $methodList;

    public function rules()
    {
        return [
            [['sum', 'method'], 'required'],
            [['method'], 'in', 'range' => array_keys(self::getMethodList())]
        ];
    }

    public static function getMethodList()
    {
        $formatter = Yii::$app->formatter;

        if (self::$methodList) {
            return self::$methodList;
        }

        self::$methodList = [];
        $paymentSystemList = new PaymentSystemList();

        foreach ($paymentSystemList->getAll() as $key => $class) {
            $instance = $paymentSystemList->createInstance($key);

            if ($class instanceof DepositInterface && !$instance->isDisabled()) {
                $rangeToAppend = " ({$formatter->asCurrency($instance->getMinimum())} - {$formatter->asCurrency($instance->getMaximum())})";
                self::$methodList[$key] = PaymentHelper::methodName($key) . $rangeToAppend;
            }
        }

        return self::$methodList;
    }

}