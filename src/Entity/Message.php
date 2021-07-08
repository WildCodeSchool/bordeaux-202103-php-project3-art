<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de bien vouloir saisir une adresse mail")
     * @Assert\Email(message="{{ value }} n'est pas une adresse mail valide")
     * @Assert\Length(max="255", maxMessage="Ce champs ne peut contenir que {{ limit }} caractères")
     */
    private $mail;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Merci de bien vouloir saisir un contenu")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Merci de bien vouloir saisir l'objet de votre message")
     * @Assert\Length(max="255", maxMessage="Ce champs ne peut contenir que {{ limit }} caractères")
     */
    private $object;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     */
    private $user;

    private $adminMailMessenger = 'admin@gmail.com';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->sendAt = new \DateTime();
    }

    public function getAdminMailMessenger()
    {
        return $this->adminMailMessenger;
    }

    public function setAdminMailMessenger($adminMailMessenger)
    {
        $this->adminMailMessenger = $adminMailMessenger;

        return $this;
    }
}
