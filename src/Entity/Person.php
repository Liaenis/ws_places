<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, inversedBy="likedBy")
     */
    private $placesLiked;

    public function __construct()
    {
        $this->placesLiked = new ArrayCollection();
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlacesLiked(): Collection
    {
        return $this->placesLiked;
    }

    public function addPlacesLiked(Place $placesLiked): self
    {
        if (!$this->placesLiked->contains($placesLiked)) {
            $this->placesLiked[] = $placesLiked;
        }

        return $this;
    }

    public function removePlacesLiked(Place $placesLiked): self
    {
        $this->placesLiked->removeElement($placesLiked);

        return $this;
    }
}
