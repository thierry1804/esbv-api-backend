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
#[ORM\Table(name: 'category_attribute_types')]
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
    normalizationContext: ['groups' => ['category_attribute_types:read']],
    denormalizationContext: ['groups' => ['category_attribute_types:write']]
)]
class CategoryAttributeTypes
{
    #[ORM\Id]
    #[ORM\Column]
    #[Groups(['category_attribute_types:read', 'category:read'])]
    private ?int $categoryId = null;

    #[ORM\Id]
    #[ORM\Column]
    #[Groups(['category_attribute_types:read', 'category:read'])]
    private ?int $variantAttributeTypeId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[Groups(['category_attribute_types:read', 'category_attribute_types:write'])]
    private ?Category $category = null;

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    public function getVariantAttributeTypeId(): ?int
    {
        return $this->variantAttributeTypeId;
    }

    public function setVariantAttributeTypeId(int $variantAttributeTypeId): self
    {
        $this->variantAttributeTypeId = $variantAttributeTypeId;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        if ($category) {
            $this->categoryId = $category->getId();
        }
        return $this;
    }
} 