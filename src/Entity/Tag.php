<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Happening::class, inversedBy="tags")
     */
    private $happenings;

    /**
     * @ORM\ManyToMany(targetEntity=Announcement::class, inversedBy="tags")
     */
    private $announcements;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="tags")
     */
    private $articles;

    public function __construct()
    {
        $this->happenings = new ArrayCollection();
        $this->announcements = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Happening[]
     */
    public function getHappenings(): Collection
    {
        return $this->happenings;
    }

    public function addHappening(Happening $happening): self
    {
        if (!$this->happenings->contains($happening)) {
            $this->happenings[] = $happening;
        }

        return $this;
    }

    public function removeHappening(Happening $happening): self
    {
        $this->happenings->removeElement($happening);

        return $this;
    }

    /**
     * @return Collection|Announcement[]
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): self
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements[] = $announcement;
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        $this->announcements->removeElement($announcement);

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);

        return $this;
    }
}
