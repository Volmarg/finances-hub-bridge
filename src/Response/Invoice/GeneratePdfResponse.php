<?php

namespace FinancesHubBridge\Response\Invoice;

use FinancesHubBridge\Exception\MalformedJsonException;
use FinancesHubBridge\Request\Invoice\GeneratePdfRequest;
use FinancesHubBridge\Response\BaseResponse;

/**
 * Response for:
 * - {@see GeneratePdfRequest}
 */
class GeneratePdfResponse extends BaseResponse
{
    private string $pdfBase64Content;

    /**
     * @return string
     */
    public function getPdfBase64Content(): string
    {
        return $this->pdfBase64Content;
    }

    /**
     * @param string $pdfBase64Content
     */
    public function setPdfBase64Content(string $pdfBase64Content): void
    {
        $this->pdfBase64Content = $pdfBase64Content;
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
        $bas64Content = $dataArray['pdfBase64Content'] ?? '';

        $response->setPdfBase64Content($bas64Content);

        return $response;
    }

}