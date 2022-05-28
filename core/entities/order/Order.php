<?php

namespace core\entities\order;

use backend\helpers\roles\SupportRoleHelper;
use core\entities\EventTrait;
use core\entities\payment\Payment;
use core\entities\payment\PaymentOrder;
use core\entities\product\Product;
use core\entities\order\events\OrderCreatedEvent;
use core\entities\order\events\OrderErrorEvent;
use core\entities\user\User;
use core\helpers\HidingHelper;
use core\helpers\order\OrderHelper;
use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $code
 * @property int $user_id
 * @property int $product_id
 * @property string $invoice_id
 * @property int $quantity
 * @property float $cost
 * @property string $email
 * @property int $status
 * @property string $file
 * @property int $downloaded_at
 * @property string $error_data
 * @property int $created_at
 * @property string $ip
 *
 * @property Product $product
 * @property User $user
 * @property PaymentOrder $paymentOrder
 * @property Refund $refund
 */
class Order extends \yii\db\ActiveRecord
{
    use EventTrait;

    public const STATUS_UNPAID = 10;
    public const STATUS_PROCESSING = 20;
    public const STATUS_PENDING = 30;
    public const STATUS_COMPLETED = 40;
    public const STATUS_ERROR = 50;
    public const STATUS_CANCELED = 60;
    public const STATUS_CANCELED_BY_USER = 70;
    public const STATUS_REFUND = 80;
    public const STATUS_SUSPENDED = 90;

    public const ALLOW_MANAGER_SET_STATUS = [self::STATUS_UNPAID, self::STATUS_PENDING, self::STATUS_CANCELED, self::STATUS_COMPLETED, self::STATUS_SUSPENDED];

    public static function make($productId, $quantity, $cost, $email, $ip)
    {
        $entity = new static();
        $entity->code = HidingHelper::generateKey($productId);
        $entity->product_id = $productId;
        $entity->email = $email;
        $entity->cost = $cost;
        $entity->quantity = $quantity;
        $entity->status = self::STATUS_UNPAID;
        $entity->downloaded_at = null;
        $entity->created_at = time();
        $entity->recordEvent(new OrderCreatedEvent($entity));
        $entity->ip = $ip;

        return $entity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function assignUser($userId)
    {
        if ($this->user_id) {
            throw new \LogicException("User already assigned");
        }

        $this->user_id = $userId;
    }

    public function setInvoice($invoiceId)
    {
        $this->invoice_id = $invoiceId;
    }

    public function setStatusByManager($status)
    {
        if (!in_array($status, self::ALLOW_MANAGER_SET_STATUS)) {
            throw new \DomainException("Manager is not allowed set status " . OrderHelper::statusName($status));
        }

        $this->status = $status;
    }

    public function isUnpaid()
    {
        return $this->status === self::STATUS_UNPAID;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCanBeRefundable()
    {
        return $this->isCompleted() || $this->isPending() || $this->isCanceledByUser() || $this->isError();
    }

    public function isRefunded()
    {
        return $this->status === self::STATUS_REFUND;
    }

    public function isSuspended()
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    public function isCanceledByUser()
    {
        return $this->status === self::STATUS_CANCELED_BY_USER;
    }

    public function isReadyToDownload()
    {
        return $this->isCompleted() || $this->isRefunded();
    }

    public function isError()
    {
        return $this->status === self::STATUS_ERROR;
    }

    public function sendToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    public function sendToProcessing()
    {
        $this->status = self::STATUS_PROCESSING;
    }

    public function sendToRefund()
    {
        $this->status = self::STATUS_REFUND;
    }

    public function suspendByError($message)
    {
        $this->status = self::STATUS_SUSPENDED;
        $this->writeError($message);
    }

    public function writeError($message)
    {
        if ($message !== $this->error_data) {
            $this->error_data = $message;
            $this->recordEvent(new OrderErrorEvent($this));
        }
    }

    public function recordErrorOccured($message)
    {
        $this->status = self::STATUS_ERROR;
        $this->writeError($message);
    }

    public function clearError()
    {
        $this->error_data = null;
    }

    public function completed($result)
    {
        $this->status = self::STATUS_COMPLETED;
        $this->writeResult($result);
    }

    public function writeResult($file)
    {
        $this->file = $file;
    }

    public function isFromGuest()
    {
        return empty($this->user_id);
    }

    public function cancelByUser()
    {
        $this->status = self::STATUS_CANCELED_BY_USER;
    }

    public function calculateCostPerOne()
    {
        return $this->cost / $this->quantity;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function saveResultAsFile($content)
    {
        $fileName = HidingHelper::generateKey() . ".txt";
        $savePath = Yii::getAlias(Yii::$app->params['order.resultPath']) . "/$fileName";
        $isSaved = file_put_contents($savePath, $content);

        if ($isSaved === false) {
            throw new \RuntimeException("Can not save file");
        }

        return $fileName;
    }

    public function getFileDownloadPath()
    {
        $protocol = Yii::$app->params['domain.protocol'];
        $domain = Yii::$app->params['domain.value'];
        $path = Yii::$app->params['order.resultUrlPath'];

        return "$protocol://$domain$path/$this->file";
    }

    public function downloaded()
    {
        $this->downloaded_at = time();
    }

    public function getInfoPage()
    {
        return Yii::$app->frontendUrlManager->createAbsoluteUrl(['/order/view', 'code' => $this->code, 'email' => $this->email],
            'http');
    }

    public static function tableName()
    {
        return 'order';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'product_id' => 'Продукт',
            'invoice_id' => 'ID Заказа Поставщика',
            'cost' => 'Стоимость',
            'quantity' => 'Количество',
            'email' => 'Email',
            'status' => 'Статус',
            'file' => 'Файл с данными',
            'downloaded_at' => 'Дата загрузки',
            'result' => 'Результат',
            'created_at' => 'Дата создания',
        ];
    }

    // TODO: Нужно найти более чистый способ добиться этого
    public static function findConsiderRole()
    {
        $query = Order::find();

        if (SupportRoleHelper::isCurrentyIdentitySupport()) {
            $tableName = Order::tableName();
            $query->andWhere("FROM_UNIXTIME(`$tableName`.`created_at`) >= NOW() - INTERVAL 2 WEEK");
        }

        return $query;
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getRefund()
    {
        return $this->hasOne(Refund::class, ['order_id' => 'id']);
    }

    public function getPaymentOrder()
    {
        return $this->hasOne(PaymentOrder::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}
