<?php

namespace App\Entity;

use App\Repository\ProgressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgressRepository::class)]
class Progress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $courseFinished;

    #[ORM\Column(type: 'boolean')]
    private $sectionFinished;

    #[ORM\Column(type: 'boolean')]
    private $lessonFinished;

    #[ORM\ManyToMany(targetEntity: Course::class, inversedBy: 'progress')]
    private $courses;

    #[ORM\ManyToMany(targetEntity: Section::class, inversedBy: 'progress')]
    private $sections;

    #[ORM\ManyToMany(targetEntity: Lesson::class, inversedBy: 'progress')]
    private $lessons;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'progress')]
    private $users;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseFinished(): ?bool
    {
        return $this->courseFinished;
    }

    public function setCourseFinished(bool $courseFinished): self
    {
        $this->courseFinished = $courseFinished;

        return $this;
    }

    public function getSectionFinished(): ?bool
    {
        return $this->sectionFinished;
    }

    public function setSectionFinished(bool $sectionFinished): self
    {
        $this->sectionFinished = $sectionFinished;

        return $this;
    }

    public function getLessonFinished(): ?bool
    {
        return $this->lessonFinished;
    }

    public function setLessonFinished(bool $lessonFinished): self
    {
        $this->lessonFinished = $lessonFinished;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        $this->courses->removeElement($course);

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
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        $this->sections->removeElement($section);

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
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        $this->lessons->removeElement($lesson);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
