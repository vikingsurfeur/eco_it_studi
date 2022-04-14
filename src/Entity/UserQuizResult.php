<?php

namespace App\Entity;

use App\Repository\UserQuizResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserQuizResultRepository::class)]
class UserQuizResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $nbGoodAnswer;

    #[ORM\Column(type: 'datetime')]
    private $answeredAt;

    #[ORM\Column(type: 'boolean')]
    private $isResolved;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userQuizResults')]
    private $isResolvedBy;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'userQuizResults')]
    private $quiz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbGoodAnswer(): ?int
    {
        return $this->nbGoodAnswer;
    }

    public function setNbGoodAnswer(int $nbGoodAnswer): self
    {
        $this->nbGoodAnswer = $nbGoodAnswer;

        return $this;
    }

    public function getAnsweredAt(): ?\DateTimeInterface
    {
        return $this->answeredAt;
    }

    public function setAnsweredAt(\DateTimeInterface $answeredAt): self
    {
        $this->answeredAt = $answeredAt;

        return $this;
    }

    public function getIsResolved(): ?bool
    {
        return $this->isResolved;
    }

    public function setIsResolved(bool $isResolved): self
    {
        $this->isResolved = $isResolved;

        return $this;
    }

    public function getIsResolvedBy(): ?User
    {
        return $this->isResolvedBy;
    }

    public function setIsResolvedBy(?User $isResolvedBy): self
    {
        $this->isResolvedBy = $isResolvedBy;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }
}
