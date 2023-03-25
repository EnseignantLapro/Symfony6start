<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: UserDoodle::class)]
    private Collection $userDoodles;

    public function __construct()
    {
        $this->userDoodles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

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
            $userDoodle->setIdUser($this);
        }

        return $this;
    }

    public function removeUserDoodle(UserDoodle $userDoodle): self
    {
        if ($this->userDoodles->removeElement($userDoodle)) {
            // set the owning side to null (unless already changed)
            if ($userDoodle->getIdUser() === $this) {
                $userDoodle->setIdUser(null);
            }
        }

        return $this;
    }
}
