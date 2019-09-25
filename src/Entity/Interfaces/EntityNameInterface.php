<?php


namespace App\Entity\Interfaces;


interface EntityNameInterface
{
    public function __toString();

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getSlug(): ?string;

    public function setSlug(?string $slug): void;
}