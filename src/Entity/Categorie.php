<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
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
    private $omschrijving;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Wedstrijd", mappedBy="categorieId")
     */
    private $wedstrijden;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deelnemer", mappedBy="categorieid")
     */
    private $deelnemers;

    public function __construct()
    {
        $this->wedstrijden = new ArrayCollection();
        $this->deelnemers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * @return Collection|Wedstrijd[]
     */
    public function getWedstrijden(): Collection
    {
        return $this->wedstrijden;
    }

    public function addWedstrijden(Wedstrijd $wedstrijden): self
    {
        if (!$this->wedstrijden->contains($wedstrijden)) {
            $this->wedstrijden[] = $wedstrijden;
            $wedstrijden->setCategorieId($this);
        }

        return $this;
    }

    public function removeWedstrijden(Wedstrijd $wedstrijden): self
    {
        if ($this->wedstrijden->contains($wedstrijden)) {
            $this->wedstrijden->removeElement($wedstrijden);
            // set the owning side to null (unless already changed)
            if ($wedstrijden->getCategorieId() === $this) {
                $wedstrijden->setCategorieId(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId().' -> '.$this->getOmschrijving();
    }

    /**
     * @return Collection|Deelnemer[]
     */
    public function getDeelnemers(): Collection
    {
        return $this->deelnemers;
    }

    public function addDeelnemer(Deelnemer $deelnemer): self
    {
        if (!$this->deelnemers->contains($deelnemer)) {
            $this->deelnemers[] = $deelnemer;
            $deelnemer->setCategorieid($this);
        }

        return $this;
    }

    public function removeDeelnemer(Deelnemer $deelnemer): self
    {
        if ($this->deelnemers->contains($deelnemer)) {
            $this->deelnemers->removeElement($deelnemer);
            // set the owning side to null (unless already changed)
            if ($deelnemer->getCategorieid() === $this) {
                $deelnemer->setCategorieid(null);
            }
        }

        return $this;
    }
}
