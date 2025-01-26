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
#[ORM\Table(name: 'product_image')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['product_image:read']],
    denormalizationContext: ['groups' => ['product_image:write']]
)]
class ProductImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product_image:read', 'product:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product_image:read', 'product_image:write'])]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product_image:read', 'product_image:write', 'product:read'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['product_image:read', 'product_image:write', 'product:read'])]
    private ?bool $isMain = false;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): self
    {
        $this->isMain = $isMain;
        return $this;
    }
} 