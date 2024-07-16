<?php

namespace FinancesHubBridge\Response\Payment\Stripe;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Request\Payment\Stripe\CreatePaymentIntentRequest;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see CreatePaymentIntentRequest}
 */
class CreatePaymentIntentResponse extends BaseResponse
{
    private string $token;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
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
        $token     = $dataArray['token'];

        $response->setToken($token);

        return $response;
    }

}