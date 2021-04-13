<?php

namespace App\Entity;

use App\Repository\ProductDepartmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductDepartmentRepository::class)
 */
class ProductDepartment
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=department::class, inversedBy="idProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idDepartment;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=product::class, inversedBy="productDepartment", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduct;

    public function getIdDepartment(): ?department
    {
        return $this->idDepartment;
    }

    public function setIdDepartement(department $idDepartment): self
    {
        $this->idDepartment = $idDepartment;

        return $this;
    }

    public function getIdProduct(): ?product
    {
        return $this->idProduct;
    }

    public function setIdProduct(product $idProduct): self
    {
        $this->idProduct = $idProduct;

        return $this;
    }
}
