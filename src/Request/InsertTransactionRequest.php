<?php

namespace FinancesHubBridge\Request;

use FinancesHubBridge\Dto\Transaction;
use Symfony\Component\HttpFoundation\Request;

class InsertTransactionRequest extends BaseRequest
{
    private const URI = "api/transaction/insert";

    private Transaction $transaction;

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @param Transaction $transaction
     */
    public function setTransaction(Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }

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
        return Request::METHOD_POST;
    }

}