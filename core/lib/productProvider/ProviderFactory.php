<?php

namespace core\lib\productProvider;

use core\entities\shop\Shop;
use core\lib\djekxa\services\DjekxaBuy;
use core\lib\djekxa\services\DjekxaImport;
use core\lib\djekxa\services\DjekxaFinder;
use core\lib\leqshop\services\LeqshopBuy;
use core\lib\leqshop\services\LeqshopImport;
use core\lib\leqshop\services\LeqshopFinder;
use core\lib\raptor\RaptorBuy;
use core\lib\raptor\RaptorImport;
use core\lib\raptor\RaptorFinder;

class ProviderFactory
{
    private $container;

    public function __construct()
    {
        // Теряет настроенные зависимости в \common\bootstrap\SetUp
        // если конфигурировать через __construct(Container $container)
        $this->container = \Yii::$container;
    }

    protected static $buyMap = [
        Shop::PLATFORM_LEQSHOP => LeqshopBuy::class,
        Shop::PLATFORM_DJEKXA => DjekxaBuy::class,
        Shop::PLATFORM_RAPTOR => RaptorBuy::class,
    ];

    protected static $finderMap = [
        Shop::PLATFORM_LEQSHOP => LeqshopFinder::class,
        Shop::PLATFORM_DJEKXA => DjekxaFinder::class,
        Shop::PLATFORM_RAPTOR => RaptorFinder::class,
    ];

    protected static $importMap = [
        Shop::PLATFORM_LEQSHOP => LeqshopImport::class,
        Shop::PLATFORM_DJEKXA => DjekxaImport::class,
        Shop::PLATFORM_RAPTOR => RaptorImport::class,
    ];

    /**
     * @param $platform
     * @return ImportInterface|object
     */
    public function createImportClass($platform)
    {
        return $this->creator($platform, self::$importMap, ImportInterface::class);
    }

    /**
     * @param $platform
     * @return FinderInterface|object
     */
    public function createFinderClass($platform)
    {
        return $this->creator($platform, self::$finderMap, FinderInterface::class);
    }

    /**
     * @param $platform
     * @return BuyInterface|object
     */
    public function createBuyClass($platform)
    {
        return $this->creator($platform, self::$buyMap, BuyInterface::class);
    }

    protected function creator($platform, array $map, $implementClass)
    {
        foreach ($map as $key => $class) {
            if ($platform === $key) {
                $targetObject = $this->container->get($class);

                if (!$targetObject instanceof $implementClass) {
                    throw new \RuntimeException(get_class($targetObject) . " must be instance of " . $implementClass);
                }

                return $targetObject;
            }
        }

        throw new \InvalidArgumentException("Unsupported platform: $platform");
    }

}