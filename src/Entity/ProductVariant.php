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
#[ORM\Table(name: 'product_variant')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['product_variant:read']],
    denormalizationContext: ['groups' => ['product_variant:write']]
)]
class ProductVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product_variant:read', 'product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'variants')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product_variant:read', 'product_variant:write'])]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product_variant:read', 'product_variant:write', 'product:read'])]
    private ?string $sku = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['product_variant:read', 'product_variant:write', 'product:read'])]
    private ?float $price = null;

    #[ORM\Column]
    #[Groups(['product_variant:read', 'product_variant:write', 'product:read'])]
    private ?int $stock = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['product_variant:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['product_variant:read'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'variant', targetEntity: ProductVariantValue::class, cascade: ['persist', 'remove'])]
    #[Groups(['product_variant:read'])]
    private Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
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

    /**
     * @return Collection<int, ProductVariantValue>
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValue(ProductVariantValue $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
            $value->setVariant($this);
        }
        return $this;
    }

    public function removeValue(ProductVariantValue $value): self
    {
        if ($this->values->removeElement($value)) {
            if ($value->getVariant() === $this) {
                $value->setVariant(null);
            }
        }
        return $this;
    }
} 