<?php

namespace App\Domain\Api;

use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiEchangeAuthenticateMissing;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Api\Interfaces\ApiCallAuthenticatedInterface;
use App\Domain\Exchange\Interfaces\ExchangeAuthenticateInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiCallAuthenticated extends AbstractApiCall implements ApiCallAuthenticatedInterface
{
    /** @var ?ExchangeAuthenticateInterface $exchangeAuthenticate */
    protected $exchangeAuthenticate;

    public function __construct()
    {
        $this->setExchangeAuthenticate();

        parent::__construct();
    }

    /**
     * @param array $options
     * @param string $outputFormat
     * @return mixed|string
     * @throws ApiEchangeAuthenticateMissing
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    public function call(array $options = [], string $outputFormat = ApiInputEnum::RAW)
    {
        if(is_null($this->url)) {
            throw new ApiUrlMissing();
        }

        if(is_null($this->exchangeAuthenticate)) {
            throw new ApiEchangeAuthenticateMissing();
        }

        $options['query']['apikey'] = $this->exchangeAuthenticate->getApiKey();
        $options['query']['nonce'] = time();

        $options['headers'] = ['apisign' => $this->exchangeAuthenticate->generateSign($this->url, $options['query'])];

        return parent::call($options, $outputFormat);
    }
}
