<?php

namespace App\Entity\Enum;

use Greg0ire\Enum\AbstractEnum;

final class SessionStatusEnum extends AbstractEnum
{
    const Created = 'created';
    const Buying = 'buying';
    const Buyed = 'buyed';
    const Selling = 'selling';
    const Sold = 'sold';
}
