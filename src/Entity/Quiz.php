<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'quizzes')]
    private $createdBy;

    #[ORM\OneToOne(targetEntity: Section::class, cascade: ['persist', 'remove'])]
    private $section;

    #[ORM\ManyToMany(targetEntity: QuizQuestion::class, mappedBy: 'quizs')]
    private $quizQuestions;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: UserQuizResult::class)]
    private $userQuizResults;

    public function __construct()
    {
        $this->quizQuestions = new ArrayCollection();
        $this->userQuizResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    /**
     * @return Collection<int, QuizQuestion>
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if (!$this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions[] = $quizQuestion;
            $quizQuestion->addQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if ($this->quizQuestions->removeElement($quizQuestion)) {
            $quizQuestion->removeQuiz($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserQuizResult>
     */
    public function getUserQuizResults(): Collection
    {
        return $this->userQuizResults;
    }

    public function addUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if (!$this->userQuizResults->contains($userQuizResult)) {
            $this->userQuizResults[] = $userQuizResult;
            $userQuizResult->setQuiz($this);
        }

        return $this;
    }

    public function removeUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if ($this->userQuizResults->removeElement($userQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($userQuizResult->getQuiz() === $this) {
                $userQuizResult->setQuiz(null);
            }
        }

        return $this;
    }
}
