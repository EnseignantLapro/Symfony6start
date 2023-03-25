<?php

namespace App\Entity;

use App\Repository\UserDoodleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDoodleRepository::class)]
class UserDoodle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userName = null;

    #[ORM\Column(length: 255)]
    private ?string $userColor = null;

    #[ORM\ManyToOne(inversedBy: 'userDoodles')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'userDoodles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doodle $idDoodle = null;

    #[ORM\OneToMany(mappedBy: 'idUserDoodle', targetEntity: Week::class)]
    private Collection $weeks;

    public function __construct()
    {
        $this->weeks = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserColor(): ?string
    {
        return $this->userColor;
    }

    public function setUserColor(string $userColor): self
    {
        $this->userColor = $userColor;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdDoodle(): ?Doodle
    {
        return $this->idDoodle;
    }

    public function setIdDoodle(?Doodle $idDoodle): self
    {
        $this->idDoodle = $idDoodle;

        return $this;
    }

    /**
     * @return Collection<int, Week>
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks->add($week);
            $week->setIdUserDoodle($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->removeElement($week)) {
            // set the owning side to null (unless already changed)
            if ($week->getIdUserDoodle() === $this) {
                $week->setIdUserDoodle(null);
            }
        }

        return $this;
    }

 
}
