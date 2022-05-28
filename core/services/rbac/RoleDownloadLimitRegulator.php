<?php

namespace core\services\rbac;

use common\rbac\Roles;
use core\dispatchers\EventDispatcher;
use core\entities\order\events\DownloadLimitReachedEvent;
use core\entities\order\ManagerDownload;
use core\repositories\rbac\ManagerDownloadRepository;
use core\repositories\order\OrderRepository;
use core\services\order\OrderService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;

class RoleDownloadLimitRegulator
{
    const LIMIT_OF_DOWNLOAD_LIST = [
        Roles::ROLE_ADMINISTRATOR => 50,
        Roles::ROLE_SENIOR_MANAGER => 150,
        Roles::ROLE_SUPPORT => 65,
    ];

    private $orderService;
    private $downloadRecords;
    private $eventDispatcher;
    private $authManager;
    private $orders;

    public function __construct(
        OrderService              $orderService,
        ManagerDownloadRepository $downloadRecords,
        EventDispatcher           $eventDispatcher,
        ManagerInterface          $authManager,
        OrderRepository $orders
    )
    {
        $this->orderService = $orderService;
        $this->downloadRecords = $downloadRecords;
        $this->eventDispatcher = $eventDispatcher;
        $this->authManager = $authManager;
        $this->orders = $orders;
    }

    public function download($orderId, $userId)
    {
        $this->exam($userId);
        $this->increaseDownloadCounter($orderId, $userId);

        return $this->orderService->download($orderId, false);
    }

    public function resultUrl($orderId, $userId)
    {
        $this->exam($userId);
        $this->increaseDownloadCounter($orderId, $userId);

        $order = $this->orders->get($orderId);

        return Yii::$app->frontendUrlManager
            ->createAbsoluteUrl(['order/view', 'code' => $order->code, 'email' => $order->email], "https");
    }

    protected function exam($userId)
    {
        $downloadQuantity = $this->downloadRecords->countUserDaily($userId);
        $limit = $this->getLimitQuantity($userId);

        if ($downloadQuantity >= $limit) {
            $this->eventDispatcher->dispatch(new DownloadLimitReachedEvent($downloadQuantity, $userId));
            throw new \DomainException("Лимит загрузки товаров достигнут");
        }
    }

    protected function getLimitQuantity($userId)
    {
        $roles = $this->authManager->getRolesByUser($userId);
        $limit = 0;

        if (!$roles) {
            throw new \DomainException("Вы не имеете ролей");
        }

        foreach ($roles as $role) {
            $limitByRole = ArrayHelper::getValue(self::LIMIT_OF_DOWNLOAD_LIST, $role->name, 0);
            $limit = max($limitByRole, $limit);
        }

        if ($limit === 0) {
            throw new \DomainException("Ваша роль не позволяет загрузить товар");
        }

        return $limit;
    }

    protected function increaseDownloadCounter($userId, $orderId)
    {
        $record = ManagerDownload::make($userId, $orderId);
        $this->downloadRecords->save($record);
    }

}