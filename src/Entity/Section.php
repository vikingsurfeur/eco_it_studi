<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private $course;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Lesson::class, orphanRemoval: true)]
    private $lessons;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private $user;

    #[ORM\ManyToMany(targetEntity: Progress::class, mappedBy: 'sections')]
    private $progress;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: SectionProgressState::class)]
    private $sectionProgressStates;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->progress = new ArrayCollection();
        $this->sectionProgressStates = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setSection($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getSection() === $this) {
                $lesson->setSection(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Progress>
     */
    public function getProgress(): Collection
    {
        return $this->progress;
    }

    public function addProgress(Progress $progress): self
    {
        if (!$this->progress->contains($progress)) {
            $this->progress[] = $progress;
            $progress->addSection($this);
        }

        return $this;
    }

    public function removeProgress(Progress $progress): self
    {
        if ($this->progress->removeElement($progress)) {
            $progress->removeSection($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, SectionProgressState>
     */
    public function getSectionProgressStates(): Collection
    {
        return $this->sectionProgressStates;
    }

    public function addSectionProgressState(SectionProgressState $sectionProgressState): self
    {
        if (!$this->sectionProgressStates->contains($sectionProgressState)) {
            $this->sectionProgressStates[] = $sectionProgressState;
            $sectionProgressState->setSection($this);
        }

        return $this;
    }

    public function removeSectionProgressState(SectionProgressState $sectionProgressState): self
    {
        if ($this->sectionProgressStates->removeElement($sectionProgressState)) {
            // set the owning side to null (unless already changed)
            if ($sectionProgressState->getSection() === $this) {
                $sectionProgressState->setSection(null);
            }
        }

        return $this;
    }
}
