<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Enums\GenderEnum;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['profile:details:read']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['profile:collection:read']]
        )
    ]
)]

#[ApiFilter(SearchFilter::class, properties: ['gender' => 'exact'])]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('profile:collection:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['user:collection:read', 'user:details:read', 'profile:collection:read', 'profile:details:read'])]
    private \DateTimeInterface $birthdate;

    #[ORM\Column(length: 255)]
    #[Groups(['user:collection:read', 'user:details:read', 'user:write', 'profile:collection:read', 'profile:details:read'])]
    private string $gender = '';

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['profile:collection:read', 'profile:details:read'])]
    private ?Address $address = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['profile:details:read'])]
    private ?Information $information = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['profile:details:read', 'profile:collection:read'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Invoice::class)]
    private $invoices;

    #[ORM\ManyToMany(targetEntity: Conversation::class, mappedBy: 'participants')]
    private $conversations;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->conversations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getInformation(): ?Information
    {
        return $this->information;
    }

    public function setInformation(Information $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setProfile($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getProfile() === $this) {
                $invoice->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations->add($conversation);
            $conversation->addParticipant($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            $conversation->removeParticipant($this);
        }

        return $this;
    }



}
