<?php


namespace App\Domain\Exchange\Interfaces;


use App\Domain\Exchange\Models\Balance;

interface ExchangeGetBalanceInterface
{
    function getBalance(string $currency): Balance;
}