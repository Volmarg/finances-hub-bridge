<?php

namespace FinancesHubBridge\Request\Payment\Stripe;

use FinancesHubBridge\Request\BaseRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Requests the token that can be used on front with:
 * - {@link https://www.npmjs.com/package/@stripe/stripe-js}
 *
 * to display the:
 * - {@link https://stripe.com/docs/payments/accept-a-payment?platform=web&ui=embedded-checkout}
 */
class CreatePaymentIntentRequest extends BaseRequest
{
    private const URI = "api/stripe/payment/intent/create-token";

    private float $price;
    private string $currencyCode;
    private ?string $buyerEmailAddress = null;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getBuyerEmailAddress(): ?string
    {
        return $this->buyerEmailAddress;
    }

    public function setBuyerEmailAddress(?string $buyerEmailAddress): void
    {
        $this->buyerEmailAddress = $buyerEmailAddress;
    }

    /**
     * {@inherticdoc}
     */
    public function getRequestUri(): string
    {
        return self::URI;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }
}