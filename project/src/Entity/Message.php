<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ApiResource]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(name: 'sender_id', referencedColumnName: 'id')]
    private mixed $sender;

    #[ORM\ManyToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(name: 'receiver_id', referencedColumnName: 'id')]
    private mixed $receiver;

    #[ORM\Column(type: 'text')]
    private mixed $message;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }


    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getSender(): mixed
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getReceiver(): mixed
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver(mixed $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getMessage(): mixed
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage(mixed $message): void
    {
        $this->message = $message;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt(mixed $created_at): void
    {
        $this->created_at = $created_at;
    }

}
