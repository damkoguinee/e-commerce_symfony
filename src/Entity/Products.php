<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $reference = null;

    #[ORM\Column(length: 150)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Epaisseurs $epaisseur = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Dimensions $dimension = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEpaisseur(): ?Epaisseurs
    {
        return $this->epaisseur;
    }

    public function setEpaisseur(?Epaisseurs $epaisseur): static
    {
        $this->epaisseur = $epaisseur;

        return $this;
    }

    public function getDimension(): ?Dimensions
    {
        return $this->dimension;
    }

    public function setDimension(?Dimensions $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }
}
