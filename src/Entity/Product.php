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
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="text")
     */
    private $composition;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="products")
     */
    private $type;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Allergen")
     */
    private $allergens;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
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
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function getComposition(): ?string
    {
        return $this->composition;
    }
    public function setComposition(string $composition): self
    {
        $this->composition = $composition;
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
    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @return Collection|Allergen[]
     */
    public function getAllergen(): Collection
    {
        return $this->allergens;
    }
    public function setAllergens(Collection $allergens ): self
    {
        $this->allergens = $allergens;
        return $this;
    }
    public function addAllergen(Allergen $allergen): self
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens[] = $allergen;
        }
        return $this;
    }
    public function removeAllergen(Allergen $allergen): self
    {
        if ($this->allergens->contains($allergen)) {
            $this->allergens->removeElement($allergen);
        }
        return $this;
    }
}
