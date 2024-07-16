<?php

namespace FinancesHubBridge\Response\Payment;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Request\Payment\GetMinMaxTransactionDataRequest;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see GetMinMaxTransactionDataRequest}
 */
class GetMinMaxTransactionDataResponse extends BaseResponse
{
    private float  $paypalMinTransaction;
    private float  $paypalMaxTransaction;
    private string $paypalTransactionBaseCurrency;

    private float  $stripeMinTransaction;
    private float  $stripeMaxTransaction;
    private string $stripeTransactionBaseCurrency;

    public function getPaypalMinTransaction(): float
    {
        return $this->paypalMinTransaction;
    }

    public function setPaypalMinTransaction(float $paypalMinTransaction): void
    {
        $this->paypalMinTransaction = $paypalMinTransaction;
    }

    public function getPaypalMaxTransaction(): float
    {
        return $this->paypalMaxTransaction;
    }

    public function setPaypalMaxTransaction(float $paypalMaxTransaction): void
    {
        $this->paypalMaxTransaction = $paypalMaxTransaction;
    }

    public function getPaypalTransactionBaseCurrency(): string
    {
        return $this->paypalTransactionBaseCurrency;
    }

    public function setPaypalTransactionBaseCurrency(string $paypalTransactionBaseCurrency): void
    {
        $this->paypalTransactionBaseCurrency = $paypalTransactionBaseCurrency;
    }

    public function getStripeMinTransaction(): float
    {
        return $this->stripeMinTransaction;
    }

    public function setStripeMinTransaction(float $stripeMinTransaction): void
    {
        $this->stripeMinTransaction = $stripeMinTransaction;
    }

    public function getStripeMaxTransaction(): float
    {
        return $this->stripeMaxTransaction;
    }

    public function setStripeMaxTransaction(float $stripeMaxTransaction): void
    {
        $this->stripeMaxTransaction = $stripeMaxTransaction;
    }

    public function getStripeTransactionBaseCurrency(): string
    {
        return $this->stripeTransactionBaseCurrency;
    }

    public function setStripeTransactionBaseCurrency(string $stripeTransactionBaseCurrency): void
    {
        $this->stripeTransactionBaseCurrency = $stripeTransactionBaseCurrency;
    }

    /**
     * {@inheritDoc}
     * @param string $json
     *
     * @return $this
     * @throws MalformedJsonException
     */
    public function prefillBaseFieldsFromJsonString(string $json): static
    {
        $response  = parent::prefillBaseFieldsFromJsonString($json);
        $dataArray = json_decode($json, true);

        $paypalMinTransaction          = $dataArray['paypalMinTransaction'];
        $paypalMaxTransaction          = $dataArray['paypalMaxTransaction'];
        $paypalTransactionBaseCurrency = $dataArray['paypalTransactionBaseCurrency'];

        $response->setPaypalMinTransaction($paypalMinTransaction);
        $response->setPaypalMaxTransaction($paypalMaxTransaction);
        $response->setPaypalTransactionBaseCurrency($paypalTransactionBaseCurrency);

        $stripeMinTransaction          = $dataArray['stripeMinTransaction'];
        $stripeMaxTransaction          = $dataArray['stripeMaxTransaction'];
        $stripeTransactionBaseCurrency = $dataArray['stripeTransactionBaseCurrency'];

        $response->setStripeMinTransaction($stripeMinTransaction);
        $response->setStripeMaxTransaction($stripeMaxTransaction);
        $response->setStripeTransactionBaseCurrency($stripeTransactionBaseCurrency);

        return $response;
    }

}