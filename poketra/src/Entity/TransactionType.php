<?php

namespace App\Entity;

use App\Repository\TransactionTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TransactionTypeRepository::class)]
class TransactionType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:'Le nom est obligatoire')]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'L\' utilisateur est obligatoire')]
    private ?int $user = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Le type est obligatoire")]
    #[Assert\AtLeastOneOf([new Assert\EqualTo(1),new Assert\EqualTo(-1)],message:"Le type doit être égal à 1 ou -1")]
    private ?int $type = null;

    #[ORM\Column]
    private bool $daily = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function getDaily() : bool
    {
        return $this->daily;
    }
    public function setDaily(bool $daily) : static
    {
        $this->daily = $daily;
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
    public function getType(): ?int
    {
        return $this->type;
    }
    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }
}
