<?php

namespace FinancesHubBridge\Request\Payment;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles fetching the min & max transaction data per each payment tool
 */
class GetMinMaxTransactionDataRequest extends BaseRequest
{
    private const URI = "api/payment/get-min-max-transaction-data";

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