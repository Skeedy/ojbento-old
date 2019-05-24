<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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

    public function __construct()
    {
        $this->assocs = new ArrayCollection();
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

    public function addAssoc(Assoc $assoc): self
    {
        if (!$this->assocs->contains($assoc)) {
            $this->assocs[] = $assoc;
            $assoc->setProduct($this);
        }

        return $this;
    }

    public function removeAssoc(Assoc $assoc): self
    {
        if ($this->assocs->contains($assoc)) {
            $this->assocs->removeElement($assoc);
            // set the owning side to null (unless already changed)
            if ($assoc->getProduct() === $this) {
                $assoc->setProduct(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
}
