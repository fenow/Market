<?php


namespace App\Domain\Exchange\Interfaces;


use App\Entity\Session;

interface ExchangeMakeSellOrderInterface
{
    public function makeSellOrder(Session $session, float $quantity, float $rate): string;
}