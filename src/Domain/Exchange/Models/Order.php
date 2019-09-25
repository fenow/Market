<?php


namespace App\Domain\Exchange\Models;


class Order
{
    /** @var string $orderUuid */
    protected $orderUuid;

    /** @var string $pair */
    protected $pair;

    /** @var string $type */
    protected $type;

    /** @var float $quantity */
    protected $quantity;

    /** @var float $commissionPaid */
    protected $commissionPaid;

    /** @var float $price */
    protected $price;

    /** @var float $pricePerUnit */
    protected $pricePerUnit;

    /** @var \DateTime $createdAt */
    protected $createdAt;

    /** @var \DateTime|null $closedAt */
    protected $closedAt;

    /**
     * @return string
     */
    public function getOrderUuid(): string
    {
        return $this->orderUuid;
    }

    /**
     * @param string $orderUuid
     * @return Order
     */
    public function setOrderUuid(string $orderUuid): self
    {
        $this->orderUuid = $orderUuid;

        return $this;
    }

    /**
     * @return string
     */
    public function getPair(): string
    {
        return $this->pair;
    }

    /**
     * @param string $pair
     * @return Order
     */
    public function setPair(string $pair): self
    {
        $this->pair = $pair;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Order
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }


    /**
     * @param float $quantity
     * @return Order
     */
    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getCommissionPaid(): float
    {
        return $this->commissionPaid;
    }

    /**
     * @param float $commissionPaid
     * @return Order
     */
    public function setCommissionPaid(float $commissionPaid): self
    {
        $this->commissionPaid = $commissionPaid;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Order
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getPricePerUnit(): float
    {
        return $this->pricePerUnit;
    }

    /**
     * @param float $pricePerUnit
     * @return Order
     */
    public function setPricePerUnit(float $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getClosedAt(): \DateTime
    {
        return $this->closedAt;
    }

    /**
     * @param \DateTime|null $closedAt
     * @return Order
     */
    public function setClosedAt(\DateTime $closedAt): self
    {
        $this->closedAt = $closedAt;

        return $this;
    }
}