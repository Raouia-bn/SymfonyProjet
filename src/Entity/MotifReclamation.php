<?php

namespace App\Entity;

use App\Repository\MotifReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MotifReclamationRepository::class)
 */
class MotifReclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity=ReclamationCandFormat::class, mappedBy="motifReclamation")
     */
    private $reclamations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection|ReclamationCandFormat[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(ReclamationCandFormat $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setMotifReclamation($this);
        }

        return $this;
    }

    public function removeReclamation(ReclamationCandFormat $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getMotifReclamation() === $this) {
                $reclamation->setMotifReclamation(null);
            }
        }

        return $this;
    }
}
