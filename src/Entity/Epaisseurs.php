<?php

namespace App\Entity;

use App\Repository\EpaisseursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpaisseursRepository::class)]
class Epaisseurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $valeurEpaisseur = null;

    #[ORM\OneToMany(mappedBy: 'epaisseur', targetEntity: Products::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurEpaisseur(): ?float
    {
        return $this->valeurEpaisseur;
    }

    public function setValeurEpaisseur(float $valeurEpaisseur): static
    {
        $this->valeurEpaisseur = $valeurEpaisseur;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setEpaisseur($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getEpaisseur() === $this) {
                $product->setEpaisseur(null);
            }
        }

        return $this;
    }
}
