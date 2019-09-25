<?php

namespace App\Domain\Api;

use App\Domain\Api\Enum\ApiInputEnum;
use App\Domain\Api\Exceptions\ApiError;
use App\Domain\Api\Exceptions\ApiMethodMissing;
use App\Domain\Api\Exceptions\ApiUrlMissing;
use App\Domain\Api\Interfaces\ApiCallInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiCall implements ApiCallInterface
{
    /** @var HttpClientInterface $httpClient */
    protected $httpClient;

    /** @var string $method */
    protected $method;

    /** @var string $url */
    protected $url;

    /**
     * AbstractApiCall constructor.
     */
    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    /**
     * @param array $options
     * @param string $outputFormat
     * @return mixed|string
     * @throws ApiError
     * @throws ApiMethodMissing
     * @throws ApiUrlMissing
     */
    public function call(array $options = [], string $outputFormat = ApiInputEnum::RAW) {
        if(is_null($this->method)) {
            throw new ApiMethodMissing();
        } elseif (is_null($this->url)) {
            throw new ApiUrlMissing();
        }

        try {
            $result = $this->httpClient->request($this->method, $this->url, $options)->getContent();
        } catch (ClientExceptionInterface $e) {
            throw new ApiError($e->getMessage(), $e->getCode());
        } catch (RedirectionExceptionInterface $e) {
            throw new ApiError($e->getMessage(), $e->getCode());
        } catch (ServerExceptionInterface $e) {
            throw new ApiError($e->getMessage(), $e->getCode());
        } catch (TransportExceptionInterface $e) {
            throw new ApiError($e->getMessage(), $e->getCode());
        }

        switch ($outputFormat) {
            default:
            case ApiInputEnum::RAW:
                return $result;

            case ApiInputEnum::JSON:
                return \json_decode($result);
        }
    }
}