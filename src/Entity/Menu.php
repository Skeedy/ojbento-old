<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $midi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Assoc",cascade={"all"}, mappedBy="menu")
     */
    private $assoc;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pricemenu", cascade={"all"}, mappedBy="menu", orphanRemoval=true)
     */
    private $prices;

    public function __construct()
    {
        $this->assoc = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }

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

    public function getMidi(): ?bool
    {
        return $this->midi;
    }

    public function setMidi(bool $midi): self
    {
        $this->midi = $midi;

        return $this;
    }

    /**
     * @return Collection|Assoc[]
     */
    public function getAssoc(): Collection
    {
        return $this->assoc;
    }

    public function addAssoc(Assoc $assoc): self
    {
        if (!$this->assoc->contains($assoc)) {
            $this->assoc[] = $assoc;
            $assoc->setMenu($this);
        }

        return $this;
    }

    public function removeAssoc(Assoc $assoc): self
    {
        if ($this->assoc->contains($assoc)) {
            $this->assoc->removeElement($assoc);
            // set the owning side to null (unless already changed)
            if ($assoc->getMenu() === $this) {
                $assoc->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pricemenu[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Pricemenu $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setMenu($this);
        }

        return $this;
    }

    public function removePrice(Pricemenu $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getMenu() === $this) {
                $price->setMenu(null);
            }
        }

        return $this;
    }
}
