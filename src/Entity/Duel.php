<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DuelRepository")
 */
class Duel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deelnemer", inversedBy="duels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deelnemer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wedstrijd", inversedBy="duels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wedstrijd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $winst;

    /**
     * @ORM\Column(type="integer")
     */
    private $ronde;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeelnemer(): ?Deelnemer
    {
        return $this->deelnemer;
    }

    public function setDeelnemer(?Deelnemer $deelnemer): self
    {
        $this->deelnemer = $deelnemer;

        return $this;
    }

    public function getWedstrijd(): ?Wedstrijd
    {
        return $this->wedstrijd;
    }

    public function setWedstrijd(?Wedstrijd $wedstrijd): self
    {
        $this->wedstrijd = $wedstrijd;

        return $this;
    }

    public function getWinst(): ?bool
    {
        return $this->winst;
    }

    public function setWinst(?bool $winst): self
    {
        $this->winst = $winst;

        return $this;
    }

    public function getRonde(): ?int
    {
        return $this->ronde;
    }

    public function setRonde(int $ronde): self
    {
        $this->ronde = $ronde;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
