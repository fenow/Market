<?php

namespace App\Domain\Exchange\Models;

class Ticker
{
    /** @var float $bid */
    protected $bid;

    /** @var float $last */
    protected $last;

    /** @var float $ask */
    protected $ask;

    public function __construct(float $bid, float $ask, float $last)
    {
        $this->bid = $bid;
        $this->ask = $ask;
        $this->last = $last;
    }

    /**
     * @return float
     */
    public function getBid(): float
    {
        return $this->bid;
    }

    /**
     * @return float
     */
    public function getLast(): float
    {
        return $this->last;
    }

    /**
     * @return float
     */
    public function getAsk(): float
    {
        return $this->ask;
    }
}
