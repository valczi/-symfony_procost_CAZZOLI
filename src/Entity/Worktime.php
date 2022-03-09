<?php

namespace App\Entity;

use App\Repository\WorktimeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorktimeRepository::class)]
class Worktime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Employe::class, inversedBy: 'worktimes')]
    #[ORM\JoinColumn(nullable: false)]
    private $employe;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'worktimes')]
    #[ORM\JoinColumn(nullable: false)]
    private $projet;

    #[ORM\Column(type: 'integer')]
    private $time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmploye(): ?employe
    {
        return $this->employe;
    }

    public function setEmploye(?employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getProjet(): ?project
    {
        return $this->projet;
    }

    public function setProjet(?project $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }
}
