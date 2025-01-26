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
#[ORM\Table(name: 'home_config')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['home_config:read']],
    denormalizationContext: ['groups' => ['home_config:write']]
)]
class HomeConfig
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['home_config:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $heroTitle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $heroSubtitle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $heroButtonText = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $heroBackgroundImage = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $featuredTitle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $newsletterTitle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?string $newsletterText = null;

    #[ORM\Column]
    #[Groups(['home_config:read', 'home_config:write'])]
    private ?bool $isActive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeroTitle(): ?string
    {
        return $this->heroTitle;
    }

    public function setHeroTitle(string $heroTitle): self
    {
        $this->heroTitle = $heroTitle;
        return $this;
    }

    public function getHeroSubtitle(): ?string
    {
        return $this->heroSubtitle;
    }

    public function setHeroSubtitle(string $heroSubtitle): self
    {
        $this->heroSubtitle = $heroSubtitle;
        return $this;
    }

    public function getHeroButtonText(): ?string
    {
        return $this->heroButtonText;
    }

    public function setHeroButtonText(string $heroButtonText): self
    {
        $this->heroButtonText = $heroButtonText;
        return $this;
    }

    public function getHeroBackgroundImage(): ?string
    {
        return $this->heroBackgroundImage;
    }

    public function setHeroBackgroundImage(string $heroBackgroundImage): self
    {
        $this->heroBackgroundImage = $heroBackgroundImage;
        return $this;
    }

    public function getFeaturedTitle(): ?string
    {
        return $this->featuredTitle;
    }

    public function setFeaturedTitle(string $featuredTitle): self
    {
        $this->featuredTitle = $featuredTitle;
        return $this;
    }

    public function getNewsletterTitle(): ?string
    {
        return $this->newsletterTitle;
    }

    public function setNewsletterTitle(string $newsletterTitle): self
    {
        $this->newsletterTitle = $newsletterTitle;
        return $this;
    }

    public function getNewsletterText(): ?string
    {
        return $this->newsletterText;
    }

    public function setNewsletterText(string $newsletterText): self
    {
        $this->newsletterText = $newsletterText;
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
} 