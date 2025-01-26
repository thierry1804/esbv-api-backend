<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'order_item')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['order_item:read']],
    denormalizationContext: ['groups' => ['order_item:write']]
)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order_item:read', 'order:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order_item:read', 'order_item:write'])]
    private ?Order $order = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order_item:read', 'order_item:write', 'order:read'])]
    private ?Product $product = null;

    #[ORM\Column]
    #[Groups(['order_item:read', 'order_item:write', 'order:read'])]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order_item:read', 'order_item:write', 'order:read'])]
    private ?float $price = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['order_item:read', 'order_item:write', 'order:read'])]
    private ?float $subtotal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;
        return $this;
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
        $this->calculateSubtotal();
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        $this->calculateSubtotal();
        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    private function calculateSubtotal(): void
    {
        if ($this->price !== null && $this->quantity !== null) {
            $this->subtotal = $this->price * $this->quantity;
        }
    }
} 