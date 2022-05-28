<?php

namespace frontend\widgets\orderResult;

use core\entities\order\Order;
use core\lib\emoji\Emoji;
use core\lib\errorManager\CustomerErrorMessage;
use yii\base\Widget;

/**
 * @property Order $order
 */
class OrderResultWidget extends Widget
{
    private const TEXT_DATA_LIST = [
        Order::STATUS_UNPAID => [
            'title' => "Заказ в процессе оплаты " . Emoji::HOURGLASS,
            'content' => 'Платеж обрабатывается, или заказ не оплачен. После завершения обработки - мы перенаправим Вас на страницу загрузки товара',
        ],
        Order::STATUS_PENDING => [
            'title' => 'Спасибо за покупку! ' . Emoji::THUMBS_UP_SIGN,
            'content' => 'Заказ обрабатывается и готовится к выдаче. Вскоре он будет доступен к загрузке.',
        ],
        Order::STATUS_CANCELED => [
            'title' => 'Заказ отменен ' . Emoji::NO_ENTRY,
            'content' => 'Ваш заказ был отменен',
        ],
        Order::STATUS_ERROR => [
            'title' => 'Произошла ошибка ' . Emoji::WORRIED_FACE,
            'content' => '',
        ],
        Order::STATUS_CANCELED_BY_USER => [
            'title' => 'Вы отменили заказ' . Emoji::HEAVY_MULTIPLICATION_X,
            'content' => 'Пожалуйста, свяжитесь с поддержкой чтобы мы вернули Вам средства за заказ',
        ],
        Order::STATUS_REFUND => [
            'title' => 'Возврат' . Emoji::HEAVY_MULTIPLICATION_X,
            'content' => 'Для данного товара оформлен полный, либо частичный возврат средств.',
        ],
        Order::STATUS_SUSPENDED => [
            'title' => 'Приостановлен',
            'content' => 'Заказ был приостановлен в связи с ошибкой, или по запросу клиента. Пожалуйста, обратитесь в поддержку для уточнения деталей'
        ]
    ];
    private const PATH = "@frontend/widgets/orderResult";

    public $order;

    public function init()
    {
        parent::init();

        if (!$this->order instanceof Order) {
            throw new \InvalidArgumentException("Property must be instance of " . Order::class);
        }
        if (!array_key_exists($this->order->status, self::TEXT_DATA_LIST)) {
            throw new \InvalidArgumentException("Unknown status {$this->order->status}");
        }
    }

    public function run()
    {
        parent::run();

        $textList = self::TEXT_DATA_LIST[$this->order->status];

        switch ($this->order->status) {
            case Order::STATUS_ERROR:
            {
                $fileName = "_error.php";
                $params = [
                    'textList' => $textList,
                    'errorMessage' => new CustomerErrorMessage($this->order->error_data),
                    'order' => $this->order,
                ];
                break;
            }
            default:
            {
                $fileName = "_default.php";
                $params = ['textList' => $textList];
            }
        }

        return $this->renderFile(self::PATH . "/$fileName", $params);
    }


}