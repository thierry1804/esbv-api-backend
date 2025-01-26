<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'stock_movement')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['stock_movement:read']],
    denormalizationContext: ['groups' => ['stock_movement:write']]
)]
class StockMovement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['stock_movement:read', 'stock:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['stock_movement:read', 'stock_movement:write'])]
    private ?Stock $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;
        return $this;
    }
} 