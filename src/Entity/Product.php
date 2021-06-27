<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @var int;
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private Category $category;

    /**
     * @var string
     * @ORM\Column(type="string", length=150)
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private float $price;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\ProductAttribute", mappedBy="product", cascade={"REMOVE"})
     */
    private Collection $attributes;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $techCondition;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="products")
     */
    private User $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SaveProduct", mappedBy="product", cascade={"REMOVE"})
     */
    private $savedProducts;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP"} )
     */
    private DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->savedProducts = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;

    }

    /**
     * @return int|null
     */
    public function getTechCondition(): ?int
    {
        return $this->techCondition;
    }

    /**
     * @param int $techCondition
     */
    public function setTechCondition(int $techCondition)
    {
        $this->techCondition = $techCondition;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     */
    public function setCreatedAt(DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Collection|ProductAttribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    /**
     * @param ProductAttribute $attribute
     * @return $this
     */
    public function addAttribute(ProductAttribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setProduct($this);
        }

        return $this;
    }

    /**
     * @param ProductAttribute $attribute
     * @return $this
     */
    public function removeAttribute(ProductAttribute $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getProduct() === $this) {
                $attribute->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Collection|SaveProduct[]
     */
    public function getSavedProducts(): Collection
    {
        return $this->savedProducts;
    }

    public function addSavedProduct(SaveProduct $savedProduct): self
    {
        if (!$this->savedProducts->contains($savedProduct)) {
            $this->savedProducts[] = $savedProduct;
            $savedProduct->setProduct($this);
        }

        return $this;
    }

    public function removeSavedProduct(SaveProduct $savedProduct): self
    {
        if ($this->savedProducts->removeElement($savedProduct)) {
            // set the owning side to null (unless already changed)
            if ($savedProduct->getProduct() === $this) {
                $savedProduct->setProduct(null);
            }
        }

        return $this;
    }
}
