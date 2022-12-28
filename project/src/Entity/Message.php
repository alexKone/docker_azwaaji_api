<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ApiResource]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\ManyToOne(targetEntity: Conversation::class, inversedBy: 'messages')]
    private ?Conversation $conversation;

    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $sender;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updated_at;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getConversation(): ?Conversation
    {
        return $this->conversation;
    }

    public function setConversation(?Conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }

    public function getSender(): ?Profile
    {
        return $this->sender;
    }

    public function setSender(?Profile $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
