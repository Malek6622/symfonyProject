<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Monolog\DateTimeImmutable;
use Symfony\Component\Validator\Constraints\DateTime;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
    use TimestampableEntity;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->createdAt = new \DatetimeImmutable();
        $this->updatedAt = new \DatetimeImmutable();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group2","group1","group0"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=true)
     * @Groups("group1")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $departmentId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("group2","group1","group0")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="products")
     * @Groups("group1")
     */
    private $users;

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

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DatetimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DatetimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDepartmentId(): ?Department
    {
        return $this->departmentId;
    }

    public function setDepartmentId(?Department $departmentId): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addProduct($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProduct($this);
        }

        return $this;
    }
}
