<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $surname;

    #[ORM\Column(type: 'string', length: 255)]
    private $mail;

    #[ORM\Column(type: 'integer')]
    private $cost;

    #[ORM\Column(type: 'date')]
    private $hired;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Worktime::class)]
    private $worktimes;

    #[ORM\ManyToOne(targetEntity: Metier::class, inversedBy: 'employes')]
    private $job;

    public function __construct()
    {
        $this->worktimes = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getHired(): ?\DateTimeInterface
    {
        return $this->hired;
    }

    public function setHired(\DateTimeInterface $hired): self
    {
        $this->hired = $hired;

        return $this;
    }

    /**
     * @return Collection<int, Worktime>
     */
    public function getWorktimes(): Collection
    {
        return $this->worktimes;
    }

    public function addWorktime(Worktime $worktime): self
    {
        if (!$this->worktimes->contains($worktime)) {
            $this->worktimes[] = $worktime;
            $worktime->setEmploye($this);
        }

        return $this;
    }

    public function removeWorktime(Worktime $worktime): self
    {
        if ($this->worktimes->removeElement($worktime)) {
            // set the owning side to null (unless already changed)
            if ($worktime->getEmploye() === $this) {
                $worktime->setEmploye(null);
            }
        }

        return $this;
    }

    public function getJob(): ?metier
    {
        return $this->job;
    }

    public function setJob(?metier $job): self
    {
        $this->job = $job;

        return $this;
    }
}
