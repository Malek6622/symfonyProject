<?php

namespace App\Entity;

use App\Repository\UserProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserProductRepository::class)
 */
class UserProduct
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=product::class, inversedBy="userProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProduct;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=user::class, inversedBy="userProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    public function getIdProduct(): ?product
    {
        return $this->idProduct;
    }

    public function setIdProduct(product $idProduct): self
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(user $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
}
