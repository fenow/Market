<?php


namespace App\Domain\Exchange\Bittrex;

use App\Domain\Api\AbstractApiCallAuthenticated;
use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiEchangeAuthenticateMissing;
use App\Domain\Exchange\Bittrex\Traits\SetExchangeAuthenticateTrait;
use App\Domain\Exchange\Interfaces\ExchangeGetBalanceInterface;
use App\Domain\Exchange\Models\Balance;


class BittrexExchangeGetBalance extends AbstractApiCallAuthenticated implements ExchangeGetBalanceInterface
{
    use SetExchangeAuthenticateTrait;

    protected $method = 'GET';
    protected $url = 'https://api.bittrex.com/api/v1.1/account/getbalance';

    /**
     * @param string $currency
     * @return Balance
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     * @throws ApiEchangeAuthenticateMissing
     */
    public function getBalance(string $currency): Balance
    {
        $content = $this->call(['query'=>['currency'=>$currency]], ApiInputEnum::JSON);

        if(isset($content->success) && true === $content->success) {
            return new Balance(
                $content->result->Currency,
                $content->result->Balance,
                $content->result->Available,
                $content->result->Pending
            );
        }

        throw new ApiError(isset($content->message) ? $content->message : 'No result founded');
    }
}