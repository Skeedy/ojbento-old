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
     * @ORM\Column(type="boolean")
     */
    private $isDish;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $composition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="assocs")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="assocs")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Priceassoc", cascade={"all"}, mappedBy="assoc", orphanRemoval=true)
     */
    private $prices;

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

    public function getIsDish(): ?bool
    {
        return $this->isDish;
    }

    public function setIsDish(bool $isDish): self
    {
        $this->isDish = $isDish;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(?string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

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
}
