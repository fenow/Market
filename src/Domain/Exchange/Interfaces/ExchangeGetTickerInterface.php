<?php


namespace App\Domain\Exchange\Interfaces;


use App\Domain\Exchange\Models\Ticker;

interface ExchangeGetTickerInterface
{
    public function getTicker(string $pair) : Ticker;
}