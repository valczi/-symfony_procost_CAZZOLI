<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 2500)]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $cost;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

  /**
   * @ORM\Column(type="datetime_immutable", options={"default"=false})
   */
    private $DeliveredAt;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: Worktime::class)]
    private $worktimes;

    public function __construct()
    {
        $this->worktimes = new ArrayCollection();
        $this->createdAt=new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeImmutable
    {
        return $this->DeliveredAt;
    }

    public function setDeliveredAt(\DateTimeImmutable $DeliveredAt): self
    {
        $this->DeliveredAt = $DeliveredAt;

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
            $worktime->setProjet($this);
        }

        return $this;
    }

    public function removeWorktime(Worktime $worktime): self
    {
        if ($this->worktimes->removeElement($worktime)) {
            // set the owning side to null (unless already changed)
            if ($worktime->getProjet() === $this) {
                $worktime->setProjet(null);
            }
        }

        return $this;
    }
}
