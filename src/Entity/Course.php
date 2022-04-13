<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToOne(targetEntity: Image::class, inversedBy: 'course', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: Section::class, orphanRemoval: true)]
    private $sections;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'courses')]
    private $tags;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'learnersCourses')]
    private $learners;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseProgressState::class)]
    private $courseProgressStates;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: UserProgressState::class)]
    private $userProgressStates;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->learners = new ArrayCollection();
        $this->courseProgressStates = new ArrayCollection();
        $this->userProgressStates = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setCourse($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getCourse() === $this) {
                $section->setCourse(null);
            }
        }

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

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLearners(): Collection
    {
        return $this->learners;
    }

    public function addLearner(User $learner): self
    {
        if (!$this->learners->contains($learner)) {
            $this->learners[] = $learner;
        }

        return $this;
    }

    public function removeLearner(User $learner): self
    {
        $this->learners->removeElement($learner);

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, CourseProgressState>
     */
    public function getCourseProgressStates(): Collection
    {
        return $this->courseProgressStates;
    }

    public function addCourseProgressState(CourseProgressState $courseProgressState): self
    {
        if (!$this->courseProgressStates->contains($courseProgressState)) {
            $this->courseProgressStates[] = $courseProgressState;
            $courseProgressState->setCourse($this);
        }

        return $this;
    }

    public function removeCourseProgressState(CourseProgressState $courseProgressState): self
    {
        if ($this->courseProgressStates->removeElement($courseProgressState)) {
            // set the owning side to null (unless already changed)
            if ($courseProgressState->getCourse() === $this) {
                $courseProgressState->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserProgressState>
     */
    public function getUserProgressStates(): Collection
    {
        return $this->userProgressStates;
    }

    public function addUserProgressState(UserProgressState $userProgressState): self
    {
        if (!$this->userProgressStates->contains($userProgressState)) {
            $this->userProgressStates[] = $userProgressState;
            $userProgressState->setCourse($this);
        }

        return $this;
    }

    public function removeUserProgressState(UserProgressState $userProgressState): self
    {
        if ($this->userProgressStates->removeElement($userProgressState)) {
            // set the owning side to null (unless already changed)
            if ($userProgressState->getCourse() === $this) {
                $userProgressState->setCourse(null);
            }
        }

        return $this;
    }
}