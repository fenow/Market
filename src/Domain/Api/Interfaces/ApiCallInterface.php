<?php


namespace App\Domain\Api\Interfaces;


use App\Domain\Api\Enum\ApiInputEnum;

interface ApiCallInterface
{
    function call(array $options = [], string $outputFormat = ApiInputEnum::RAW);
}