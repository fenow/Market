<?php

namespace App\Domain\Exchange\Interfaces;

use App\Domain\Exchange\Models\Balance;

interface ExchangeGetBalanceInterface
{
    public function getBalance(string $currency): Balance;
}
