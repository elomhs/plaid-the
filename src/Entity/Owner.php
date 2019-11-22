<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnerRepository")
 */
class Owner
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $familyName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="owner", orphanRemoval=true)
     */
    private $relroom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="roleOwner", cascade={"persist", "remove"})
     */
    private $role;

    public function __construct()
    {
        $this->relroom = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRelation(): Collection
    {
        return $this->relroom;
    }

    public function addRelation(Room $relation): self
    {
        if (!$this->relroom->contains($relation)) {
            $this->relroom[] = $relation;
            $relation->setOwner($this);
        }

        return $this;
    }

    public function removeRelation(Room $relation): self
    {
        if ($this->relroom->contains($relation)) {
            $this->relroom->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getOwner() === $this) {
                $relation->setOwner(null);
            }
        }

        return $this;
    }

    public function getRole(): ?User
    {
        return $this->role;
    }

    public function setRole(?User $role): self
    {
        $this->role = $role;

        return $this;
    }
}
