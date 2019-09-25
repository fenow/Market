<?php

namespace App\Domain\Exchange\Models;

class Balance
{
    /** @var string $currency */
    protected $currency;

    /** @var float $balance */
    protected $balance;

    /** @var float $available */
    protected $available;

    /** @var float $pending */
    protected $pending;

    public function __construct(string $currency, float $balance, float $available, float $pending)
    {
        $this->currency = $currency;
        $this->balance = $balance;
        $this->available = $available;
        $this->pending = $pending;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @return float
     */
    public function getAvailable(): float
    {
        return $this->available;
    }

    /**
     * @return float
     */
    public function getPending(): float
    {
        return $this->pending;
    }
}