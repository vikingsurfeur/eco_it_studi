<?php

namespace App\Entity;

use App\Repository\CourseProgressStateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseProgressStateRepository::class)]
class CourseProgressState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $state = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'courseProgressStates')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'courseProgressStates')]
    private $course;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }
}
