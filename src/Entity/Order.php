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
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Post(
            security: "is_granted('ROLE_USER')"
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_USER') and object.customerEmail == user.email)"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    normalizationContext: ['groups' => ['order:read']],
    denormalizationContext: ['groups' => ['order:write']]
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $customerEmail = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $customerPhone = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $shippingAddress = null;

    #[ORM\Column]
    #[Groups(['order:read', 'order:write'])]
    private ?bool $isProvince = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $province = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $shippingCompany = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $paymentMethod = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?float $paymentRate = null;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?float $paidAmount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $paymentReference = null;

    #[ORM\Column(length: 20, options: ['default' => 'pending'])]
    #[Groups(['order:read', 'order:write'])]
    private ?string $paymentStatus = 'pending';

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['order:read'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist', 'remove'])]
    #[Groups(['order:read'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone(string $customerPhone): self
    {
        $this->customerPhone = $customerPhone;
        return $this;
    }

    public function getShippingAddress(): ?string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function getIsProvince(): ?bool
    {
        return $this->isProvince;
    }

    public function setIsProvince(bool $isProvince): self
    {
        $this->isProvince = $isProvince;
        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): self
    {
        $this->province = $province;
        return $this;
    }

    public function getShippingCompany(): ?string
    {
        return $this->shippingCompany;
    }

    public function setShippingCompany(?string $shippingCompany): self
    {
        $this->shippingCompany = $shippingCompany;
        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function getPaymentRate(): ?float
    {
        return $this->paymentRate;
    }

    public function setPaymentRate(?float $paymentRate): self
    {
        $this->paymentRate = $paymentRate;
        return $this;
    }

    public function getPaidAmount(): ?float
    {
        return $this->paidAmount;
    }

    public function setPaidAmount(?float $paidAmount): self
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

    public function getPaymentReference(): ?string
    {
        return $this->paymentReference;
    }

    public function setPaymentReference(?string $paymentReference): self
    {
        $this->paymentReference = $paymentReference;
        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(string $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;
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
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }
        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getOrder() === $this) {
                $item->setOrder(null);
            }
        }
        return $this;
    }
} 