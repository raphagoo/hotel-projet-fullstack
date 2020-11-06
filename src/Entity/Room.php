<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPerson;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="rooms")
     */
    private $supplement;

    /**
     * @ORM\ManyToMany(targetEntity=Booking::class, inversedBy="rooms")
     */
    private $booking;

    public function __construct()
    {
        $this->supplement = new ArrayCollection();
        $this->booking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getNbPerson(): ?int
    {
        return $this->nbPerson;
    }

    public function setNbPerson(int $nbPerson): self
    {
        $this->nbPerson = $nbPerson;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getSupplement(): Collection
    {
        return $this->supplement;
    }

    public function addSupplement(Option $supplement): self
    {
        if (!$this->supplement->contains($supplement)) {
            $this->supplement[] = $supplement;
        }

        return $this;
    }

    public function removeSupplement(Option $supplement): self
    {
        $this->supplement->removeElement($supplement);

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->booking->contains($booking)) {
            $this->booking[] = $booking;
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        $this->booking->removeElement($booking);

        return $this;
    }
}
