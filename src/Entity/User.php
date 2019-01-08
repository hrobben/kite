<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deelnemer", mappedBy="userid")
     */
    private $deelnemers;

    public function __construct()
    {
        parent::__construct();
        $this->deelnemers = new ArrayCollection();
        // your own logic
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
            $deelnemer->setUserid($this);
        }

        return $this;
    }

    public function removeDeelnemer(Deelnemer $deelnemer): self
    {
        if ($this->deelnemers->contains($deelnemer)) {
            $this->deelnemers->removeElement($deelnemer);
            // set the owning side to null (unless already changed)
            if ($deelnemer->getUserid() === $this) {
                $deelnemer->setUserid(null);
            }
        }

        return $this;
    }
}