<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use http\Env\Response;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nomf;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbsessions;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="formation")
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="Formation")
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity=User2::class, inversedBy="formations")
     */
    private $user;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomf(): ?string
    {
        return $this->nomf;
    }

    public function setNomf(string $nomf): self
    {
        $this->nomf = $nomf;

        return $this;
    }

    public function getNbsessions(): ?int
    {
        return $this->nbsessions;
    }

    public function setNbsessions(?int $nbsessions): self
    {
        $this->nbsessions = $nbsessions;

        return $this;
    }

    /**
     * @return Collection|User2[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function setUser(?User2 $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setFormation($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormation() === $this) {
                $session->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setFormation($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getFormation() === $this) {
                $document->setFormation(null);
            }
        }

        return $this;
    }

    public function addUser(User2 $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User2 $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }
}
