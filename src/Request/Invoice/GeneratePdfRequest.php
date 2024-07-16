<?php

namespace FinancesHubBridge\Request\Invoice;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Request for getting the pdf content of the invoice generated for transaction id
 */
class GeneratePdfRequest extends BaseRequest
{
    private const URI = "api/invoice/generate-pdf/";

    private int $orderId;

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * {@inherticdoc}
     */
    public function getRequestUri(): string
    {
        $uri = self::URI . $this->getOrderId() . DIRECTORY_SEPARATOR . $this->getCompanyName();

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