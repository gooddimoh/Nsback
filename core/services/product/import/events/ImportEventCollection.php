<?php

namespace core\services\product\import\events;

use Closure;

class ImportEventCollection
{
    private Closure $start;

    private Closure $successLoadProduct;
    private Closure $failLoadProduct;

    private Closure $iterationEnd;
    private Closure $iterationFailed;

    private Closure $end;

    public function __construct(
        Closure $start = null,
        Closure $successLoadProduct = null,
        Closure $failLoadProduct = null,
        Closure $iterationEnd = null,
        Closure $iterationFailed = null,
        Closure $end = null
    )
    {
        $emptyCallback = function () {
        };

        $this->start = $start ?: $emptyCallback;

        $this->successLoadProduct = $successLoadProduct ?: $emptyCallback;
        $this->failLoadProduct = $failLoadProduct ?: $emptyCallback;

        $this->iterationEnd = $iterationEnd ?: $emptyCallback;
        $this->iterationFailed = $iterationFailed ?: $emptyCallback;

        $this->end = $end ?: $emptyCallback;
    }

    public function releaseStart()
    {
        return call_user_func($this->start);
    }

    public function releaseSuccessLoadProduct($quantity)
    {
        return call_user_func($this->successLoadProduct, $quantity);
    }

    public function releaseFailLoadProduct($errorMessage)
    {
        return call_user_func($this->failLoadProduct, $errorMessage);
    }

    public function releaseIteration($totalQuantity, $currentNumber)
    {
        return call_user_func($this->iterationEnd, $totalQuantity, $currentNumber);
    }

    public function releaseIterationFailed($errorMessage)
    {
        return call_user_func($this->iterationFailed, $errorMessage);
    }

    public function releaseEnd()
    {
        return call_user_func($this->end);
    }

    /**
     * @param Closure $start
     */
    public function setStart(Closure $start): void
    {
        $this->start = $start;
    }

    /**
     * @param Closure $successLoadProduct
     */
    public function setSuccessLoadProduct(Closure $successLoadProduct): void
    {
        $this->successLoadProduct = $successLoadProduct;
    }

    /**
     * @param Closure $failLoadProduct
     */
    public function setFailLoadProduct(Closure $failLoadProduct): void
    {
        $this->failLoadProduct = $failLoadProduct;
    }

    /**
     * @param Closure $iterationEnd
     */
    public function setIterationEnd(Closure $iterationEnd): void
    {
        $this->iterationEnd = $iterationEnd;
    }

    /**
     * @param Closure $iterationFailed
     */
    public function setIterationFailed(Closure $iterationFailed): void
    {
        $this->iterationFailed = $iterationFailed;
    }

    /**
     * @param Closure $end
     */
    public function setEnd(Closure $end): void
    {
        $this->end = $end;
    }


}