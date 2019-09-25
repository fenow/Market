<?php

namespace App\Domain\Exchange\Interfaces;

use App\Domain\Exchange\Models\Order;

interface ExchangeGetOrderInterface
{
    public function getOrder(string $exchangeOrderId): Order;
}
