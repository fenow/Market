<?php

namespace App\Domain\Api\Enum;

use Greg0ire\Enum\AbstractEnum;

final class ApiInputEnum extends AbstractEnum
{
    const RAW = 'raw';
    const JSON = 'json';
    const XML = 'xml';
}
