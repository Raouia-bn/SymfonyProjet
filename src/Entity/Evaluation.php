<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\OneToOne(targetEntity=Examen::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $examen;

    /**
     * @ORM\OneToOne(targetEntity=User2::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getExamen(): ?Examen
    {
        return $this->examen;
    }

    public function setExamen(Examen $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getCandidate(): ?User2
    {
        return $this->candidate;
    }

    public function setCandidate(User2 $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }
}
