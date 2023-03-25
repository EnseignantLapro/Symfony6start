<?php

namespace App\Entity;

use App\Repository\WeekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeekRepository::class)]
class Week
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private array $calendrier = [];

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    private ?UserDoodle $idUserDoodle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalendrier(): array
    {
        return $this->calendrier;
    }

    public function setCalendrier(?array $calendrier): self
    {
        $this->calendrier = $calendrier;

        return $this;
    }

    public function getIdUserDoodle(): ?UserDoodle
    {
        return $this->idUserDoodle;
    }

    public function setIdUserDoodle(?UserDoodle $idUserDoodle): self
    {
        $this->idUserDoodle = $idUserDoodle;

        return $this;
    }
}
