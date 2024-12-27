<?php

namespace App\Entity;

use App\Repository\ReclamationCandFormatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReclamationCandFormatRepository::class)
 */
class ReclamationCandFormat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=MotifReclamation::class, inversedBy="reclamations")
     */
    private $motifReclamation;

    /**
     * @ORM\OneToOne(targetEntity=User2::class, cascade={"persist", "remove"})
     */
    private $candidat;

    /**
     * @ORM\OneToOne(targetEntity=User2::class, cascade={"persist", "remove"})
     */
    private $formateur;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMotifReclamation(): ?MotifReclamation
    {
        return $this->motifReclamation;
    }

    public function setMotifReclamation(?MotifReclamation $motifReclamation): self
    {
        $this->motifReclamation = $motifReclamation;

        return $this;
    }

    public function getCandidat(): ?User2
    {
        return $this->candidat;
    }

    public function setCandidat(?User2 $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getFormateur(): ?User2
    {
        return $this->formateur;
    }

    public function setFormateur(?User2 $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }
}
