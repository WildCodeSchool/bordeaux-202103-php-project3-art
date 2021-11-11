<?php

namespace App\Entity;

use App\Repository\ExternalArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExternalArticleRepository::class)
 */
class ExternalArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\OneToOne(targetEntity=ImageExternalArticle::class, cascade={"persist", "remove"})
     */
    private $imageExternalArticle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $podium = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getImageExternalArticle(): ?ImageExternalArticle
    {
        return $this->imageExternalArticle;
    }

    public function setImageExternalArticle(?ImageExternalArticle $imageExternalArticle): self
    {
        $this->imageExternalArticle = $imageExternalArticle;

        return $this;
    }

    public function getPodium(): ?int
    {
        return $this->podium;
    }

    public function setPodium(?int $podium): self
    {
        $this->podium = $podium;

        return $this;
    }
}
