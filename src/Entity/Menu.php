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
     * @ORM\ManyToMany(targetEntity="App\Entity\Assoc")
     */
    private $quantity;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
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
    public function getQuantity(): Collection
    {
        return $this->quantity;
    }

    public function addQuantity(Assoc $quantity): self
    {
        if (!$this->quantity->contains($quantity)) {
            $this->quantity[] = $quantity;
        }

        return $this;
    }

    public function removeQuantity(Assoc $quantity): self
    {
        if ($this->quantity->contains($quantity)) {
            $this->quantity->removeElement($quantity);
        }

        return $this;
    }
}
