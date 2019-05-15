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


    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Assoc")
     */
    private $assoc;

    public function __construct()
    {
        $this->quantity = new ArrayCollection();
        $this->assoc = new ArrayCollection();
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

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

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
        }

        return $this;
    }

    public function removeAssoc(Assoc $assoc): self
    {
        if ($this->assoc->contains($assoc)) {
            $this->assoc->removeElement($assoc);
        }

        return $this;
    }


}
