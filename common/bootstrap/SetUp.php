<?php

namespace common\bootstrap;

use core\dispatchers\EventDispatcher;
use core\dispatchers\SimpleEventDispatcher;
use core\entities\order\events\OrderPendingEvent;
use core\entities\product\events\ProductPassedModeration;
use core\entities\order\events\DownloadLimitReachedEvent;
use core\entities\order\events\OrderErrorEvent;
use core\entities\order\events\OrderRefundEvent;
use core\entities\order\events\OrderCreatedEvent;
use core\entities\order\events\PaymentCompletedEvent;
use core\entities\order\events\PaymentCreatedEvent;
use core\lib\djekxa\DjekxaClient;
use core\lib\reporter\TelegramReporter;
use core\lib\telegram\TelegramMessage;
use core\lib\unisender\logger\DummyLoggerMail;
use core\lib\unisender\UnisenderWrapper;
use core\listeners\order\OrderPendingListener;
use core\listeners\product\ProductPassedModerationListener;
use core\listeners\order\ManagerDownloadLimitReachedListener;
use core\listeners\order\OrderErrorListener;
use core\listeners\order\OrderRefundListener;
use core\listeners\order\PaymentCreatedListener;
use core\payment\common\ReceiptFactory;
use core\payment\lava\LavaClient;
use core\listeners\order\OrderCreatedListener;
use core\listeners\order\PaymentCompletedListener;
use core\payment\qiwiInvoice\QiwiInvoiceReceipt;
use core\repositories\order\OrderRepository;
use core\services\auth\verify\TelegramSender;
use core\services\auth\verify\VerifySenderInterface;
use core\services\order\UnsavedPurchaseService;
use core\settings\storage\LavaSettings;
use core\settings\storage\QiwiCardSettings;
use core\settings\storage\QiwiInvoiceSettings;
use Unisender\ApiWrapper\UnisenderApi;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;


class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(TelegramMessage::class, function () use ($app) {
            return new TelegramMessage($app->params['telegram.token']);
        });

        $container->set(DjekxaClient::class, function () use ($app) {
            return new DjekxaClient($app->params['djekxa.apiKey']);
        });

        $container->setSingleton(UnsavedPurchaseService::class, function () use ($container, $app) {
            return new UnsavedPurchaseService(
                $container->get(OrderRepository::class),
                $container->get(TelegramReporter::class, ['to' => $app->params['telegram.developerChat.id']])
            );
        });

        $container->setSingleton(ReceiptFactory::ALIAS_QIWI_P2P, function () use ($container) {
            return new QiwiInvoiceReceipt($container->get(QiwiInvoiceSettings::class));
        });

        $container->setSingleton(ReceiptFactory::ALIAS_QIWI_CARD, function () use ($container) {
            return new QiwiInvoiceReceipt($container->get(QiwiCardSettings::class));
        });

        $container->setSingleton(VerifySenderInterface::class, function () use ($container) {
            return $container->get(TelegramSender::class);
        });

        $container->setSingleton(UnisenderApi::class, function () use ($app) {
            return new UnisenderApi($app->params['unisender.apiKey']);
        });

        $container->setSingleton(LavaClient::class, function () use ($container) {
            /** @var $settings LavaSettings */
            $settings = $container->get(LavaSettings::class);
            return new LavaClient($settings->getJwtToken());
        });

        $container->setSingleton(UnisenderWrapper::class, function (Container $container) use ($app) {
            return new UnisenderWrapper(
                $container->get(UnisenderApi::class),
                $container->get(DummyLoggerMail::class),
                $app->params['unisender.sender.name'],
                $app->params['unisender.sender.email'],
                $app->params['unisender.listId']
            );
        });

        $container->setSingleton(EventDispatcher::class, function (Container $container) {
            return new SimpleEventDispatcher($container, [
                PaymentCreatedEvent::class => [PaymentCreatedListener::class],
                PaymentCompletedEvent::class => [PaymentCompletedListener::class],
                OrderCreatedEvent::class => [OrderCreatedListener::class],
                OrderPendingEvent::class => [OrderPendingListener::class],
                ProductPassedModeration::class => [ProductPassedModerationListener::class],
                OrderRefundEvent::class => [OrderRefundListener::class],
                OrderErrorEvent::class => [OrderErrorListener::class],
                DownloadLimitReachedEvent::class => [ManagerDownloadLimitReachedListener::class],
            ]);
        });

    }
}