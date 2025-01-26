<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'stock')]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Post(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    normalizationContext: ['groups' => ['stock:read']],
    denormalizationContext: ['groups' => ['stock:write']]
)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['stock:read', 'product:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'stock')]
    #[ORM\JoinColumn(nullable: false, unique: true)]
    #[Groups(['stock:read', 'stock:write'])]
    private ?Product $product = null;

    #[ORM\Column]
    #[Groups(['stock:read', 'stock:write', 'product:read'])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['stock:read', 'stock:write'])]
    private ?int $alertThreshold = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['stock:read'])]
    private ?\DateTimeInterface $lastUpdated = null;

    #[ORM\OneToMany(mappedBy: 'stock', targetEntity: StockMovement::class, cascade: ['persist', 'remove'])]
    #[Groups(['stock:read'])]
    private Collection $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
        $this->lastUpdated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->lastUpdated = new \DateTime();
        return $this;
    }

    public function getAlertThreshold(): ?int
    {
        return $this->alertThreshold;
    }

    public function setAlertThreshold(int $alertThreshold): self
    {
        $this->alertThreshold = $alertThreshold;
        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(\DateTimeInterface $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**
     * @return Collection<int, StockMovement>
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    public function addMovement(StockMovement $movement): self
    {
        if (!$this->movements->contains($movement)) {
            $this->movements->add($movement);
            $movement->setStock($this);
        }
        return $this;
    }

    public function removeMovement(StockMovement $movement): self
    {
        if ($this->movements->removeElement($movement)) {
            if ($movement->getStock() === $this) {
                $movement->setStock(null);
            }
        }
        return $this;
    }
} 