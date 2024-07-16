<?php

namespace FinancesHubBridge\Request\Currency;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles fetching the exchange rate for provided currencies:
 */
class GetExchangeRateRequest extends BaseRequest
{
    private const URI = "api/currency/get-exchange-rate/";

    private string $fromCurrency;
    private string $targetCurrency;

    /**
     * @return string
     */
    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    /**
     * @param string $fromCurrency
     */
    public function setFromCurrency(string $fromCurrency): void
    {
        $this->fromCurrency = $fromCurrency;
    }

    /**
     * @return string
     */
    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }

    /**
     * @param string $targetCurrency
     */
    public function setTargetCurrency(string $targetCurrency): void
    {
        $this->targetCurrency = $targetCurrency;
    }

    /**
     * {@inherticdoc}
     */
    public function getRequestUri(): string
    {
        $uri = self::URI . $this->getFromCurrency() . DIRECTORY_SEPARATOR . $this->getTargetCurrency();

        return $uri;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }
}