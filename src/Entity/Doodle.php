<?php

namespace App\Entity;

use App\Repository\DoodleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoodleRepository::class)]
class Doodle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dateHash = null;

    #[ORM\OneToMany(mappedBy: 'idDoodle', targetEntity: UserDoodle::class, orphanRemoval: true)]
    private Collection $userDoodles;

    public function __construct()
    {
        $this->userDoodles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHash(): ?string
    {
        return $this->dateHash;
    }

    public function setDateHash(string $dateHash): self
    {
        $this->dateHash = $dateHash;

        return $this;
    }

    /**
     * @return Collection<int, UserDoodle>
     */
    public function getUserDoodles(): Collection
    {
        return $this->userDoodles;
    }

    public function addUserDoodle(UserDoodle $userDoodle): self
    {
        if (!$this->userDoodles->contains($userDoodle)) {
            $this->userDoodles->add($userDoodle);
            $userDoodle->setIdDoodle($this);
        }

        return $this;
    }

    public function removeUserDoodle(UserDoodle $userDoodle): self
    {
        if ($this->userDoodles->removeElement($userDoodle)) {
            // set the owning side to null (unless already changed)
            if ($userDoodle->getIdDoodle() === $this) {
                $userDoodle->setIdDoodle(null);
            }
        }

        return $this;
    }
}
