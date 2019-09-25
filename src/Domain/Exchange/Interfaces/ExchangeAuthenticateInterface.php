<?php


namespace App\Domain\Exchange\Interfaces;


interface ExchangeAuthenticateInterface
{
    function generateSign(string $url, array $params): string;

    function getApiKey();
}