<?php

namespace FinancesHubBridge\Response\Currency;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see GetExchangeRateRequest}
 */
class GetExchangeRateResponse extends BaseResponse
{
    private ?float $exchangeRate;

    /**
     * @return float|null
     */
    public function getExchangeRate(): ?float
    {
        return $this->exchangeRate;
    }

    /**
     * @param float|null $exchangeRate
     */
    public function setExchangeRate(?float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
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
        $response     = parent::prefillBaseFieldsFromJsonString($json);
        $dataArray    = json_decode($json, true);
        $exchangeRate = $dataArray['exchangeRate'] ?? null;

        $response->setExchangeRate($exchangeRate);

        return $response;
    }

}