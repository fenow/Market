<?php

namespace App\Domain\Session\Interfaces;

use App\Entity\Session;

interface ExecuteFlow
{
    public function execute(Session $session): bool;
}
