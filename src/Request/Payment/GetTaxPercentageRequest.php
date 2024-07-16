<?php

namespace FinancesHubBridge\Request\Payment;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles fetching the exchange rate for provided currencies:
 */
class GetTaxPercentageRequest extends BaseRequest
{
    private const URI = "api/payment/get-active-tax-percentage";

    /**
     * {@inherticdoc}
     */
    public function getRequestUri(): string
    {
        $uri = self::URI;

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