<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'typeOfCategoria', targetEntity: Deportistas::class)]
    private Collection $deportistas;

    public function __construct()
    {
        $this->deportistas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getType();
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Deportistas>
     */
    public function getDeportistas(): Collection
    {
        return $this->deportistas;
    }

    public function addDeportista(Deportistas $deportista): self
    {
        if (!$this->deportistas->contains($deportista)) {
            $this->deportistas->add($deportista);
            $deportista->setTypeOfCategoria($this);
        }

        return $this;
    }

    public function removeDeportista(Deportistas $deportista): self
    {
        if ($this->deportistas->removeElement($deportista)) {
            // set the owning side to null (unless already changed)
            if ($deportista->getTypeOfCategoria() === $this) {
                $deportista->setTypeOfCategoria(null);
            }
        }

        return $this;
    }
}
