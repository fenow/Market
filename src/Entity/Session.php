<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Interfaces\EntityIdInterface;
use App\Entity\Interfaces\EntityTimestampableInterface;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 * @ApiResource
 */
class Session implements EntityIdInterface, EntityTimestampableInterface
{
    use EntityIdTrait;
    use EntityTimestampableTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $market;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pair;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $status = SessionStatusEnum::Created;

    /**
     * @var float $priceWatched
     * @ORM\Column(type="float")
     */
    private $priceWatched;

    /**
     * @var \DateTime $watchedAt
     * @ORM\Column(type="datetime")
     */
    private $watchedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceBuyed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $buyedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantityBuyed;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceSold;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $soldAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $marketBuyOrderId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $marketSellOrderId;


    /**
     * @ORM\OneToMany(targetEntity="SessionLog", mappedBy="session")
     */
    private $logs;

    public function __construct()
    {
        $this->logs = new ArrayCollection();
    }


    /**
     * @return float
     */
    public function getPriceWatched(): float
    {
        return $this->priceWatched;
    }

    /**
     * @param float $priceWatched
     * @return Session
     */
    public function setPriceWatched(float $priceWatched): self
    {
        $this->priceWatched = $priceWatched;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getWatchedAt() : \DateTime
    {
        return $this->watchedAt;
    }

    /**
     * @param \DateTime $watchedAt
     * @return Session
     */
    public function setWatchedAt(\DateTime $watchedAt): self
    {
        $this->watchedAt = $watchedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarket(): ?string
    {
        return $this->market;
    }

    /**
     * @param string $market
     * @return Session
     */
    public function setMarket(string $market): self
    {
        $this->market = $market;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPair(): ?string
    {
        return $this->pair;
    }

    /**
     * @param string $pair
     * @return Session
     */
    public function setPair(string $pair): self
    {
        $this->pair = $pair;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Session
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceBuyed(): ?float
    {
        return $this->priceBuyed;
    }

    /**
     * @param float $priceBuyed
     * @return Session
     */
    public function setPriceBuyed(float $priceBuyed): self
    {
        $this->priceBuyed = $priceBuyed;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBuyedAt(): ?\DateTimeInterface
    {
        return $this->buyedAt;
    }

    /**
     * @param \DateTimeInterface $buyedAt
     * @return Session
     */
    public function setBuyedAt(\DateTimeInterface $buyedAt): self
    {
        $this->buyedAt = $buyedAt;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceSold(): ?float
    {
        return $this->priceSold;
    }

    /**
     * @param float $priceSold
     * @return Session
     */
    public function setPriceSold(float $priceSold): self
    {
        $this->priceSold = $priceSold;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSoldAt(): ?\DateTimeInterface
    {
        return $this->soldAt;
    }

    /**
     * @param \DateTimeInterface $soldAt
     * @return Session
     */
    public function setSoldAt(\DateTimeInterface $soldAt): self
    {
        $this->soldAt = $soldAt;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    /**
     * @return string|null
     */
    public function getMarketBuyOrderId(): ?string
    {
        return $this->marketBuyOrderId;
    }

    /**
     * @param string $marketBuyOrderId
     * @return Session
     */
    public function setMarketBuyOrderId(string $marketBuyOrderId): self
    {
        $this->marketBuyOrderId = $marketBuyOrderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarketSellOrderId(): ?string
    {
        return $this->marketSellOrderId;
    }

    /**
     * @param string $marketSellOrderId
     * @return Session
     */
    public function setMarketSellOrderId(string $marketSellOrderId): self
    {
        $this->marketSellOrderId = $marketSellOrderId;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getQuantityBuyed(): ?float
    {
        return $this->quantityBuyed;
    }

    /**
     * @param float $quantityBuyed
     * @return Session
     */
    public function setQuantityBuyed(float $quantityBuyed): self
    {
        $this->quantityBuyed = $quantityBuyed;

        return $this;
    }
}
