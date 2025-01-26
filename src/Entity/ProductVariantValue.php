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
#[ORM\Table(name: 'product_variant_value')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['product_variant_value:read']],
    denormalizationContext: ['groups' => ['product_variant_value:write']]
)]
class ProductVariantValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product_variant_value:read', 'product_variant:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'values')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product_variant_value:read', 'product_variant_value:write'])]
    private ?ProductVariant $variant = null;

    #[ORM\Column]
    #[Groups(['product_variant_value:read', 'product_variant_value:write', 'product_variant:read'])]
    private ?int $attributeTypeId = null;

    #[ORM\Column]
    #[Groups(['product_variant_value:read', 'product_variant_value:write', 'product_variant:read'])]
    private ?int $attributeOptionId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['product_variant_value:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['product_variant_value:read'])]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariant(): ?ProductVariant
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariant $variant): self
    {
        $this->variant = $variant;
        return $this;
    }

    public function getAttributeTypeId(): ?int
    {
        return $this->attributeTypeId;
    }

    public function setAttributeTypeId(int $attributeTypeId): self
    {
        $this->attributeTypeId = $attributeTypeId;
        return $this;
    }

    public function getAttributeOptionId(): ?int
    {
        return $this->attributeOptionId;
    }

    public function setAttributeOptionId(int $attributeOptionId): self
    {
        $this->attributeOptionId = $attributeOptionId;
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
} 