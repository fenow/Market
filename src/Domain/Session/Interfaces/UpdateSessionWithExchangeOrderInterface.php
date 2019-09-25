<?php


namespace App\Domain\Session\Interfaces;


use App\Entity\Session;

interface UpdateSessionWithExchangeOrderInterface
{
    function updateSessionWithExchangeOrder(Session $session, string $orderUuid): void;
}