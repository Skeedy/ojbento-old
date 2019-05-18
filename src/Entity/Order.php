<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $hour;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Menu")
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Assoc")
     */
    private $quantity_assoc;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
        $this->quantity_assoc = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(\DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(Menu $quantity): self
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity[] = $quantity;
        }

        return $this;
    }

    public function removeQuantity(Menu $quantity): self
    {
        if ($this->quantity->contains($quantity)) {
            $this->quantity->removeElement($quantity);
        }

        return $this;
    }

    /**
     * @return Collection|Assoc[]
     */
    public function getQuantityAssoc(): Collection
    {
        return $this->quantity_assoc;
    }

    public function addQuantityAssoc(Assoc $quantityAssoc): self
    {
        if (!$this->quantity_assoc->contains($quantityAssoc)) {
            $this->quantity_assoc[] = $quantityAssoc;
        }

        return $this;
    }

    public function removeQuantityAssoc(Assoc $quantityAssoc): self
    {
        if ($this->quantity_assoc->contains($quantityAssoc)) {
            $this->quantity_assoc->removeElement($quantityAssoc);
        }

        return $this;
    }
}
