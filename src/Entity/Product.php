<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var datetime $createdAt
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=ProductDepartment::class, mappedBy="idProduct", cascade={"persist", "remove"})
     */
    private $productDepartment;

    /**
     * @ORM\OneToOne(targetEntity=UserProduct::class, mappedBy="idProduct", cascade={"persist", "remove"})
     */
    private $userProduct;

    public function getId(): ?int
    {
        return $this->id;
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
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime("now");
        $this->updatedAt = new DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new DateTime("now");
    }

    public function getProductDepartment(): ?ProductDepartment
    {
        return $this->productDepartment;
    }

    public function setProductDepartment(ProductDepartment $productDepartment): self
    {
        // set the owning side of the relation if necessary
        if ($productDepartment->getIdProduct() !== $this) {
            $productDepartment->setIdProduct($this);
        }

        $this->productDepartment = $productDepartment;

        return $this;
    }

    public function getUserProduct(): ?UserProduct
    {
        return $this->userProduct;
    }

    public function setUserProduct(UserProduct $userProduct): self
    {
        // set the owning side of the relation if necessary
        if ($userProduct->getIdProduct() !== $this) {
            $userProduct->setIdProduct($this);
        }

        $this->userProduct = $userProduct;

        return $this;
    }
}
