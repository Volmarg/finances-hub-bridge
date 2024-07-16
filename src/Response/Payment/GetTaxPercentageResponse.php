<?php

namespace FinancesHubBridge\Response\Payment;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Request\Payment\GetTaxPercentageRequest;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see GetTaxPercentageRequest}
 */
class GetTaxPercentageResponse extends BaseResponse
{
    private ?float $taxPercentage;

    /**
     * @return float
     */
    public function getTaxPercentage(): float
    {
        return $this->taxPercentage;
    }

    /**
     * @param float $taxPercentage
     */
    public function setTaxPercentage(float $taxPercentage): void
    {
        $this->taxPercentage = $taxPercentage;
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
        $taxPercentage = $dataArray['taxPercentage'];

        $response->setTaxPercentage($taxPercentage);

        return $response;
    }

}