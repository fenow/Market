<?php


namespace App\Domain\Exchange\Enum;


use Greg0ire\Enum\AbstractEnum;

final class ExchangeOrderTypeEnum extends AbstractEnum
{
    const BUY = 'buy';
    const SELL = 'sell';
    const BOTH = 'both';
}