<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $product_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $product_name;

    #[ORM\Column(type: 'integer')]
    private $product_price;

    #[ORM\ManyToOne(targetEntity: Rarity::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name:'rarity_id',referencedColumnName:"rarity_id",nullable:true)]
    private $rarity;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name:'type_id',referencedColumnName:"type_id",nullable:true)]
    private $type;

    public function getId(): ?int
    {
        return $this->product_id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->product_price;
    }

    public function setProductPrice(int $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function getRarity(): ?Rarity
    {
        return $this->rarity;
    }

    public function setRarity(?Rarity $rarity): self
    {
        $this->rarity = $rarity;

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
}
