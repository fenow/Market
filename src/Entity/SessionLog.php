<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityIdInterface;
use App\Entity\Interfaces\EntityTimestampableInterface;
use App\Entity\Traits\EntityIdTrait;
use App\Entity\Traits\EntityTimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionLogRepository")
 */
class SessionLog implements EntityIdInterface, EntityTimestampableInterface
{
    use EntityIdTrait;
    use EntityTimestampableTrait;

    /**
     * @ManyToOne(targetEntity="Session", cascade={"all"}, fetch="EAGER", inversedBy="logs")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $session;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;


    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
