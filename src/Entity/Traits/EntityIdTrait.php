<?php

namespace App\Entity\Traits;

use Ramsey\Uuid\UuidInterface;

trait EntityIdTrait
{
    /**
     * The public primary identity key.
     *
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
