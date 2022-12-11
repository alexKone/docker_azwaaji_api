<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\InformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InformationRepository::class)]
#[ApiResource]
class Information
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private ?int $children = 0;

    #[ORM\Column(length: 255)]
    #[Groups(['profile:details:read'])]
    private ?string $maritalStatus = 'celibate';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private ?string $profile_sought = null;

    #[ORM\Column]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private bool $smoke = false;

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private string $hijra = 'maybe';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private ?string $sport = null;

    #[ORM\OneToOne(mappedBy: 'information', cascade: ['persist', 'remove'])]
    private ?Profile $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(int $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(string $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getProfileSought(): ?string
    {
        return $this->profile_sought;
    }

    public function setProfileSought(?string $profile_sought): self
    {
        $this->profile_sought = $profile_sought;

        return $this;
    }

    public function isSmoke(): bool
    {
        return $this->smoke;
    }

    public function setSmoke(bool $smoke): self
    {
        $this->smoke = $smoke;

        return $this;
    }

    public function getHijra(): ?string
    {
        return $this->hijra;
    }

    public function setHijra(string $hijra): self
    {
        $this->hijra = $hijra;

        return $this;
    }

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(?string $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getInformation() !== $this) {
            $profile->setInformation($this);
        }

        $this->profile = $profile;

        return $this;
    }
}
