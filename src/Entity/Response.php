<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responses")
     */
    private $respondant;

    /**
     * @ORM\ManyToOne(targetEntity=Announcement::class, inversedBy="responses")
     */
    private $announcement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRespondant(): ?User
    {
        return $this->respondant;
    }

    public function setRespondant(?User $respondant): self
    {
        $this->respondant = $respondant;

        return $this;
    }

    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement(?Announcement $announcement): self
    {
        $this->announcement = $announcement;

        return $this;
    }
}
