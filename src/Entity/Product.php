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
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="products", cascade={"remove"} )
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", onDelete="CASCADE")
     * @Groups("group1")
     */
    private $department;

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

    /**
     * @return mixed
     */
    public function getDepartment() : ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return $this
     */
    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
