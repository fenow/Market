<?php


namespace App\Entity\Interfaces;


interface EntityTimestampableInterface
{
    public function getCreatedAt(): \DateTimeInterface;

    public function getUpdatedAt(): \DateTimeInterface;

    public function setUpdatedAt(\DateTimeInterface $updatedAt);
}