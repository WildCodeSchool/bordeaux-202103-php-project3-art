<?php

namespace App\Entity;

use App\Repository\ImageArtworkRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageArtworkRepository", repositoryClass=ImageArtworkRepository::class)
 * @Vich\Uploadable
 */
class ImageArtwork implements \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, mappedBy="imageArtwork", cascade={"persist", "remove"})
     */
    private $media;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }
    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function serialize()
    {
        $this->imageFile = base64_encode($this->imageFile);
    }

    public function unserialize($data)
    {
        $this->imageFile = base64_decode($this->imageFile);


    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        // unset the owning side of the relation if necessary
        if ($media === null && $this->media !== null) {
            $this->media->setImageArtwork(null);
        }

        // set the owning side of the relation if necessary
        if ($media !== null && $media->getImageArtwork() !== $this) {
            $media->setImageArtwork($this);
        }

        $this->media = $media;

        return $this;
    }
}
