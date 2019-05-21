<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssocRepository")
 */
class Assoc
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDish;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Priceassoc", cascade={"all"} , mappedBy="assoc", orphanRemoval=true)
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="assoc")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Assoc", inversedBy="image")
     */
    private $assoc;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    private $type;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getIsDish(): ?bool
    {
        return $this->isDish;
    }

    public function setIsDish(bool $isDish): self
    {
        $this->isDish = $isDish;

        return $this;
    }

    /**
     * @return Collection|Priceassoc[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Priceassoc $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setAssoc($this);
        }

        return $this;
    }

    public function removePrice(Priceassoc $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getAssoc() === $this) {
                $price->setAssoc(null);
            }
        }

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getQuantity()." ".$this->getProduct();
    }

    public function getAssoc(): ?self
    {
        return $this->assoc;
    }

    public function setAssoc(?self $assoc): self
    {
        $this->assoc = $assoc;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

}
