<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Media
{
    public const SUPPORT_CHOICE = ['video', 'photo'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $support;

    /**
     * @ORM\OneToOne(targetEntity=Artwork::class, inversedBy="media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $artwork;

    /**
     * @ORM\OneToOne(targetEntity=ImageArtwork::class, inversedBy="media", cascade={"persist", "remove"})
     */
    private $imageArtwork;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getArtwork(): ?Artwork
    {
        return $this->artwork;
    }

    public function setArtwork(Artwork $artwork): self
    {
        $this->artwork = $artwork;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Gets triggered only on update
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    public function getImageArtwork(): ?ImageArtwork
    {
        return $this->imageArtwork;
    }

    public function setImageArtwork(?ImageArtwork $imageArtwork): self
    {
        $this->imageArtwork = $imageArtwork;

        return $this;
    }
}
