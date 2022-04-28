<?php

namespace App\Entity;

use App\Repository\RarityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RarityRepository::class)]
#[ORM\Table(name: 'rarities')]
class Rarity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $rarity_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $rarity_name;

    #[ORM\OneToMany(mappedBy: 'rarity', targetEntity: Product::class)]
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->rarity_id;
    }

    public function getRarityName(): ?string
    {
        return $this->rarity_name;
    }

    public function setRarityName(string $rarity_name): self
    {
        $this->rarity_name = $rarity_name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setRarity($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getRarity() === $this) {
                $product->setRarity(null);
            }
        }

        return $this;
    }
}
