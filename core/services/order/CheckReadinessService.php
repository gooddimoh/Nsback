<?php

namespace core\services\order;

use core\lib\productProvider\ProductNotFoundException;
use core\lib\productProvider\ProviderFactory;
use core\repositories\product\ProductRepository;

/**
 * Проверяет доступен ли заказ Поставщика к покупке.
 * @warning При смене значений констант сценариев, или добавлении новых - обрабатывайте это на front-end
 */
class CheckReadinessService
{
    const SCENARIO_NOT_FOUND = "not_found";
    const SCENARIO_NOT_AVAILABLE = "not_available";
    const SCENARIO_NO_REQUIRED_AMOUNT = "not_required_amount";

    private $providerFactory;
    private $productRepository;

    public function __construct(ProviderFactory $providerFactory, ProductRepository $productRepository)
    {
        $this->providerFactory = $providerFactory;
        $this->productRepository = $productRepository;
    }

    public function check($requiredQuantity, $productId): array
    {
        $product = $this->productRepository->get($productId);
        $finder = $this->providerFactory->createFinderClass($product->productImport->shop->platform);

        try {
            $providerProduct = $finder->get($product);

            if ($providerProduct->quantity === 0) {
                return $this->unsuccessfulResult(self::SCENARIO_NOT_AVAILABLE);
            }
            if ($requiredQuantity > $providerProduct->quantity) {
                return $this->unsuccessfulResult(self::SCENARIO_NO_REQUIRED_AMOUNT, ['quantity' => $providerProduct->quantity]);
            }

            return $this->successfulResult();
        } catch (ProductNotFoundException $exception) {
            return $this->unsuccessfulResult(self::SCENARIO_NOT_FOUND);
        }
    }

    protected function unsuccessfulResult($scenario, array $additional = []): array
    {
        return array_merge(['success' => false, 'scenario' => $scenario], $additional);
    }

    protected function successfulResult(): array
    {
        return ['success' => true];
    }

}