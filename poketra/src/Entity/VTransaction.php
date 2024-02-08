<?php

namespace App\Entity;

use App\Repository\VTransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VTransactionRepository::class,readOnly:true)]
#[ORM\Table(name:"v_transaction")]
class VTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type_name = null;

    #[ORM\Column]
    private ?int $type_id = null;

    #[ORM\Column(length: 50)]
    private ?string $banking_name = null;

    #[ORM\Column]
    private ?int $banking_id = null;

    #[ORM\Column]
    private ?int $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $transaction_date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 2)]
    private ?string $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeName(): ?string
    {
        return $this->type_name;
    }

    public function setTypeName(string $type_name): static
    {
        $this->type_name = $type_name;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id): static
    {
        $this->type_id = $type_id;

        return $this;
    }

    public function getBankingName(): ?string
    {
        return $this->banking_name;
    }

    public function setBankingName(string $banking_name): static
    {
        $this->banking_name = $banking_name;

        return $this;
    }

    public function getBankingId(): ?int
    {
        return $this->banking_id;
    }

    public function setBankingId(int $banking_id): static
    {
        $this->banking_id = $banking_id;

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

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->transaction_date;
    }

    public function setTransactionDate(\DateTimeInterface $transaction_date): static
    {
        $this->transaction_date = $transaction_date;

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
