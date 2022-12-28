<?php


namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\InvoiceRepository")]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    /**
     * paid', 'stripe', 'paypal
     */
    #[ORM\Column(type: "string", length: 8)]
    private $payment_service;

    #[ORM\Column(type: "string", length: 255)]
    private $payment_service_invoice_id;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: "invoices")]
    #[ORM\JoinColumn(nullable: false)]
    private $profile;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private $amount;

    #[ORM\Column(type: "string", length: 3)]
    private $currency;

    /**
     * enum values paid', 'unpaid', 'canceled
     */
    #[ORM\Column(type: "string", length: 7)]
    private $status;

    #[ORM\Column(type: "datetime")]
    private $created_at;

    #[ORM\Column(type: "datetime")]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentService(): ?string
    {
        return $this->payment_service;
    }

    public function setPaymentService(string $payment_service): self
    {
        $this->payment_service = $payment_service;

        return $this;
    }

    public function getPaymentServiceInvoiceId(): ?string
    {
        return $this->payment_service_invoice_id;
    }

    public function setPaymentServiceInvoiceId(string $payment_service_invoice_id): self
    {
        $this->payment_service_invoice_id = $payment_service_invoice_id;

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

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
