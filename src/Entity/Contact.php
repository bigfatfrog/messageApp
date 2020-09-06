<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

use DateTimeInterface;


/**
 * @ORM\Entity(repositoryClass=App\Repository\ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $message;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status_id;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }
}
