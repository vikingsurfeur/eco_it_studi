<?php

namespace App\Entity;

use App\Repository\QuizAnswerChoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizAnswerChoiceRepository::class)]
class QuizAnswerChoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $choiceDescription;

    #[ORM\Column(type: 'boolean')]
    private $isCorrectAnswer;

    #[ORM\ManyToOne(targetEntity: QuizQuestion::class, inversedBy: 'quizAnswerChoices')]
    private $quizQuestions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChoiceDescription(): ?string
    {
        return $this->choiceDescription;
    }

    public function setChoiceDescription(string $choiceDescription): self
    {
        $this->choiceDescription = $choiceDescription;

        return $this;
    }

    public function getIsCorrectAnswer(): ?bool
    {
        return $this->isCorrectAnswer;
    }

    public function setIsCorrectAnswer(bool $isCorrectAnswer): self
    {
        $this->isCorrectAnswer = $isCorrectAnswer;

        return $this;
    }

    public function getQuizQuestions(): ?QuizQuestion
    {
        return $this->quizQuestions;
    }

    public function setQuizQuestions(?QuizQuestion $quizQuestions): self
    {
        $this->quizQuestions = $quizQuestions;

        return $this;
    }
}
