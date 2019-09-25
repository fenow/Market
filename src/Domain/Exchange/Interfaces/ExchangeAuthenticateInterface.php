<?php

namespace App\Domain\Exchange\Interfaces;

interface ExchangeAuthenticateInterface
{
    public function generateSign(string $url, array $params): string;

    public function getApiKey();
}
