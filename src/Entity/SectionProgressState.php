<?php

namespace App\Entity;

use App\Repository\SectionProgressStateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionProgressStateRepository::class)]
class SectionProgressState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $state = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sectionProgressStates')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'sectionProgressStates')]
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}
