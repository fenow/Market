<?php

namespace App\Domain\Exchange\Bittrex\Traits;

use App\Domain\Exchange\Bittrex\BittrexAuthenticate;

trait SetExchangeAuthenticateTrait
{
    public function setExchangeAuthenticate()
    {
        $this->exchangeAuthenticate = new BittrexAuthenticate();
    }
}
