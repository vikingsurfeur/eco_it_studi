<?php

namespace App\Entity;

use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizQuestionRepository::class)]
class QuizQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $questionDescription;

    #[ORM\ManyToMany(targetEntity: Quiz::class, inversedBy: 'quizQuestions')]
    private $quizs;

    #[ORM\OneToMany(mappedBy: 'quizQuestions', targetEntity: QuizAnswerChoice::class)]
    private $quizAnswerChoices;

    public function __construct()
    {
        $this->quizs = new ArrayCollection();
        $this->quizAnswerChoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionDescription(): ?string
    {
        return $this->questionDescription;
    }

    public function setQuestionDescription(string $questionDescription): self
    {
        $this->questionDescription = $questionDescription;

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizs(): Collection
    {
        return $this->quizs;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizs->contains($quiz)) {
            $this->quizs[] = $quiz;
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        $this->quizs->removeElement($quiz);

        return $this;
    }

    /**
     * @return Collection<int, QuizAnswerChoice>
     */
    public function getQuizAnswerChoices(): Collection
    {
        return $this->quizAnswerChoices;
    }

    public function addQuizAnswerChoice(QuizAnswerChoice $quizAnswerChoice): self
    {
        if (!$this->quizAnswerChoices->contains($quizAnswerChoice)) {
            $this->quizAnswerChoices[] = $quizAnswerChoice;
            $quizAnswerChoice->setQuizQuestions($this);
        }

        return $this;
    }

    public function removeQuizAnswerChoice(QuizAnswerChoice $quizAnswerChoice): self
    {
        if ($this->quizAnswerChoices->removeElement($quizAnswerChoice)) {
            // set the owning side to null (unless already changed)
            if ($quizAnswerChoice->getQuizQuestions() === $this) {
                $quizAnswerChoice->setQuizQuestions(null);
            }
        }

        return $this;
    }
}
