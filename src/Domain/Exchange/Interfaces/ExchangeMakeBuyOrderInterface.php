<?php

namespace App\Domain\Exchange\Interfaces;

use App\Entity\Session;

interface ExchangeMakeBuyOrderInterface
{
    public function makeBuyOrder(Session $session, float $quantity, float $rate): string;
}
