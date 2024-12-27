<?php

namespace App\Entity;

use App\Repository\InscriFormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriFormationRepository::class)
 */
class InscriFormation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $NomFormation;

    /**
     * @ORM\OneToOne(targetEntity=Session::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\OneToOne(targetEntity=User2::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getNomFormation(): ?string
    {
        return $this->NomFormation;
    }

    public function setNomFormation(string $NomFormation): self
    {
        $this->NomFormation = $NomFormation;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(Session $session): self
    {
        $this->session = $session;

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
