<?php

namespace FinancesHubBridge\Dto;

use FinancesHubBridge\Enum\SourceEnum;

class Transaction
{
    public const PAYMENT_TOOL_DATA_PAYMENT_TOKEN = "paymentToken";

    /**
     * @var Customer
     */
    private Customer $customer;

    /**
     * @var string
     */
    private string $paymentTool;

    /**
     * Can be literally anything that's required to make the transaction,
     * for example "Stripe" requires special token generated from user credit card
     *
     * @var array $paymentToolData
     */
    private array $paymentToolData = [];

    /**
     * @var string $company
     */
    private string $company;

    /**
     * @var Product[]
     */
    private array $products;

    /**
     * @var int $orderId
     */
    private int $orderId;

    /**
     * @var float $expectedPriceWithoutTax
     */
    private float $expectedPriceWithoutTax;

    /**
     * @var float $expectedPriceWithTax
     */
    private float $expectedPriceWithTax;

    public function __construct()
    {
        $this->company = SourceEnum::VOLTIGO->value;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return array
     */
    public function getPaymentToolData(): array
    {
        return $this->paymentToolData;
    }

    /**
     * @param array $paymentToolData
     */
    public function setPaymentToolData(array $paymentToolData): void
    {
        $this->paymentToolData = $paymentToolData;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function addPaymentToolData(string $key, mixed $value): void
    {
        $this->paymentToolData[$key] = $value;
    }

    /**
     * Will return data under given key, if however no data is found then null is returned.
     * Null is always considered as "no such key is present in the payment tool data".
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getPaymentToolDataForKey(string $key): mixed
    {
        if (!array_key_exists($key, $this->paymentToolData)) {
            return null;
        }

        return $this->paymentToolData[$key];
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getPaymentTool(): string
    {
        return $this->paymentTool;
    }

    /**
     * @param string $paymentTool
     */
    public function setPaymentTool(string $paymentTool): void
    {
        $this->paymentTool = $paymentTool;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return float
     */
    public function getExpectedPriceWithoutTax(): float
    {
        return $this->expectedPriceWithoutTax;
    }

    /**
     * @param float $expectedPriceWithoutTax
     */
    public function setExpectedPriceWithoutTax(float $expectedPriceWithoutTax): void
    {
        $this->expectedPriceWithoutTax = $expectedPriceWithoutTax;
    }

    /**
     * @return float
     */
    public function getExpectedPriceWithTax(): float
    {
        return $this->expectedPriceWithTax;
    }

    /**
     * @param float $expectedPriceWithTax
     */
    public function setExpectedPriceWithTax(float $expectedPriceWithTax): void
    {
        $this->expectedPriceWithTax = $expectedPriceWithTax;
    }

}
