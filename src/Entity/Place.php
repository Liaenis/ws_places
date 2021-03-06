<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups("person:read")
     * @Groups("place:read")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("person:read")
     * @Groups("place:read")
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class, mappedBy="placesLiked")
     * @Groups("place:read")
     */
    private $likedBy;

    public function __construct()
    {
        $this->likedBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    public function addLikedBy(Person $likedBy): self
    {
        if (!$this->likedBy->contains($likedBy)) {
            $this->likedBy[] = $likedBy;
            $likedBy->addPlacesLiked($this);
        }

        return $this;
    }

    public function removeLikedBy(Person $likedBy): self
    {
        if ($this->likedBy->removeElement($likedBy)) {
            $likedBy->removePlacesLiked($this);
        }

        return $this;
    }
}
