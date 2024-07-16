<?php

namespace FinancesHubBridge\Dto;

class Product
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var float $cost
     */
    private float $cost;

    /**
     * @var float $costWithTax
     */
    private float $costWithTax;

    /**
     * @var bool $includeTax
     */
    private bool $includeTax = true;

    /**
     * @var float $taxPercentage
     */
    private float $taxPercentage;

    /**
     * @var int $quantity
     */
    private int $quantity;

    /**
     * @var string $currency
     */
    private string $currency;

    /**
     * @var int $id
     */
    private int $id;

    /**
     * @var int $productSnapshotId
     */
    private int $productSnapshotId;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @return bool
     */
    public function isIncludeTax(): bool
    {
        return $this->includeTax;
    }

    /**
     * @param bool $includeTax
     */
    public function setIncludeTax(bool $includeTax): void
    {
        $this->includeTax = $includeTax;
    }

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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getCostWithTax(): float
    {
        return $this->costWithTax;
    }

    /**
     * @param float $costWithTax
     */
    public function setCostWithTax(float $costWithTax): void
    {
        $this->costWithTax = $costWithTax;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getProductSnapshotId(): int
    {
        return $this->productSnapshotId;
    }

    /**
     * @param int $productSnapshotId
     */
    public function setProductSnapshotId(int $productSnapshotId): void
    {
        $this->productSnapshotId = $productSnapshotId;
    }

}
