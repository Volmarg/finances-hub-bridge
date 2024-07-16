<?php

namespace FinancesHubBridge\Request\Currency;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles fetching all the currency codes
 */
class GetAllCurrencyCodesRequest extends BaseRequest
{
    private const URI = "api/currency/get-all-codes";

    /**
     * @var string $locale
     */
    private string $locale = "en";

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * {@inherticdoc}
     */
    public function getRequestUri(): string
    {
        $uri = self::URI . DIRECTORY_SEPARATOR . $this->getLocale();

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