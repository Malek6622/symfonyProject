<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="This port is already in use on that host.")
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->setCreatedAt(new \DatetimeImmutable());
        $this->setUpdatedAt(new \DatetimeImmutable());
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("group0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups("group0")
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("group0")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string A "Y-m-d" formatted value
     * @ORM\Column(type="datetime", nullable = True)
     * @Groups("group0")
     */
    private $birthDate;

    /**
     * @var Integer|null
     * @ORM\Column(type="integer", nullable = True)
     * @Groups("group0")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("group0")
     */
    private $cin;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="users")
     * @Groups("group0")
     */
    private $idDepartment;

    /**
     * @var string
     * @Groups("group0")
     */
    protected $roles;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="users")
     * @Groups("group0")
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        if ($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * @return \DatetimeImmutable
     */
    public function getCreatedAt(): \DatetimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DatetimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DatetimeImmutable
     */
    public function getUpdatedAt(): \DatetimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DatetimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getIdDepartment(): ?department
    {
        return $this->idDepartment;
    }

    public function setIdDepartment(?department $idDepartment): self
    {
        $this->idDepartment = $idDepartment;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoles()
    {
        return (array)$this->roles;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->getEmail();
    }

    /**
     * @param string|null $roles
     * @return User
     */
    public function setRoles(?string $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string|null $salt
     * @return $this
     */
    public function setSalt(string $salt = null): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get user
     *
     * @return null|string
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set device
     *
     * @param null|string $device
     * @return User
     */
    public function setUser(?string $user): User
    {
        $this->user = $user;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    /**
     * @param int|null $phoneNumber
     */
    public function setPhoneNumber(?int $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return object|null
     */
    public function getBirthDate(): ?object
    {
        return $this->birthDate;
    }

    /**
     * @param $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }
}
