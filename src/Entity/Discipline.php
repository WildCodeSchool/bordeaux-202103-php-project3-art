<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisciplineRepository::class)
 */
class Discipline
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $identifier;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private string $color;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="disciplines")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Artwork::class, mappedBy="discipline")
     */
    private $artworks;

    /**
     * @ORM\OneToMany(targetEntity=Announcement::class, mappedBy="discipline")
     */
    private $announcements;

    public const DISCIPLINES = ['Arts visuels','Arts du mouvement', 'Arts Littéraires', 'Arts Musicaux' ];
    public const COLORS = ['visu','move','letters','music'];

    public function __sleep()
    {
        return [];
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->artworks = new ArrayCollection();
        $this->announcements = new ArrayCollection();
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

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getColor(): ?string
    {
        for ($i = 0; $i < count(self::DISCIPLINES); $i++) {
            if ($this->name === self::DISCIPLINES[$i]) {
                $this->color = self::COLORS[$i];
            }
        }
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Artwork[]
     */
    public function getArtworks()
    {
        return $this->artworks;
    }

    public function addArtwork(Artwork $artwork): self
    {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks[] = $artwork;
            $artwork->setDiscipline($this);
        }

        return $this;
    }

    public function removeArtwork(Artwork $artwork): self
    {
        if ($this->artworks->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getDiscipline() === $this) {
                $artwork->setDiscipline(null);
            }
        }

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
            $announcement->setDiscipline($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getDiscipline() === $this) {
                $announcement->setDiscipline(null);
            }
        }

        return $this;
    }
}
