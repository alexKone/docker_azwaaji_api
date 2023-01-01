<?php

namespace App\Entity;

use App\Repository\StripeSubscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StripeSubscriptionRepository::class)]
class StripeSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $stripeSubscriptionId;

    #[ORM\Column(type: "string", length: 255)]
    private $stripePlanId;

    #[ORM\Column(type: "string", length: 255)]
    private $stripeCustomerId;

    /**
     * 'active', 'canceled'
     */
    #[ORM\Column(type: "string", length: 8)]
    private $status;

    #[ORM\Column(type: "date", nullable: true)]
    private $trialEndDate;

    #[ORM\Column(type: "date")]
    private $currentPeriodStartDate;

    #[ORM\Column(type: "date")]
    private $currentPeriodEndDate;

    #[ORM\Column(type: "datetime")]
    private $createdAt;

    #[ORM\Column(type: "datetime")]
    private $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'stripe_subscriptions')]
    private ?Profile $profile = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStripeSubscriptionId(): ?string
    {
        return $this->stripeSubscriptionId;
    }

    public function setStripeSubscriptionId(string $stripeSubscriptionId): self
    {
        $this->stripeSubscriptionId = $stripeSubscriptionId;

        return $this;
    }

    public function getStripePlanId(): ?string
    {
        return $this->stripePlanId;
    }

    public function setStripePlanId(string $stripePlanId): self
    {
        $this->stripePlanId = $stripePlanId;

        return $this;
    }

    public function getStripeCustomerId(): ?string
    {
        return $this->stripeCustomerId;
    }

    public function setStripeCustomerId(string $stripeCustomerId): self
    {
        $this->stripeCustomerId = $stripeCustomerId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTrialEndDate(): ?\DateTimeInterface
    {
        return $this->trialEndDate;
    }

    public function setTrialEndDate(?\DateTimeInterface $trialEndDate): self
    {
        $this->trialEndDate = $trialEndDate;

        return $this;
    }

    public function getCurrentPeriodStartDate(): ?\DateTimeInterface
    {
        return $this->currentPeriodStartDate;
    }

    public function setCurrentPeriodStartDate(\DateTimeInterface $currentPeriodStartDate): self
    {
        $this->currentPeriodStartDate = $currentPeriodStartDate;

        return $this;
    }

    public function getCurrentPeriodEndDate(): ?\DateTimeInterface
    {
        return $this->currentPeriodEndDate;
    }

    public function setCurrentPeriodEndDate(\DateTimeInterface $currentPeriodEndDate): self
    {
        $this->currentPeriodEndDate = $currentPeriodEndDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }
}



