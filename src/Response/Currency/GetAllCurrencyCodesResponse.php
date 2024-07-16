<?php

namespace FinancesHubBridge\Response\Currency;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Request\Currency\GetAllCurrencyCodesRequest;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see GetAllCurrencyCodesRequest}
 */
class GetAllCurrencyCodesResponse extends BaseResponse
{
    private array $currencyCodes = [];

    /**
     * @return array
     */
    public function getCurrencyCodes(): array
    {
        return $this->currencyCodes;
    }

    /**
     * @param array $currencyCodes
     */
    public function setCurrencyCodes(array $currencyCodes): void
    {
        $this->currencyCodes = $currencyCodes;
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
        $response      = parent::prefillBaseFieldsFromJsonString($json);
        $dataArray     = json_decode($json, true);
        $currencyCodes = $dataArray['currencyCodes'] ?? null;

        $response->setCurrencyCodes($currencyCodes);

        return $response;
    }

}