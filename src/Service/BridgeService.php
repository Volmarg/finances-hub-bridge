<?php

namespace FinancesHubBridge\Service;

use FinancesHubBridge\Request\Currency\GetAllCurrencyCodesRequest;
use FinancesHubBridge\Request\Currency\GetExchangeRateRequest;
use FinancesHubBridge\Request\Invoice\GeneratePdfRequest;
use FinancesHubBridge\Request\InsertTransactionRequest;
use FinancesHubBridge\Request\Payment\GetMinMaxTransactionDataRequest;
use FinancesHubBridge\Request\Payment\GetTaxPercentageRequest;
use FinancesHubBridge\Request\Payment\Stripe\CreatePaymentIntentRequest;
use FinancesHubBridge\Response\Currency\GetAllCurrencyCodesResponse;
use FinancesHubBridge\Response\Currency\GetExchangeRateResponse;
use FinancesHubBridge\Response\Invoice\GeneratePdfResponse;
use FinancesHubBridge\Response\InsertTransactionResponse;
use FinancesHubBridge\Response\Payment\GetMinMaxTransactionDataResponse;
use FinancesHubBridge\Response\Payment\GetTaxPercentageResponse;
use FinancesHubBridge\Response\Payment\Stripe\CreatePaymentIntentResponse;
use GuzzleHttp\Exception\ClientException;
use FinancesHubBridge\Request\BaseRequest;
use FinancesHubBridge\Response\BaseResponse;
use FinancesHubBridge\Service\External\GuzzleHttpService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use FinancesHubBridge\Service\Jwt\JwtTokenService;
use FinancesHubBridge\Service\Serializer\SerializerService;
use LogicException;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Throwable;
use TypeError;

/**
 * Used for performing calls toward other / external service (project)
 * @package FinancesHubBridge
 */
class BridgeService
{
    private const TOKEN_QUERY_NAME = "token";

    private GuzzleHttpService $guzzleHttpService;

    private Logger $logger;

    public function __construct(
        private readonly JwtTokenService $jwtTokenService,
        readonly string                  $logFilePath,
        readonly string                  $loggerName,
        readonly string                  $baseUrl
    ) {
        $logHandler = new RotatingFileHandler($this->logFilePath, 4, Logger::DEBUG);

        $this->guzzleHttpService = new GuzzleHttpService();
        $this->logger            = new Logger($loggerName);
        $this->logger->pushHandler($logHandler);
    }

    /**
     * Get content of invoice pdf
     *
     * @throws GuzzleException
     */
    public function generatePdf(GeneratePdfRequest $request): GeneratePdfResponse
    {
        $response = new GeneratePdfResponse();

        /** @var GeneratePdfResponse $baseResponse */
        $baseResponse = $this->sendRequest($request, $response);

        return $baseResponse;
    }

    /**
     * Insert the transaction data
     *
     * @throws GuzzleException
     */
    public function insertTransaction(InsertTransactionRequest $request): InsertTransactionResponse
    {
        $response = new InsertTransactionResponse();

        /** @var InsertTransactionResponse $baseResponse */
        $baseResponse = $this->sendRequest($request, $response);

        return $baseResponse;
    }

    /**
     * Get exchange rate for provided currencies
     *
     * @param GetExchangeRateRequest $request
     *
     * @return GetExchangeRateResponse
     *
     * @throws GuzzleException
     */
    public function getExchangeRate(GetExchangeRateRequest $request) : GetExchangeRateResponse
    {
        $response = new GetExchangeRateResponse();

        /** @var GetExchangeRateResponse $baseResponse */
        $baseResponse = $this->sendRequest($request, $response);

        return $baseResponse;
    }

    /**
     * Get all existing currency codes
     *
     * @param GetAllCurrencyCodesRequest $request
     *
     * @return GetAllCurrencyCodesResponse
     *
     * @throws GuzzleException
     */
    public function getAllCurrencyCodes(GetAllCurrencyCodesRequest $request) : GetAllCurrencyCodesResponse
    {
        $response = new GetAllCurrencyCodesResponse();

        /** @var GetAllCurrencyCodesResponse $baseResponse */
        $baseResponse = $this->sendRequest($request, $response);

        return $baseResponse;
    }

    /**
     * Get system-wide active tax percentage
     *
     * @param GetTaxPercentageRequest $request
     *
     * @return GetTaxPercentageResponse
     *
     * @throws GuzzleException
     */
    public function getTaxPercentage(GetTaxPercentageRequest $request) : GetTaxPercentageResponse
    {
        $response = new GetTaxPercentageResponse();

        /** @var GetTaxPercentageResponse $filledResponse */
        $filledResponse = $this->sendRequest($request, $response);

        return $filledResponse;
    }

