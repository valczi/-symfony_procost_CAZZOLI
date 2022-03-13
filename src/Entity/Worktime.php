<?php

namespace App\Entity;

use App\Repository\WorktimeRepository;
use DateTimeImmutable;
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

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt=new DateTimeImmutable();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
