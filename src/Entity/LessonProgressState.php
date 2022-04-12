<?php

namespace App\Entity;

use App\Repository\LessonProgressStateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonProgressStateRepository::class)]
class LessonProgressState
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $state = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'lessonProgressStates')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Lesson::class, inversedBy: 'lessonProgressStates')]
    private $lesson;

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

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }
}
