<?php


namespace App\Domain\Exchange\Bittrex\Traits;


use App\Domain\Exchange\Bittrex\BittrexAuthenticate;

Trait SetExchangeAuthenticateTrait
{
    function setExchangeAuthenticate()
    {
        $this->exchangeAuthenticate = new BittrexAuthenticate();
    }
}