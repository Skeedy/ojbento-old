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
    private $supp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PriceAssoc", mappedBy="assoc", orphanRemoval=true)
     */
    private $price;

    public function __construct()
    {
        $this->price = new ArrayCollection();
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

    public function getSupp(): ?bool
    {
        return $this->supp;
    }

    public function setSupp(bool $supp): self
    {
        $this->supp = $supp;

        return $this;
    }

    /**
     * @return Collection|PriceAssoc[]
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }

    public function addPrice(PriceAssoc $price): self
    {
        if (!$this->price->contains($price)) {
            $this->price[] = $price;
            $price->setAssoc($this);
        }

        return $this;
    }

    public function removePrice(PriceAssoc $price): self
    {
        if ($this->price->contains($price)) {
            $this->price->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getAssoc() === $this) {
                $price->setAssoc(null);
            }
        }

        return $this;
    }
}
