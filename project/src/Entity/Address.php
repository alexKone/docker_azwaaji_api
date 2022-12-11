<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private ?string $street = '';

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private ?string $city = '';

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:details:read'])]
    private ?string $zipcode = '';

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private ?string $country = '';

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    private ?Profile $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        // set the owning side of the relation if necessary
        if ($profile->getAddress() !== $this) {
            $profile->setAddress($this);
        }

        $this->profile = $profile;

        return $this;
    }

}