    /**
     * Get the transaction min & max payment data for each supported payment tool
     *
     * @param GetMinMaxTransactionDataRequest $request
     *
     * @return GetMinMaxTransactionDataResponse
     *
     * @throws GuzzleException
     */
    public function getMinMaxTransactionData(GetMinMaxTransactionDataRequest $request) : GetMinMaxTransactionDataResponse
    {
        $response = new GetMinMaxTransactionDataResponse();

        /** @var GetMinMaxTransactionDataResponse $filledResponse */
        $filledResponse = $this->sendRequest($request, $response);

        return $filledResponse;
    }

    /**
     * Returns token that can be used on front with custom workflow as mentioned in:
     * - {@link https://stripe.com/docs/payments/quickstart}
     *
     * @param CreatePaymentIntentRequest $request
     *
     * @return CreatePaymentIntentResponse
     *
     * @throws GuzzleException
     */
    public function createStripePaymentIntent(CreatePaymentIntentRequest $request) : CreatePaymentIntentResponse
    {
        $response = new CreatePaymentIntentResponse();

        /** @var CreatePaymentIntentResponse $filledResponse */
        $filledResponse = $this->sendRequest($request, $response);

        return $filledResponse;
    }

    /**
     * Performs base request for any type of request and returns base response
     *
     * @param BaseRequest  $baseRequest
     * @param BaseResponse $response
     *
     * @return BaseResponse
     * @throws GuzzleException
     */
    private function sendRequest(BaseRequest $baseRequest, BaseResponse $response): BaseResponse
    {
        try {
            $jwtToken          = $this->jwtTokenService->encode();
            $absoluteCalledUrl = $this->buildAbsoluteCalledUrlForRequest($baseRequest, $jwtToken);

            $this->logCalledApiMethod($baseRequest, $absoluteCalledUrl);

            $guzzleResponse = $this->sendGuzzleRequest($baseRequest, $absoluteCalledUrl);
            $response->prefillBaseFieldsFromJsonString($guzzleResponse);

            $this->logResponse($response);
        } catch (Exception|TypeError $e) {
            $this->logThrowable($e);

            if ($e instanceof ClientException) {
                if (
                        $e->getResponse()->getStatusCode() >= 400
                    &&  $e->getResponse()->getStatusCode() < 500
                ) {
                    return $response->prefillBadRequest($e->getResponse()->getStatusCode());
                }
            }

            return $response->prefillInternalBridgeError($e->getMessage());
        }

        return $response;
    }

    /**
     * Will return the absolute url to be called by guzzle
     *
     * @param BaseRequest $request
     * @param string      $jwtToken
     *
     * @return string
     */
    private function buildAbsoluteCalledUrlForRequest(BaseRequest $request, string $jwtToken): string
    {
        $outputUrl = $this->baseUrl;
        if (!str_ends_with($outputUrl, DIRECTORY_SEPARATOR)) {
            $outputUrl .= DIRECTORY_SEPARATOR;
        }

        return $outputUrl . $request->getRequestUri() . "?" . self::TOKEN_QUERY_NAME . "=" . $jwtToken;
    }

    /**
     * @param Throwable $e
     */
    private function logThrowable(Throwable $e): void
    {
        $this->logger->critical("Exception was thrown", [
            "message" => $e->getMessage(),
            "code"    => $e->getCode(),
            "trace"   => $e->getTraceAsString(),
        ]);
    }

    /**
     * Will log information about current api call
     *
     * @param BaseRequest $request
     * @param string      $absoluteCalledUrl
     */
    private function logCalledApiMethod(BaseRequest $request, string $absoluteCalledUrl): void
    {
        $this->logger->info("Now calling api: ", [
            "calledMethod" => debug_backtrace()[1]['function'] ?? 'unknown', // need to use backtrace to get the correct calling method
            "baseUrl"      => $absoluteCalledUrl,
            "requestUri"   => $request->getRequestUri(),
        ]);
    }

    /**
     * Will log the response data
     *
     * @param BaseResponse $response
     */
    private function logResponse(BaseResponse $response): void
    {
        $this->logger->info("Got response from called endpoint", [
            "response" => $response->toJson(),
        ]);
    }

    /**
     * Will send request via guzzle and return the string response
     *
     * @param BaseRequest $baseRequest
     * @param string      $absoluteCalledUrl
     *
     * @return string
     * @throws GuzzleException
     */
    private function sendGuzzleRequest(BaseRequest $baseRequest, string $absoluteCalledUrl): string
    {
        $baseRequestJson  = SerializerService::getSerializer()->serialize($baseRequest, "json");
        $baseRequestArray = json_decode($baseRequestJson, true);

        switch ($baseRequest->getRequestMethod()) {
            case Request::METHOD_POST:
            {
                return $this->guzzleHttpService->sendPostRequest($absoluteCalledUrl, $baseRequestArray);
            }

            case Request::METHOD_GET:
            {
                return $this->guzzleHttpService->sendGetRequest($absoluteCalledUrl);
            }

            default:
            {
                throw new LogicException("Sending guzzle request for method type: {$baseRequest->getRequestMethod()}");
            }
        }
    }

}