<?php


namespace App\Entity\Interfaces;


use Ramsey\Uuid\UuidInterface;

interface EntityIdInterface
{
    public function getId(): UuidInterface;
}