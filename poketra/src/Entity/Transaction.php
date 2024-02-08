<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TransactionType::class)]
    #[ORM\JoinColumn(nullable: false,name:"type")]
    private ?TransactionType $type = null;

    #[ORM\ManyToOne(targetEntity:Banking::class)]
    #[ORM\JoinColumn(nullable: false,name:"banking")]
    private ?Banking $banking = null;

    #[ORM\Column]
    private ?int $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE,name:"transaction_date")]
    private ?\DateTimeInterface $transcationDate = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?string $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TransactionType
    {
        return $this->type;
    }

    public function setType(TransactionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBanking(): ?Banking
    {
        return $this->banking;
    }

    public function setBanking(Banking $banking): static
    {
        $this->banking = $banking;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTranscationDate(): ?\DateTimeInterface
    {
        return $this->transcationDate;
    }

    public function setTranscationDate(\DateTimeInterface $transcationDate): static
    {
        $this->transcationDate = $transcationDate;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
