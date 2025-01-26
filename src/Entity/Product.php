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
#[ORM\Table(name: 'product')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read', 'product:write'])]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write', 'category:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Groups(['product:read', 'product:write', 'category:read'])]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $size = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $model = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $materials = null;

    #[ORM\Column]
    #[Groups(['product:read', 'product:write'])]
    private ?bool $availability = null;

    #[ORM\Column]
    #[Groups(['product:read', 'product:write'])]
    private ?bool $isActive = null;

    #[ORM\Column]
    #[Groups(['product:read', 'product:write'])]
    private ?bool $isTrending = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['product:read'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, cascade: ['persist', 'remove'])]
    #[Groups(['product:read'])]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductVariant::class, cascade: ['persist', 'remove'])]
    #[Groups(['product:read'])]
    private Collection $variants;

    #[ORM\OneToOne(mappedBy: 'product', targetEntity: Stock::class, cascade: ['persist', 'remove'])]
    #[Groups(['product:read'])]
    private ?Stock $stock = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->variants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getMaterials(): ?string
    {
        return $this->materials;
    }

    public function setMaterials(string $materials): self
    {
        $this->materials = $materials;
        return $this;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(bool $availability): self
    {
        $this->availability = $availability;
        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getIsTrending(): ?bool
    {
        return $this->isTrending;
    }

    public function setIsTrending(bool $isTrending): self
    {
        $this->isTrending = $isTrending;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }
        return $this;
    }

    public function removeImage(ProductImage $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ProductVariant>
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(ProductVariant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants->add($variant);
            $variant->setProduct($this);
        }
        return $this;
    }

    public function removeVariant(ProductVariant $variant): self
    {
        if ($this->variants->removeElement($variant)) {
            if ($variant->getProduct() === $this) {
                $variant->setProduct(null);
            }
        }
        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        if ($stock === null && $this->stock !== null) {
            $this->stock->setProduct(null);
        }
        if ($stock !== null && $stock->getProduct() !== $this) {
            $stock->setProduct($this);
        }
        $this->stock = $stock;
        return $this;
    }
} 